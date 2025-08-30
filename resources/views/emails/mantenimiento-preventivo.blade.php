<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mantenimiento Preventivo - Geoservi</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .logo {
            width: 150px;
            margin-bottom: 20px;
        }
        .alert-badge {
            display: inline-block;
            background: #fbbf24;
            color: #78350f;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            margin-top: 15px;
            font-size: 14px;
        }
        .content {
            padding: 30px;
        }
        .warning-box {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .warning-box h2 {
            color: #92400e;
            margin-top: 0;
            font-size: 20px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin: 20px 0;
        }
        .info-item {
            background: #f9fafb;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }
        .info-label {
            color: #6b7280;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .info-value {
            color: #111827;
            font-size: 18px;
            font-weight: 600;
        }
        .horometer-section {
            background: linear-gradient(to right, #fef3c7, #fed7aa);
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .horometer-value {
            font-size: 36px;
            font-weight: bold;
            color: #92400e;
            margin: 10px 0;
        }
        .progress-bar {
            background: #e5e7eb;
            height: 30px;
            border-radius: 15px;
            overflow: hidden;
            margin: 20px 0;
            position: relative;
        }
        .progress-fill {
            background: linear-gradient(to right, #f59e0b, #d97706);
            height: 100%;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            transition: width 0.3s ease;
        }
        .action-buttons {
            display: flex;
            gap: 15px;
            margin: 30px 0;
            flex-wrap: wrap;
        }
        .btn {
            flex: 1;
            min-width: 200px;
            padding: 15px 25px;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-block;
        }
        .btn-primary {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(249, 115, 22, 0.3);
        }
        .btn-secondary {
            background: white;
            color: #f97316;
            border: 2px solid #f97316;
        }
        .btn-secondary:hover {
            background: #fff7ed;
        }
        .recommendations {
            background: #f0fdf4;
            border: 1px solid #86efac;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .recommendations h3 {
            color: #14532d;
            margin-top: 0;
        }
        .recommendations ul {
            color: #166534;
            margin: 10px 0;
            padding-left: 20px;
        }
        .recommendations li {
            margin: 8px 0;
        }
        .footer {
            background: #1f2937;
            color: #9ca3af;
            padding: 30px;
            text-align: center;
            font-size: 14px;
        }
        .footer a {
            color: #f97316;
            text-decoration: none;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #9ca3af;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .action-buttons {
                flex-direction: column;
            }
            .btn {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('img-pag/geoservi-logo-white.png') }}" alt="Geoservi" class="logo">
            <h1>⚠️ Mantenimiento Preventivo Programado</h1>
            <div class="alert-badge">ACCIÓN PREVENTIVA REQUERIDA</div>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Warning Box -->
            <div class="warning-box">
                <h2>Atención: Mantenimiento Próximo</h2>
                <p>La maquinaria <strong>{{ $maquinaria->nombre }}</strong> está próxima a su mantenimiento programado. Es importante planificar la intervención para evitar paradas no programadas.</p>
            </div>

            <!-- Machine Info Grid -->
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Maquinaria</div>
                    <div class="info-value">{{ $maquinaria->nombre }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tipo</div>
                    <div class="info-value">{{ $maquinaria->tipo }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Pauta de Mantenimiento</div>
                    <div class="info-value">{{ $pauta->nombre }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Frecuencia</div>
                    <div class="info-value">{{ number_format($pauta->frecuencia_horas) }} hrs</div>
                </div>
            </div>

            <!-- Horometer Section -->
            <div class="horometer-section">
                <div class="info-label">HORÓMETRO ACTUAL</div>
                <div class="horometer-value">{{ number_format($maquinaria->horometro_actual) }} hrs</div>
                <p style="color: #92400e; font-weight: 600;">
                    Faltan {{ $horasRestantes }} horas para el mantenimiento
                </p>
            </div>

            <!-- Progress Bar -->
            <div class="progress-bar">
                <div class="progress-fill" style="width: {{ min(100, (($maquinaria->horometro_actual / $pauta->frecuencia_horas) * 100)) }}%">
                    {{ round(($maquinaria->horometro_actual / $pauta->frecuencia_horas) * 100) }}%
                </div>
            </div>

            <!-- Recommendations -->
            <div class="recommendations">
                <h3>📋 Recomendaciones</h3>
                <ul>
                    <li>Programar el mantenimiento con anticipación</li>
                    <li>Verificar disponibilidad de repuestos necesarios</li>
                    <li>Coordinar con el equipo técnico disponible</li>
                    <li>Preparar el área de trabajo para la intervención</li>
                    <li>Notificar a operaciones sobre la parada programada</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ $urlAccion }}" class="btn btn-primary">
                    📝 Crear Orden de Trabajo
                </a>
                <a href="{{ $urlMaquinaria }}" class="btn btn-secondary">
                    🔍 Ver Detalles de Máquina
                </a>
            </div>

            <!-- Additional Info -->
            <div style="background: #f9fafb; padding: 15px; border-radius: 8px; margin-top: 20px;">
                <p style="margin: 0; color: #6b7280; font-size: 14px;">
                    <strong>Nota:</strong> Este es un recordatorio preventivo. Planificar el mantenimiento con anticipación ayuda a:
                </p>
                <ul style="color: #6b7280; font-size: 14px; margin: 10px 0; padding-left: 20px;">
                    <li>Minimizar el tiempo de inactividad</li>
                    <li>Extender la vida útil del equipo</li>
                    <li>Reducir costos de reparación</li>
                    <li>Mejorar la seguridad operacional</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 10px 0;">
                <strong>Geoservi - Sistema de Mantenimiento Minero</strong>
            </p>
            <p style="margin: 10px 0;">
                Este es un mensaje automático del sistema de notificaciones.<br>
                Por favor, no responda a este correo.
            </p>
            <div class="social-links">
                <a href="#">📧 soporte@geoservi.cl</a>
                <a href="#">📱 +56 9 1234 5678</a>
                <a href="#">🌐 www.geoservi.cl</a>
            </div>
            <p style="margin-top: 20px; font-size: 12px; color: #6b7280;">
                © {{ date('Y') }} Geoservi. Todos los derechos reservados.<br>
                Sistema de Gestión de Mantenimiento v1.0
            </p>
        </div>
    </div>
</body>
</html>
