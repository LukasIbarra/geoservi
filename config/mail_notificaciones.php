<?php

return [
    'default' => env('MAIL_MAILER', 'smtp'),
    
    'mailers' => [
        'smtp' => [
            'transport' => 'smtp',
            'host' => env('MAIL_HOST', 'smtp.gmail.com'),
            'port' => env('MAIL_PORT', 587),
            'encryption' => env('MAIL_ENCRYPTION', 'tls'),
            'username' => env('MAIL_USERNAME', 'pruebasgeoservi@gmail.com'),
            'password' => env('MAIL_PASSWORD'),
            'timeout' => null,
            'auth_mode' => null,
        ],
    ],
    
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'pruebasgeoservi@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'Geoservi Notificaciones'),
    ],
    
    // Configuración específica para notificaciones
    'notification' => [
        'to' => env('NOTIFICATION_EMAIL_TO', 'pruebasgeoservi@gmail.com'),
        'cc' => env('NOTIFICATION_EMAIL_CC', ''),
        'bcc' => env('NOTIFICATION_EMAIL_BCC', ''),
    ],
];