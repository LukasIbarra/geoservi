<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Sistema de Mantenimiento Minero</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            background-color: #1f2937;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        
        .header .date {
            font-size: 11px;
            color: #9ca3af;
        }
        
        .container {
            padding: 0 20px;
        }
        
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            border-bottom: 2px solid #fb923c;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        
        .kpi-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .kpi-card {
            display: table-cell;
            width: 25%;
            padding: 10px;
            text-align: center;
            border: 1px solid #e5e7eb;
            background-color: #f9fafb;
        }
        
        .kpi-card.success { background-color: #d1fae5; }
        .kpi-card.info { background-color: #dbeafe; }
        .kpi-card.warning { background-color: #fed7aa; }
        .kpi-card.danger { background-color: #fee2e2; }
        
        .kpi-value {
            font-size: 28px;
            font-weight: bold;
            color: #1f2937;
        }
        
        .kpi-label {
            font-size: 11px;
            color: #6b7280;
            margin-top: 5px;
        }
        
        .kpi-detail {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 3px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            padding: 8px;
            text-align: left;
            border: 1px solid #e5e7eb;
            font-size: 11px;
        }
        
        td {
            padding: 8px;
            border: 1px solid #e5e7eb;
            font-size: 11px;
        }
        
        tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-active { background-color: #d1fae5; color: #065f46; }
        .status-maintenance { background-color: #fed7aa; color: #92400e; }
        .status-inactive { background-color: #fee2e2; color: #991b1b; }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-completed { background-color: #d1fae5; color: #065f46; }
        .status-in-process { background-color: #dbeafe; color: #1e40af; }
        
        .critical-alert {
            background-color: #fee2e2;
            border-left: 4px solid #dc2626;
            padding: 10px;
            margin: 10px 0;
        }
        
        .warning-alert {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 10px;
            margin: 10px 0;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        .statistics-grid {
            display: table;
            width: 100%;
            margin: 15px 0;
        }
        
        .stat-item {
            display: table-cell;
            width: 33.33%;
            padding: 10px;
            text-align: center;
        }
        
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            color: #fb923c;
        }
        
        .stat-label {
            font-size: 10px;
            color: #6b7280;
            margin-top: 3px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Dashboard de Mantenimiento</h1>
        <div class="date">Generado el {{ $fecha_generacion ?? now()->format('d/m/Y H:i') }}</div>
    </div>
    
    <div class="container">
        <!-- KPIs Principales -->
        <div class="section">
            <h2 class="section-title">Indicadores Clave de Rendimiento (KPIs)</h2>
            <div class="kpi-grid">
                <div class="kpi-card success">
                    <div class="kpi-value">{{ $disponibilidad ?? 0 }}%</div>
                    <div class="kpi-label">Disponibilidad de Flota</div>
                    <div class="kpi-detail">{{ $maquinariasActivas ?? 0 }} de {{ $totalMaquinarias ?? 0 }} activas</div>
                </div>
                <div class="kpi-card info">
                    <div class="kpi-value">{{ $tasaCumplimiento ?? 0 }}%</div>
                    <div class="kpi-label">Cumplimiento</div>
                    <div class="kpi-detail">{{ $mantenimientosCompletadosHoy ?? 0 }} completados hoy</div>
                </div>
                <div class="kpi-card danger">
                    <div class="kpi-value">{{ $maquinasCriticas ?? 0 }}</div>
                    <div class="kpi-label">Alertas Críticas</div>
                    <div class="kpi-detail">Requieren atención inmediata</div>
                </div>
                <div class="kpi-card warning">
                    <div class="kpi-value">{{ $mantenimientosPendientes ?? 0 }}</div>
                    <div class="kpi-label">Órdenes Pendientes</div>
                    <div class="kpi-detail">{{ $mantenimientosEnProceso ?? 0 }} en proceso</div>
                </div>
            </div>
        </div>
        
        <!-- Estadísticas Generales -->
        <div class="section">
            <h2 class="section-title">Estadísticas Generales</h2>
            <div class="statistics-grid">
                <div class="stat-item">
                    <div class="stat-value">{{ $totalMaquinarias ?? 0 }}</div>
                    <div class="stat-label">Total Maquinarias</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $tecnicosActivos ?? 0 }}</div>
                    <div class="stat-label">Técnicos Activos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $mantenimientosMes ?? 0 }}</div>
                    <div class="stat-label">Mantenimientos Este Mes</div>
                </div>
            </div>
        </div>
        
        <!-- Estado de Maquinarias Críticas -->
        @if(isset($maquinariasConHorometro) && count($maquinariasConHorometro) > 0)
        <div class="section">
            <h2 class="section-title">Control de Horómetros - Estado Crítico</h2>
            <table>
                <thead>
                    <tr>
                        <th>Maquinaria</th>
                        <th>Tipo</th>
                        <th>Horómetro Actual</th>
                        <th>Próxima Pauta</th>
                        <th>Horas Restantes</th>
                        <th>% Uso</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($maquinariasConHorometro->take(10) as $maquina)
                    <tr>
                        <td><strong>{{ $maquina['nombre'] }}</strong></td>
                        <td>{{ $maquina['tipo'] }}</td>
                        <td>{{ number_format($maquina['horometro_actual']) }} hrs</td>
                        <td>{{ $maquina['proxima_pauta'] }}</td>
                        <td>
                            @if($maquina['horas_restantes'] > 0)
                                {{ $maquina['horas_restantes'] }} hrs
                            @else
                                <span style="color: red; font-weight: bold;">VENCIDO</span>
                            @endif
                        </td>
                        <td>{{ $maquina['porcentaje_uso'] }}%</td>
                        <td>
                            @if($maquina['estado_alerta'] == 'critical')
                                <span class="status-badge status-inactive">CRÍTICO</span>
                            @elseif($maquina['estado_alerta'] == 'warning')
                                <span class="status-badge status-pending">ALERTA</span>
                            @else
                                <span class="status-badge status-active">NORMAL</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        
        <div class="page-break"></div>
        
        <!-- Próximos Mantenimientos -->
        @if(isset($proximosMantenimientos) && count($proximosMantenimientos) > 0)
        <div class="section">
            <h2 class="section-title">Próximos Mantenimientos Programados</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Maquinaria</th>
                        <th>Tipo</th>
                        <th>Pauta</th>
                        <th>Horómetro Actual</th>
                        <th>Horas Restantes</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proximosMantenimientos->take(15) as $mantenimiento)
                    <tr>
                        <td>#{{ $mantenimiento->id }}</td>
                        <td><strong>{{ $mantenimiento->maquinaria->nombre ?? 'N/A' }}</strong></td>
                        <td>{{ $mantenimiento->maquinaria->tipo ?? 'N/A' }}</td>
                        <td>{{ $mantenimiento->pauta->nombre ?? 'Sin pauta' }}</td>
                        <td>{{ number_format($mantenimiento->maquinaria->horometro_actual ?? 0) }} hrs</td>
                        <td>
                            @if($mantenimiento->horas_restantes <= 50)
                                <span style="color: red; font-weight: bold;">{{ $mantenimiento->horas_restantes }} hrs</span>
                            @elseif($mantenimiento->horas_restantes <= 100)
                                <span style="color: orange; font-weight: bold;">{{ $mantenimiento->horas_restantes }} hrs</span>
                            @else
                                {{ $mantenimiento->horas_restantes }} hrs
                            @endif
                        </td>
                        <td>
                            <span class="status-badge status-pending">PENDIENTE</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        
        <!-- Distribución de Estados -->
        @if(isset($distribucionEstados))
        <div class="section">
            <h2 class="section-title">Distribución de Estados de Maquinaria</h2>
            <table>
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Cantidad</th>
                        <th>Porcentaje</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($distribucionEstados as $estado => $cantidad)
                    <tr>
                        <td>
                            @if($estado == 'Activas')
                                <span class="status-badge status-active">{{ $estado }}</span>
                            @elseif($estado == 'En Mantenimiento')
                                <span class="status-badge status-maintenance">{{ $estado }}</span>
                            @else
                                <span class="status-badge status-inactive">{{ $estado }}</span>
                            @endif
                        </td>
                        <td>{{ $cantidad }}</td>
                        <td>{{ $totalMaquinarias > 0 ? round(($cantidad / $totalMaquinarias) * 100, 1) : 0 }}%</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
        
        <!-- Resumen de Actividades Recientes -->
        @if(isset($actividadesRecientes) && count($actividadesRecientes) > 0)
        <div class="section">
            <h2 class="section-title">Actividades Recientes</h2>
            <table>
                <thead>
                    <tr>
                        <th>Tiempo</th>
                        <th>Actividad</th>
                        <th>Usuario</th>
                        <th>Tipo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actividadesRecientes->take(20) as $actividad)
                    <tr>
                        <td>{{ $actividad['tiempo'] ?? 'N/A' }}</td>
                        <td>{{ $actividad['mensaje'] ?? 'N/A' }}</td>
                        <td>{{ $actividad['usuario'] ?? $actividad['tecnico'] ?? 'Sistema' }}</td>
                        <td>{{ $actividad['tipo'] ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    
    <div class="footer">
        <p>Sistema de Mantenimiento Minero - GeoServi</p>
        <p>Este documento es confidencial y para uso interno exclusivamente</p>
    </div>
</body>
</html>
