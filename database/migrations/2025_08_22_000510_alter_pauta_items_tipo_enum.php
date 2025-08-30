<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cambia el enum de pauta_items.tipo para alinearlo con los valores usados en la UI
        // Valores nuevos: 'chequeo','lubricacion','ajuste','cambio','limpieza','otro'
        DB::statement("ALTER TABLE `pauta_items` MODIFY COLUMN `tipo` ENUM('chequeo','lubricacion','ajuste','cambio','limpieza','otro') NOT NULL");
    }

    public function down(): void
    {
        // Revertir al enum original de la migración inicial
        DB::statement("ALTER TABLE `pauta_items` MODIFY COLUMN `tipo` ENUM('check','texto','numero') NOT NULL");
    }
};
