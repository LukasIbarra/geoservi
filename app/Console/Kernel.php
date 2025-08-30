<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // ========================================
        // SISTEMA DE NOTIFICACIONES AUTOMÁTICAS
        // ========================================
        
        // 1. Verificar horómetros cada hora (horario laboral)
        $schedule->command('notificaciones:verificar-horometros')
            ->hourly()
            ->between('6:00', '22:00')
            ->weekdays()
            ->withoutOverlapping()
            ->runInBackground()
            ->appendOutputTo(storage_path('logs/horometros.log'))
            ->emailOutputOnFailure('mantenimiento@geoservi.cl');
        
        // 2. Verificación adicional en fines de semana (menos frecuente)
        $schedule->command('notificaciones:verificar-horometros')
            ->everySixHours()
            ->weekends()
            ->withoutOverlapping()
            ->runInBackground();
        
        // 3. Verificación crítica temprano en la mañana
        $schedule->command('notificaciones:verificar-horometros --force')
            ->dailyAt('07:00')
            ->withoutOverlapping()
            ->runInBackground();
        
        // 4. Resumen diario para supervisores
        $schedule->command('notificaciones:resumen-diario')
            ->dailyAt('07:30')
            ->weekdays()
            ->runInBackground();
        
        // 5. Reporte semanal los lunes
        $schedule->command('notificaciones:reporte-semanal')
            ->weeklyOn(1, '08:00')
            ->runInBackground();
        
        // 6. Reenviar notificaciones críticas no atendidas
        $schedule->command('notificaciones:reenviar-criticas')
            ->everyTwoHours()
            ->between('8:00', '20:00')
            ->withoutOverlapping()
            ->runInBackground();
        
        // 7. Limpieza de notificaciones antiguas (mensual)
        $schedule->command('notificaciones:limpiar-antiguas')
            ->monthlyOn(1, '03:00')
            ->runInBackground();
        
        // ========================================
        // OTRAS TAREAS PROGRAMADAS
        // ========================================
        
        // Backup de base de datos (diario)
        // $schedule->command('backup:run')->daily()->at('02:00');
        
        // Limpiar logs antiguos
        // $schedule->command('log:clear')->weekly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
