<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@geoservi.cl',
            'password' => Hash::make('admin123'), // 🔑 contraseña segura
            'role' => 'admin',
        ]);

        // Usuario Técnico
        User::create([
            'name' => 'Técnico',
            'email' => 'tecnico@geoservi.cl',
            'password' => Hash::make('tecnico123'), // 🔑 contraseña segura
            'role' => 'tecnico',
        ]);
    }
}
