<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alerta Crítica de Mantenimiento</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .alert-badge {
            display: inline-block;
            background-color: rgba(255,255,255,0.2);
            padding: 5px 15px;
            border-radius: 20px;
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background-color: #fef2f2;
            border-left: 4px solid #dc2626;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .alert-box strong {
            color: #dc2626;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .info-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-table td:first-child {
            font-weight: 600;
            color: #6b7280;
            width: 40%;
        }
        .info-table td:last-child {
            color: #111827;
        }
        .status-critical {
            display: inline-block;
            background-color: #dc2626;
            color: white;
            padding: 4px 12px;
            border-radius: 12px;
            font-weight: bold;
            font-size: 14px;
        }
        .horometer-display {
            background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
        .horometer-value {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
        }
        .horometer-label {
            font-size: 14px;
            opacity: 0.9;
        }
        .action-required {
            background-color: #fef3c7;
            border: 2px solid #f59e0b;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .action-required h3 {
            color: #d97706;
            margin-top: 0;
        }
        .action-list {
            list-style: none;
            padding: 0;
        }
        .action-list li {
            padding: 8px 0;
            padding-left: 30px;
            position: relative;
        }
        .action-list li:before {
            content: "⚠️";
            position: absolute;
            left: 0;
        }
        .buttons {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            margin: 0 10px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-primary {
            background-color: #dc2626;
            color: white;
        }
        .btn-primary:hover {
            background-color: #b91c1c;
        }
        .btn-secondary {
            background-color: #6b7280;
            color: white;
        }
        .btn-secondary:hover {
            background-color: #4b5563;
        }
        .footer {
            background-color: #f9fafb;
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .urgency-indicator {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="urgency-indicator">
                <h1>🚨 ALERTA CRÍTICA DE MANTENIMIENTO</h1>
                <div class="alert-badge">{{ $estadoCritico }}</div>
            </div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Alert Box -->
            <div class="alert-box">
                <strong>⚠️ ATENCIÓN INMEDIATA REQUERIDA</strong><br>
                La maquinaria <strong>{{ $maquinaria->nombre }}</strong> 
                @if($horasRestantes <= 0)
                    ha <strong>EXCEDIDO</strong> su mantenimiento programado por <strong>{{ abs($horasRestantes) }} horas</strong>.
                @else
                    está a solo <strong>{{ $horasRestantes }} horas</strong> de su mantenimiento programado.
                @endif
            </div>

            <!-- Horometer Display -->
            <div class="horometer-display">
                <div class="horometer-label">HORÓMETRO ACTUAL</div>
                <div class="horometer-value">{{ number_format($maquinaria->horometro_actual) }} hrs</div>
                <div class="horometer-label">
                    @if($horasRestantes <= 0)
                        ⚠️ MANTENIMIENTO VENCIDO
                    @else
                        Faltan {{ $horasRestantes }} hrs para mantenimiento
                    @endif
                </div>
            </div>

            <!-- Machine Information -->
            <h3>📊 Información de la Maquinaria</h3>
            <table class="info-table">
                <tr>
                    <td>Máquina:</td>
                    <td><strong>{{ $maquinaria->nombre }}</strong></td>
                </tr>
                <tr>
                    <td>Tipo:</td>
                    <td>{{ $maquinaria->tipo }}</td>
                </tr>
                <tr>
                    <td>Marca/Modelo:</td>
                    <td>{{ $maquinaria->marca }} {{ $maquinaria->modelo }}</td>
                </tr>
                <tr>
                    <td>Serie:</td>
                    <td>{{ $maquinaria->serie }}</td>
                </tr>
                <tr>
                    <td>Estado:</td>
                    <td><span class="status-critical">{{ strtoupper($estadoCritico) }}</span></td>
                </tr>
            </table>

            <!-- Maintenance Information -->
            <h3>🔧 Información de Mantenimiento</h3>
            <table class="info-table">
                <tr>
                    <td>Pauta Requerida:</td>
                    <td><strong>{{ $pauta->nombre }}</strong></td>
                </tr>
                <tr>
                    <td>Frecuencia:</td>
                    <td>Cada {{ $pauta->frecuencia_horas }} horas</td>
                </tr>
                <tr>
                    <td>Última Mantención:</td>
                    <td>{{ isset($pauta->pivot) ? ($pauta->pivot->ultima_mantencion_horas ?? 0) : 0 }} hrs</td>
                </tr>
                <tr>
                    <td>Próxima Mantención:</td>
                    <td>
                        @if($horasRestantes <= 0)
                            <strong style="color: #dc2626;">INMEDIATA - Vencida hace {{ abs($horasRestantes) }} hrs</strong>
                        @else
                            En {{ $horasRestantes }} horas
                        @endif
                    </td>
                </tr>
            </table>

            <!-- Action Required -->
            <div class="action-required">
                <h3>📋 Acciones Requeridas</h3>
                <p><strong>{{ $accionRequerida }}</strong></p>
                <ul class="action-list">
                    @if($horasRestantes <= 0)
                        <li>Detener la operación de la máquina inmediatamente</li>
                        <li>Notificar al supervisor de turno</li>
                        <li>Programar mantención de emergencia</li>
                        <li>Documentar el exceso de horas operadas</li>
                    @else
                        <li>Programar mantención en las próximas {{ $horasRestantes }} horas</li>
                        <li>Asignar técnico responsable</li>
                        <li>Preparar repuestos y herramientas necesarias</li>
                        <li>Coordinar parada de máquina con operaciones</li>
                    @endif
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="buttons">
                <a href="{{ $urlAccion }}" class="btn btn-primary">
                    Crear Orden de Trabajo
                </a>
                <a href="{{ $urlMaquinaria }}" class="btn btn-secondary">
                    Ver Detalles de Máquina
                </a>
            </div>

            <!-- Additional Info -->
            <div style="background-color: #f3f4f6; padding: 15px; border-radius: 5px; margin-top: 20px;">
                <p style="margin: 0; font-size: 14px; color: #6b7280;">
                    <strong>Nota:</strong> Esta es una notificación automática del Sistema de Mantenimiento Geoservi. 
                    La falta de acción inmediata puede resultar en:
                </p>
                <ul style="margin: 10px 0 0 20px; font-size: 14px; color: #6b7280;">
                    <li>Daños mayores a la maquinaria</li>
                    <li>Pérdida de garantía del fabricante</li>
                    <li>Riesgos de seguridad para los operadores</li>
                    <li>Paradas no programadas y pérdida de producción</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <img src="{{ asset('img-pag/geoservi-logo.png') }}" alt="Geoservi" class="logo"><br>
            <strong>Sistema de Mantenimiento Preventivo</strong><br>
            Geoservi - Soluciones en Mantenimiento Minero<br>
            <br>
            Este correo fue enviado automáticamente el {{ now()->format('d/m/Y H:i') }}<br>
            Por favor, no responda a este correo. Para más información, acceda al sistema.
        </div>
    </div>
</body>
</html>
