<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido al Newsletter de Geoservi</title>
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
        .welcome-text {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .features {
            margin: 20px 0;
        }
        .feature-item {
            margin-bottom: 10px;
            padding-left: 20px;
            position: relative;
        }
        .feature-item:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #f97316;
            font-weight: bold;
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
        .social-links {
            margin: 20px 0;
        }
        .social-link {
            display: inline-block;
            margin: 0 10px;
            color: #f97316;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>¡Bienvenido/a!</h1>
        <p>Te has suscrito exitosamente a nuestro newsletter</p>
    </div>
    
    <div class="content">
        <div class="welcome-text">
            <p>Hola,</p>
            <p>¡Gracias por suscribirte al newsletter de <strong>{{ $company }}</strong>!</p>
            <p><em>"{{ $slogan }}"</em></p>
        </div>

        <div class="features">
            <h3>¿Qué recibirás?</h3>
            <div class="feature-item">Novedades sobre nuestros equipos y servicios</div>
            <div class="feature-item">Ofertas especiales y promociones exclusivas</div>
            <div class="feature-item">Consejos de mantenimiento y mejores prácticas</div>
            <div class="feature-item">Eventos y capacitaciones del sector</div>
            <div class="feature-item">Noticias relevantes de la industria minera</div>
        </div>

        <p>Estamos comprometidos a brindarte contenido de valor que te ayude en tus proyectos y operaciones.</p>

        <div class="social-links">
            <h3>Síguenos en nuestras redes sociales:</h3>
            <a href="#" class="social-link">Facebook</a> • 
            <a href="#" class="social-link">Instagram</a> • 
            <a href="#" class="social-link">LinkedIn</a>
        </div>

        <p>Si tienes alguna pregunta o necesitas asistencia, no dudes en contactarnos:</p>
        <p>📞 <a href="tel:+56941206045">+56 9 4120 6045</a></p>
        <p>📧 <a href="mailto:pruebasgeoservi@gmail.com">pruebasgeoservi@gmail.com</a></p>
    </div>
    
    <div class="footer">
        <p>Este mensaje fue enviado automáticamente porque te suscribiste al newsletter de Geoservi Spa.</p>
        <p>Si no deseas recibir más nuestros correos, puedes <a href="{{ url('/newsletter/unsubscribe') }}">darte de baja aquí</a>.</p>
        <p>© {{ date('Y') }} Geoservi Spa. Todos los derechos reservados.</p>
        <p>Av. Industrial 1234, Rancagua, Región de O'Higgins, Chile</p>
    </div>
</body>
</html>
