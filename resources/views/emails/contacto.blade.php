<!DOCTYPE html>
<html>
<head>
    <title>Nueva consulta desde la web</title>
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
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-bottom: 3px solid #orange;
        }
        .content {
            padding: 20px;
            background-color: #ffffff;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nueva consulta desde la web</h1>
    </div>
    
    <div class="content">
        <p>Se ha recibido una nueva consulta a través del formulario de contacto de la web:</p>
        
        <div class="field">
            <div class="label">Nombre:</div>
            <div>{{ $data['name'] }}</div>
        </div>
        
        <div class="field">
            <div class="label">Email:</div>
            <div>{{ $data['email'] }}</div>
        </div>
        
        @if(isset($data['phone']) && !empty($data['phone']))
        <div class="field">
            <div class="label">Teléfono:</div>
            <div>{{ $data['phone'] }}</div>
        </div>
        @endif
        
        @if(isset($data['service']) && !empty($data['service']))
        <div class="field">
            <div class="label">Servicio de interés:</div>
            <div>{{ $data['service'] }}</div>
        </div>
        @endif
        
        <div class="field">
            <div class="label">Mensaje:</div>
            <div>{{ $data['message'] }}</div>
        </div>
    </div>
    
    <div class="footer">
        <p>Este mensaje fue enviado automáticamente desde el formulario de contacto de Geoservi.</p>
    </div>
</body>
</html>
