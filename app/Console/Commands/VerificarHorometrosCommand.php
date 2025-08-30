<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificacionService;
use App\Models\Maquinaria;
use Carbon\Carbon;

class VerificarHorometrosCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notificaciones:verificar-horometros 
                            {--maquinaria= : ID de máquina específica}
                            {--force : Forzar envío ignorando restricciones}
                            {--dry-run : Simular sin enviar notificaciones}
                            {--quiet : Modo silencioso}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar horómetros de maquinarias y enviar notificaciones según umbrales';

    protected $notificacionService;

    /**
     * Create a new command instance.
     */
    public function __construct(NotificacionService $notificacionService)
    {
        parent::__construct();
        $this->notificacionService = $notificacionService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Iniciando verificación de horómetros...');
        $this->info('Hora: ' . Carbon::now()->format('Y-m-d H:i:s'));
        $this->line('----------------------------------------');

        $startTime = microtime(true);
        $notificacionesEnviadas = 0;
        $maquinasRevisadas = 0;
        $alertasCriticas = 0;

        try {
            // Si se especifica una máquina
            if ($maquinariaId = $this->option('maquinaria')) {
                $maquinaria = Maquinaria::find($maquinariaId);
                
                if (!$maquinaria) {
                    $this->error("❌ Maquinaria con ID {$maquinariaId} no encontrada");
                    return 1;
                }
                
                $this->info("Verificando: {$maquinaria->nombre}");
                $resultado = $this->verificarMaquinaria($maquinaria);
                
                $notificacionesEnviadas += $resultado['notificaciones'];
                $alertasCriticas += $resultado['criticas'];
                $maquinasRevisadas = 1;
                
            } else {
                // Verificar todas las máquinas activas
                $maquinarias = Maquinaria::where('estado', 'activo')->get();
                
                $this->info("📊 Total de maquinarias activas: " . $maquinarias->count());
                $this->line('');
                
                $bar = $this->output->createProgressBar($maquinarias->count());
                $bar->start();
                
                foreach ($maquinarias as $maquinaria) {
                    $resultado = $this->verificarMaquinaria($maquinaria);
                    
                    $notificacionesEnviadas += $resultado['notificaciones'];
                    $alertasCriticas += $resultado['criticas'];
                    $maquinasRevisadas++;
                    
                    $bar->advance();
                }
                
                $bar->finish();
                $this->line('');
            }
            
            // Resumen
            $this->line('');
            $this->line('========================================');
            $this->info('✅ VERIFICACIÓN COMPLETADA');
            $this->line('========================================');
            
            $executionTime = round(microtime(true) - $startTime, 2);
            
            $this->table(
                ['Métrica', 'Valor'],
                [
                    ['Máquinas revisadas', $maquinasRevisadas],
                    ['Notificaciones enviadas', $notificacionesEnviadas],
                    ['Alertas críticas', $alertasCriticas],
                    ['Tiempo de ejecución', "{$executionTime} segundos"],
                ]
            );
            
            // Si hay alertas críticas, mostrar advertencia
            if ($alertasCriticas > 0) {
                $this->line('');
                $this->warn("⚠️  HAY {$alertasCriticas} ALERTAS CRÍTICAS QUE REQUIEREN ATENCIÓN INMEDIATA");
            }
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Error durante la verificación: ' . $e->getMessage());
            $this->error('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }
    }

    /**
     * Verificar una máquina específica
     */
    private function verificarMaquinaria(Maquinaria $maquinaria)
    {
        $notificacionesEnviadas = 0;
        $alertasCriticas = 0;
        
        foreach ($maquinaria->pautas as $pauta) {
            $ultimaMantencion = $pauta->pivot->ultima_mantencion_horas ?? 0;
            $proximaMantencion = $ultimaMantencion + $pauta->frecuencia_horas;
            $horasRestantes = $proximaMantencion - $maquinaria->horometro_actual;
            
            // Determinar si necesita notificación
            $necesitaNotificacion = false;
            $tipoNotificacion = null;
            $emoji = '';
            
            if ($horasRestantes <= 0) {
                $necesitaNotificacion = true;
                $tipoNotificacion = 'CRÍTICA - VENCIDA';
                $emoji = '🔴';
                $alertasCriticas++;
            } elseif ($horasRestantes <= 24) {
                $necesitaNotificacion = true;
                $tipoNotificacion = 'CRÍTICA - MUY PRÓXIMA';
                $emoji = '🟠';
                $alertasCriticas++;
            } elseif ($horasRestantes <= 50) {
                $necesitaNotificacion = true;
                $tipoNotificacion = 'PREVENTIVA - PRÓXIMA';
                $emoji = '🟡';
            } elseif ($horasRestantes <= 100) {
                $necesitaNotificacion = true;
                $tipoNotificacion = 'PREVENTIVA';
                $emoji = '🟢';
            }
            
            if ($necesitaNotificacion) {
                if (!$this->option('quiet')) {
                    $this->line('');
                    $this->line("{$emoji} {$maquinaria->nombre} - {$pauta->nombre}");
                    $this->line("   Horómetro: {$maquinaria->horometro_actual} hrs");
                    $this->line("   Horas restantes: {$horasRestantes} hrs");
                    $this->line("   Tipo: {$tipoNotificacion}");
                }
                
                // Enviar notificación si no está en modo dry-run
                if (!$this->option('dry-run')) {
                    try {
                        $this->notificacionService->evaluarMaquinaria($maquinaria);
                        $notificacionesEnviadas++;
                        
                        if (!$this->option('quiet')) {
                            $this->info("   ✓ Notificación enviada");
                        }
                    } catch (\Exception $e) {
                        $this->error("   ✗ Error enviando notificación: " . $e->getMessage());
                    }
                }
            }
        }
        
        return [
            'notificaciones' => $notificacionesEnviadas,
            'criticas' => $alertasCriticas
        ];
    }
}
