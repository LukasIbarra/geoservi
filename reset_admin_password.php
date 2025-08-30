<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$admin = User::where('email', 'admin@geoservi.cl')->first();

if ($admin) {
    $admin->password = Hash::make('password');
    $admin->save();
    echo "✓ Contraseña actualizada para admin@geoservi.cl\n";
    echo "  Nueva contraseña: password\n";
} else {
    // Crear usuario admin si no existe
    $admin = User::create([
        'name' => 'Administrador',
        'email' => 'admin@geoservi.cl',
        'password' => Hash::make('password'),
        'role' => 'admin'
    ]);
    echo "✓ Usuario administrador creado\n";
    echo "  Email: admin@geoservi.cl\n";
    echo "  Contraseña: password\n";
}
