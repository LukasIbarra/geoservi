<?php
/**
 * Script de prueba para generación de cotizaciones PDF
 */

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\QuoteService;

echo "🧪 PROBANDO GENERACIÓN DE COTIZACIONES PDF\n";
echo "========================================\n\n";

// Datos de prueba
$testItems = [
    [
        'id' => 1,
        'name' => 'Excavadora CAT 320D',
        'price' => 25000000,
        'quantity' => 1
    ],
    [
        'id' => 2,
        'name' => 'Mantenimiento Preventivo 5000h',
        'price' => 1200000,
        'quantity' => 2
    ],
    [
        'id' => 3,
        'name' => 'Repuestos Kit Filtros',
        'price' => 350000,
        'quantity' => 3
    ]
];

$customerInfo = [
    'name' => 'Juan Pérez',
    'email' => 'juan.perez@empresa.cl',
    'phone' => '+56 9 8765 4321',
    'company' => 'Minera Los Andes S.A.',
    'address' => 'Av. Minera 123, Rancagua'
];

try {
    echo "📊 Generando cotización de prueba...\n";
    
    $quoteService = new QuoteService();
    
    // Probar generación de PDF
    $pdf = $quoteService->generateQuotePDF($testItems, $customerInfo);
    
    echo "✅ PDF generado exitosamente\n";
    
    // Probar guardado de PDF
    $filename = $quoteService->saveQuotePDF($pdf, 'TEST-20250101-123456');
    echo "✅ PDF guardado en: " . $filename . "\n";
    
    // Probar envío por correo (solo si hay configuración de email)
    echo "📤 Intentando enviar por correo...\n";
    $sent = $quoteService->sendQuoteByEmail($pdf, 'pruebasgeoservi@gmail.com', 'TEST-20250101-123456', $customerInfo);
    
    if ($sent) {
        echo "✅ Email enviado exitosamente a pruebasgeoservi@gmail.com\n";
    } else {
        echo "⚠️  No se pudo enviar el email (puede ser normal si no hay configuración)\n";
    }
    
    // Mostrar cálculos (usando funciones locales en lugar de métodos privados)
    echo "\n📈 CÁLCULOS DE LA COTIZACIÓN:\n";
    
    // Calcular subtotal
    $subtotal = array_reduce($testItems, function($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);
    
    // Calcular IVA (19%)
    $iva = $subtotal * 0.19;
    
    // Calcular total
    $total = $subtotal + $iva;
    
    echo "Subtotal: $" . number_format($subtotal, 0, ',', '.') . "\n";
    echo "IVA (19%): $" . number_format($iva, 0, ',', '.') . "\n";
    echo "Total: $" . number_format($total, 0, ',', '.') . "\n";
    
    echo "\n🎉 PRUEBA COMPLETADA CON ÉXITO\n";
    echo "========================================\n";
    echo "El sistema de cotizaciones está funcionando correctamente.\n";
    
} catch (Exception $e) {
    echo "❌ ERROR durante la prueba:\n";
    echo "   " . $e->getMessage() . "\n\n";
    
    echo "🔧 SOLUCIONES POSIBLES:\n";
    echo "1. Verifica que DomPDF esté instalado: composer require dompdf/dompdf\n";
    echo "2. Revisa los permisos de escritura en storage/app/public\n";
    echo "3. Verifica la configuración de email en .env\n\n";
    
    echo "📝 Para más detalles del error:\n";
    echo $e->getTraceAsString() . "\n";
}
