@extends('layouts.admin')

@section('title', 'Dashboard - Sistema de Mantenimiento Minero')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Barra de herramientas mejorada -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-white mb-2">Dashboard de Mantenimiento</h1>
            <p class="text-gray-400 text-sm">Monitoreo en tiempo real del sistema de mantenimiento minero</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <button onclick="exportarPDF()" class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white px-6 py-3 rounded-xl flex items-center justify-center transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-red-500/25">
                <i class="fas fa-file-pdf mr-2"></i>
                <span class="hidden sm:inline">Exportar PDF</span>
                <span class="sm:hidden">PDF</span>
            </button>
            <button onclick="location.reload()" class="bg-gradient-to-r from-zinc-700 to-zinc-800 hover:from-zinc-800 hover:to-zinc-900 text-white px-6 py-3 rounded-xl flex items-center justify-center transition-all duration-200 transform hover:scale-105 shadow-lg">
                <i class="fas fa-sync-alt mr-2"></i>
                <span class="hidden sm:inline">Actualizar</span>
                <span class="sm:hidden">Refresh</span>
            </button>
        </div>
    </div>

    <!-- KPIs Principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Disponibilidad de Flota -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium">Disponibilidad Flota</p>
                    <p class="text-4xl font-bold mt-2">{{ $disponibilidad }}%</p>
                    <p class="text-green-100 text-xs mt-1">
                        {{ $maquinariasActivas }} de {{ $totalMaquinarias }} activas
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-chart-pie text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Cumplimiento de Mantenimientos -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Cumplimiento</p>
                    <p class="text-4xl font-bold mt-2">{{ $tasaCumplimiento }}%</p>
                    <p class="text-blue-100 text-xs mt-1">
                        {{ $mantenimientosCompletadosHoy }} completados hoy
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-tasks text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Alertas Críticas -->
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium">Alertas Críticas</p>
                    <p class="text-4xl font-bold mt-2">{{ $maquinasCriticas }}</p>
                    <p class="text-red-100 text-xs mt-1">
                        Requieren atención inmediata
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-3 animate-pulse">
                    <i class="fas fa-exclamation-triangle text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Órdenes Pendientes -->
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium">Pendientes</p>
                    <p class="text-4xl font-bold mt-2">{{ $mantenimientosPendientes }}</p>
                    <p class="text-orange-100 text-xs mt-1">
                        {{ $mantenimientosEnProceso }} en proceso
                    </p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-clock text-3xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Segunda fila de métricas mejorada -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <!-- Total Maquinarias -->
        <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-xl shadow-lg p-5 border border-zinc-700 hover:border-orange-500/30 transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">Total Maquinarias</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $totalMaquinarias }}</p>
                    <p class="text-gray-500 text-xs mt-1">Equipos registrados</p>
                </div>
                <div class="bg-orange-500/20 rounded-full p-3 ml-4">
                    <i class="fas fa-truck-monster text-2xl text-orange-400"></i>
                </div>
            </div>
        </div>

        <!-- Usuarios Sistema -->
        <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-xl shadow-lg p-5 border border-zinc-700 hover:border-blue-500/30 transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">Usuarios</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $totalUsuarios }}</p>
                    <p class="text-gray-500 text-xs mt-1">Activos en sistema</p>
                </div>
                <div class="bg-blue-500/20 rounded-full p-3 ml-4">
                    <i class="fas fa-users text-2xl text-blue-400"></i>
                </div>
            </div>
        </div>

        <!-- Técnicos Activos -->
        <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-xl shadow-lg p-5 border border-zinc-700 hover:border-green-500/30 transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">Técnicos</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $tecnicosActivos }}</p>
                    <p class="text-gray-500 text-xs mt-1">Disponibles</p>
                </div>
                <div class="bg-green-500/20 rounded-full p-3 ml-4">
                    <i class="fas fa-hard-hat text-2xl text-green-400"></i>
                </div>
            </div>
        </div>

        <!-- Mantenimientos del Mes -->
        <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-xl shadow-lg p-5 border border-zinc-700 hover:border-purple-500/30 transition-all duration-300 transform hover:scale-105">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">Este Mes</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ $mantenimientosMes }}</p>
                    <p class="text-gray-500 text-xs mt-1">Mantenimientos realizados</p>
                </div>
                <div class="bg-purple-500/20 rounded-full p-3 ml-4">
                    <i class="fas fa-calendar-check text-2xl text-purple-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sección de Horómetros Críticos -->
    <div class="bg-zinc-800 rounded-xl shadow-lg p-6 mb-6 border border-zinc-700">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-tachometer-alt mr-2 text-orange-400"></i>
                Control de Horómetros - Estado Crítico
            </h3>
            <span class="text-xs text-gray-400">Actualizado en tiempo real</span>
        </div>
        
        <div class="space-y-3">
            @foreach($maquinariasConHorometro->take(5) as $maquina)
            <div class="bg-zinc-900 rounded-lg p-4 border border-zinc-700">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center
                            {{ $maquina['estado_alerta'] == 'critical' ? 'bg-red-500/20' : '' }}
                            {{ $maquina['estado_alerta'] == 'warning' ? 'bg-yellow-500/20' : '' }}
                            {{ $maquina['estado_alerta'] == 'normal' ? 'bg-green-500/20' : '' }}">
                            <i class="fas fa-cog 
                                {{ $maquina['estado_alerta'] == 'critical' ? 'text-red-400 animate-spin' : '' }}
                                {{ $maquina['estado_alerta'] == 'warning' ? 'text-yellow-400' : '' }}
                                {{ $maquina['estado_alerta'] == 'normal' ? 'text-green-400' : '' }}"></i>
                        </div>
                        <div>
                            <p class="font-semibold text-white">{{ $maquina['nombre'] }}</p>
                            <p class="text-xs text-gray-400">{{ $maquina['tipo'] }} • Próxima: {{ $maquina['proxima_pauta'] }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl font-bold 
                            {{ $maquina['estado_alerta'] == 'critical' ? 'text-red-400' : '' }}
                            {{ $maquina['estado_alerta'] == 'warning' ? 'text-yellow-400' : '' }}
                            {{ $maquina['estado_alerta'] == 'normal' ? 'text-green-400' : '' }}">
                            {{ number_format($maquina['horometro_actual']) }} hrs
                        </p>
                        <p class="text-xs 
                            {{ $maquina['horas_restantes'] <= 50 ? 'text-red-400' : '' }}
                            {{ $maquina['horas_restantes'] > 50 && $maquina['horas_restantes'] <= 100 ? 'text-yellow-400' : '' }}
                            {{ $maquina['horas_restantes'] > 100 ? 'text-gray-400' : '' }}">
                            @if($maquina['horas_restantes'] > 0)
                                Faltan {{ $maquina['horas_restantes'] }} hrs
                            @else
                                <span class="text-red-500 font-bold">VENCIDO</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                <!-- Barra de progreso -->
                <div class="mt-3">
                    <div class="flex justify-between text-xs text-gray-400 mb-1">
                        <span>Uso del ciclo</span>
                        <span>{{ $maquina['porcentaje_uso'] }}%</span>
                    </div>
                    <div class="w-full bg-zinc-700 rounded-full h-2">
                        @php
                            $progressClass = '';
                            if ($maquina['porcentaje_uso'] >= 95) {
                                $progressClass = 'bg-gradient-to-r from-red-500 to-red-600';
                            } elseif ($maquina['porcentaje_uso'] >= 80) {
                                $progressClass = 'bg-gradient-to-r from-yellow-500 to-orange-500';
                            } else {
                                $progressClass = 'bg-gradient-to-r from-green-500 to-green-600';
                            }
                        @endphp
                        <div class="h-2 rounded-full transition-all duration-500 {{ $progressClass }}"
                            style="width: {{ min(100, $maquina['porcentaje_uso']) }}%">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Gráficos principales mejorados -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Gráfico de Estado de Flota -->
        <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-xl shadow-lg p-6 border border-zinc-700 hover:border-blue-500/30 transition-all duration-300">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-chart-pie mr-2 text-blue-400"></i>
                Estado de la Flota
            </h3>
            <div style="height: 280px; position: relative;">
                <canvas id="estadoFlotaChart"></canvas>
            </div>
        </div>

        <!-- Gráfico de Tendencia de Mantenimientos -->
        <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-xl shadow-lg p-6 border border-zinc-700 hover:border-green-500/30 transition-all duration-300">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-chart-line mr-2 text-green-400"></i>
                Tendencia de Mantenimientos (6 meses)
            </h3>
            <div style="height: 280px; position: relative;">
                <canvas id="tendenciaChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Gráfico de barras y actividades mejorados -->
    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6 mb-8">
        <!-- Mantenimientos por Tipo de Máquina -->
        <div class="xl:col-span-3 bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-xl shadow-lg p-6 border border-zinc-700 hover:border-purple-500/30 transition-all duration-300">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-chart-bar mr-2 text-purple-400"></i>
                Mantenimientos por Tipo de Máquina (Este mes)
            </h3>
            <div style="height: 250px; position: relative;">
                <canvas id="tipoMaquinaChart"></canvas>
            </div>
        </div>

        <!-- Actividades Recientes -->
        <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-xl shadow-lg p-6 border border-zinc-700 hover:border-orange-500/30 transition-all duration-300">
            <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
                <i class="fas fa-history mr-2 text-orange-400"></i>
                Actividad Reciente
            </h3>
            <div class="space-y-3 max-h-80 overflow-y-auto custom-scrollbar">
                @forelse($actividadesRecientes as $actividad)
                <div class="flex items-start space-x-3 p-3 bg-zinc-900/50 rounded-lg border border-zinc-700 hover:border-orange-500/50 transition-all duration-200 hover:bg-zinc-800/50 hover:scale-102">
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center bg-zinc-800">
                            <i class="{{ $actividad['icon'] }} {{ $actividad['color'] }} text-sm"></i>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm text-gray-300 font-medium">{{ $actividad['mensaje'] }}</p>
                        @if(isset($actividad['detalles']) && $actividad['detalles'])
                        <p class="text-xs text-gray-500 mt-1">{{ $actividad['detalles'] }}</p>
                        @endif
                        <div class="flex items-center mt-2 text-xs text-gray-500">
                            <i class="fas fa-user mr-1"></i>
                            <span class="mr-3">{{ $actividad['tecnico'] ?? 'Sistema' }}</span>
                            <i class="fas fa-clock mr-1"></i>
                            <span>{{ $actividad['tiempo'] }}</span>
                        </div>
                        @if(isset($actividad['tipo']))
                        <span class="inline-block mt-2 px-2 py-1 text-xs bg-zinc-700 text-gray-400 rounded">
                            {{ str_replace('_', ' ', ucfirst($actividad['tipo'])) }}
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    <i class="fas fa-inbox text-3xl mb-3"></i>
                    <p>No hay actividades recientes</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Próximos Mantenimientos Programados - Responsive -->
    <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 rounded-xl shadow-lg p-6 border border-zinc-700 hover:border-yellow-500/30 transition-all duration-300">
        <h3 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-calendar-alt mr-2 text-yellow-400"></i>
            Próximos Mantenimientos Programados
        </h3>

        <!-- Vista de tabla para desktop -->
        <div class="hidden md:block overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="border-b border-zinc-700">
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Maquinaria
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Tipo
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Pauta
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Horómetro Actual
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Horas Restantes
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-700">
                    @forelse($proximosMantenimientos as $mantenimiento)
                    <tr class="hover:bg-zinc-700/50 transition-colors">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-orange-500/20 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-cog text-orange-400 text-xs"></i>
                                </div>
                                <span class="text-sm font-medium text-white">
                                    {{ $mantenimiento->maquinaria->nombre ?? 'N/A' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-400">
                            {{ $mantenimiento->maquinaria->tipo ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-400">
                            {{ $mantenimiento->pauta->nombre ?? 'Sin pauta' }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-300">
                            {{ number_format($mantenimiento->maquinaria->horometro_actual ?? 0) }} hrs
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($mantenimiento->horas_restantes <= 50)
                                <span class="text-sm font-bold text-red-400">
                                    {{ $mantenimiento->horas_restantes }} hrs
                                </span>
                            @elseif($mantenimiento->horas_restantes <= 100)
                                <span class="text-sm font-bold text-yellow-400">
                                    {{ $mantenimiento->horas_restantes }} hrs
                                </span>
                            @else
                                <span class="text-sm text-green-400">
                                    {{ $mantenimiento->horas_restantes }} hrs
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400">
                                Pendiente
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.ordenes.show', $mantenimiento->id) }}"
                               class="text-orange-400 hover:text-orange-300 transition-colors">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                            No hay mantenimientos programados
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Vista de tarjetas para móvil -->
        <div class="md:hidden space-y-4">
            @forelse($proximosMantenimientos as $mantenimiento)
            <div class="bg-zinc-900/50 rounded-lg p-4 border border-zinc-700 hover:border-orange-500/30 transition-all duration-200">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-orange-500/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-cog text-orange-400 text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">{{ $mantenimiento->maquinaria->nombre ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-400">{{ $mantenimiento->maquinaria->tipo ?? 'N/A' }}</p>
                        </div>
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full bg-yellow-500/20 text-yellow-400">
                        Pendiente
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Pauta</p>
                        <p class="text-sm text-gray-300">{{ $mantenimiento->pauta->nombre ?? 'Sin pauta' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Horómetro</p>
                        <p class="text-sm text-gray-300">{{ number_format($mantenimiento->maquinaria->horometro_actual ?? 0) }} hrs</p>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Horas Restantes</p>
                        @if($mantenimiento->horas_restantes <= 50)
                            <p class="text-sm font-bold text-red-400">{{ $mantenimiento->horas_restantes }} hrs</p>
                        @elseif($mantenimiento->horas_restantes <= 100)
                            <p class="text-sm font-bold text-yellow-400">{{ $mantenimiento->horas_restantes }} hrs</p>
                        @else
                            <p class="text-sm text-green-400">{{ $mantenimiento->horas_restantes }} hrs</p>
                        @endif
                    </div>
                    <a href="{{ route('admin.ordenes.show', $mantenimiento->id) }}"
                       class="bg-orange-500/20 hover:bg-orange-500/30 text-orange-400 px-3 py-2 rounded-lg transition-colors">
                        <i class="fas fa-eye"></i>
                    </a>
                </div>
            </div>
            @empty
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-calendar-times text-3xl mb-3"></i>
                <p>No hay mantenimientos programados</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #27272a;
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #52525b;
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #71717a;
}
</style>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Función para exportar a PDF
function exportarPDF() {
    // Mostrar indicador de carga
    const boton = event.target.closest('button');
    const textoOriginal = boton.innerHTML;
    boton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Generando PDF...';
    boton.disabled = true;
    
    // Hacer la petición para generar el PDF
    window.location.href = '{{ route("admin.dashboard.pdf") }}';
    
    // Restaurar el botón después de un tiempo
    setTimeout(() => {
        boton.innerHTML = textoOriginal;
        boton.disabled = false;
    }, 3000);
}

// Configuración global para los gráficos
Chart.defaults.color = '#9ca3af';
Chart.defaults.borderColor = '#3f3f46';

// Gráfico de Estado de Flota (Pie/Doughnut)
const ctxEstado = document.getElementById('estadoFlotaChart').getContext('2d');
new Chart(ctxEstado, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($distribucionEstados)) !!},
        datasets: [{
            data: {!! json_encode(array_values($distribucionEstados)) !!},
            backgroundColor: [
                'rgba(34, 197, 94, 0.8)',  // Verde para Activas
                'rgba(251, 146, 60, 0.8)',  // Naranja para Mantenimiento
                'rgba(239, 68, 68, 0.8)'    // Rojo para Inactivas
            ],
            borderColor: [
                'rgba(34, 197, 94, 1)',
                'rgba(251, 146, 60, 1)',
                'rgba(239, 68, 68, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: {
                        size: 12
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += context.parsed + ' máquinas';
                        return label;
                    }
                }
            }
        }
    }
});

// Gráfico de Tendencia de Mantenimientos (Línea)
const ctxTendencia = document.getElementById('tendenciaChart').getContext('2d');
new Chart(ctxTendencia, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($tendenciaMantenimientos, 'mes')) !!},
        datasets: [{
            label: 'Mantenimientos',
            data: {!! json_encode(array_column($tendenciaMantenimientos, 'cantidad')) !!},
            borderColor: 'rgba(251, 146, 60, 1)',
            backgroundColor: 'rgba(251, 146, 60, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: 'rgba(251, 146, 60, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                callbacks: {
                    label: function(context) {
                        return 'Mantenimientos: ' + context.parsed.y;
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(63, 63, 70, 0.5)'
                },
                ticks: {
                    stepSize: 1
                }
            },
            x: {
                grid: {
                    color: 'rgba(63, 63, 70, 0.5)'
                }
            }
        }
    }
});

