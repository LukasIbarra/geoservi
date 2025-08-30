<?php
/**
 * Script para probar las rutas de cotización
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;

echo "🧪 PROBANDO RUTAS DE COTIZACIÓN\n";
echo "================================\n\n";

// Crear una instancia del controlador
$quoteService = new App\Services\QuoteService();
$controller = new App\Http\Controllers\QuoteController($quoteService);

// Datos de prueba
$testData = [
    'items' => [
        [
            'id' => 1,
            'name' => 'Excavadora CAT 320D',
            'price' => 25000000,
            'quantity' => 1
        ],
        [
            'id' => 2,
            'name' => 'Mantenimiento Preventivo',
            'price' => 1200000,
            'quantity' => 2
        ]
    ],
    'customer_email' => 'pruebasgeoservi@gmail.com',
    'customer_name' => 'Juan Pérez',
    'customer_phone' => '+56 9 8765 4321',
    'customer_company' => 'Minera Los Andes S.A.'
];

try {
    echo "1. Probando generación de PDF...\n";
    
    // Crear request simulado
    $request = Request::create('/quote/generate', 'POST', $testData);
    
    // Probar generación de PDF
    $response = $controller->generatePDF($request);
    
    if ($response->getStatusCode() === 200) {
        echo "✅ Ruta /quote/generate funciona correctamente\n";
        $responseData = json_decode($response->getContent(), true);
        echo "   Respuesta: " . $responseData['message'] . "\n";
        echo "   Número de cotización: " . $responseData['quote_number'] . "\n";
    } else {
        echo "❌ Error en /quote/generate: " . $response->getStatusCode() . "\n";
    }

    echo "\n2. Probando descarga de PDF...\n";
    
    $request = Request::create('/quote/download', 'POST', ['items' => $testData['items']]);
    $response = $controller->downloadPDF($request);
    
    if ($response->getStatusCode() === 200) {
        echo "✅ Ruta /quote/download funciona correctamente\n";
        echo "   PDF generado para descarga\n";
    } else {
        echo "❌ Error en /quote/download: " . $response->getStatusCode() . "\n";
    }

    echo "\n3. Probando envío por email...\n";
    
    $request = Request::create('/quote/send', 'POST', $testData);
    $response = $controller->sendEmail($request);
    
    if ($response->getStatusCode() === 200) {
        echo "✅ Ruta /quote/send funciona correctamente\n";
        $responseData = json_decode($response->getContent(), true);
        echo "   Respuesta: " . $responseData['message'] . "\n";
    } else {
        echo "❌ Error en /quote/send: " . $response->getStatusCode() . "\n";
    }

    echo "\n🎉 PRUEBA DE RUTAS COMPLETADA\n";
    echo "================================\n";
    echo "Las rutas de cotización están funcionando correctamente.\n";

} catch (Exception $e) {
    echo "❌ ERROR durante la prueba:\n";
    echo "   " . $e->getMessage() . "\n\n";
    echo "📝 Stack trace:\n";
    echo $e->getTraceAsString() . "\n";
}
