<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

// Actualizar la contraseña del usuario admin
$user = User::where('email', 'admin@geoservi.cl')->first();
if ($user) {
    $user->password = Hash::make('password');
    $user->save();
    echo "Contraseña actualizada exitosamente para admin@geoservi.cl\n";
} else {
    echo "Usuario admin@geoservi.cl no encontrado\n";
}