// Gráfico de Mantenimientos por Tipo de Máquina (Barras)
const ctxTipo = document.getElementById('tipoMaquinaChart').getContext('2d');
const tiposData = {!! json_encode($mantenimientosPorTipo) !!};
new Chart(ctxTipo, {
    type: 'bar',
    data: {
        labels: tiposData.map(item => item.tipo || 'Sin tipo'),
        datasets: [{
            label: 'Mantenimientos',
            data: tiposData.map(item => item.total),
            backgroundColor: [
                'rgba(59, 130, 246, 0.8)',
                'rgba(34, 197, 94, 0.8)',
                'rgba(251, 146, 60, 0.8)',
                'rgba(239, 68, 68, 0.8)',
                'rgba(168, 85, 247, 0.8)',
                'rgba(236, 72, 153, 0.8)'
            ],
            borderColor: [
                'rgba(59, 130, 246, 1)',
                'rgba(34, 197, 94, 1)',
                'rgba(251, 146, 60, 1)',
                'rgba(239, 68, 68, 1)',
                'rgba(168, 85, 247, 1)',
                'rgba(236, 72, 153, 1)'
            ],
            borderWidth: 2,
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Total: ' + context.parsed.y + ' mantenimientos';
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(63, 63, 70, 0.5)'
                },
                ticks: {
                    stepSize: 1
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Auto-actualización cada 60 segundos
let refreshTimer;
function startAutoRefresh() {
    refreshTimer = setTimeout(function() {
        location.reload();
    }, 60000); // 60 segundos
}

// Iniciar el timer cuando la página carga
document.addEventListener('DOMContentLoaded', startAutoRefresh);

// Detener el timer si el usuario interactúa con la página
document.addEventListener('click', function() {
    clearTimeout(refreshTimer);
    startAutoRefresh(); // Reiniciar el timer
});
</script>
@endpush
