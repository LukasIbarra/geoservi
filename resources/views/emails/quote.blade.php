<!DOCTYPE html>
<html>
<head>
    <title>Cotización #{{ $quoteNumber }} - Geoservi Spa</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            padding: 30px;
            text-align: center;
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .content {
            padding: 30px;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-top: none;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
            background-color: #f9fafb;
            border-radius: 0 0 10px 10px;
        }
        .info-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .highlight {
            background-color: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
        }
        .button {
            display: inline-block;
            background-color: #f97316;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Cotización #{{ $quoteNumber }}</h1>
        <p>Geoservi Spa - Soluciones integrales para la industria</p>
    </div>
    
    <div class="content">
        <p>Estimado/a cliente,</p>
        
        <p>Adjuntamos la cotización solicitada con el número <strong>#{{ $quoteNumber }}</strong>.</p>
        
        <div class="info-box">
            <h3>📋 Resumen de la Cotización</h3>
            <p><strong>Número:</strong> {{ $quoteNumber }}</p>
            <p><strong>Fecha:</strong> {{ now()->format('d/m/Y') }}</p>
            <p><strong>Válida hasta:</strong> {{ now()->addDays(30)->format('d/m/Y') }}</p>
        </div>

        <div class="highlight">
            <h3>📎 Archivo Adjunto</h3>
            <p>Encontrará el detalle completo de la cotización en el archivo PDF adjunto a este correo.</p>
        </div>

        <p>Esta cotización incluye:</p>
        <ul>
            <li>Detalle completo de productos/servicios</li>
            <li>Precios unitarios y totales</li>
            <li>Cálculo de IVA (19%)</li>
            <li>Total general</li>
            <li>Condiciones de validez (30 días)</li>
        </ul>

        <p>Para aceptar esta cotización o realizar alguna modificación, por favor contáctenos:</p>
        
        <div class="info-box">
            <h3>📞 Contacto</h3>
            <p><strong>Teléfono:</strong> +56 9 4120 6045</p>
            <p><strong>Email:</strong> pruebasgeoservi@gmail.com</p>
            <p><strong>Dirección:</strong> Av. Industrial 1234, Rancagua, Región de O'Higgins</p>
        </div>

        <p>Estamos a su disposición para aclarar cualquier duda o requerimiento adicional.</p>

        <p>Atentamente,<br>
        <strong>Equipo de Ventas - Geoservi Spa</strong></p>
    </div>
    
    <div class="footer">
        <p>Este mensaje fue enviado automáticamente desde el sistema de cotizaciones de Geoservi Spa.</p>
        <p>© {{ date('Y') }} Geoservi Spa. Todos los derechos reservados.</p>
        <p>Av. Industrial 1234, Rancagua, Región de O'Higgins, Chile</p>
    </div>
</body>
</html>
