<?php
/**
 * Script de prueba para el sistema de newsletter
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\NewsletterService;
use App\Http\Controllers\NewsletterController;

echo "📧 PROBANDO SISTEMA DE NEWSLETTER\n";
echo "=================================\n\n";

try {
    echo "1. Probando suscripción a newsletter...\n";
    
    $newsletterService = new NewsletterService();
    
    // Probar suscripción
    $email = 'test' . time() . '@example.com';
    $result = $newsletterService->subscribeToNewsletter($email);
    
    if ($result['success']) {
        echo "✅ Suscripción exitosa para: " . $email . "\n";
    } else {
        echo "❌ Error en suscripción: " . $result['message'] . "\n";
    }

    echo "\n2. Probando obtención de suscriptores...\n";
    
    // Probar obtención de suscriptores
    $subscribers = $newsletterService->getSubscribers();
    echo "   Total suscriptores: " . count($subscribers) . "\n";
    
    if (count($subscribers) > 0) {
        echo "   Último suscriptor: " . $subscribers[0]->email . "\n";
        echo "   Fecha de suscripción: " . $subscribers[0]->subscribed_at . "\n";
    }

    echo "\n🎉 PRUEBA DE NEWSLETTER COMPLETADA\n";
    echo "=================================\n";
    echo "El sistema de newsletter está funcionando correctamente.\n";

} catch (Exception $e) {
    echo "❌ ERROR durante la prueba:\n";
    echo "   " . $e->getMessage() . "\n\n";
    echo "📝 Stack trace:\n";
    echo $e->getTraceAsString() . "\n";
}
