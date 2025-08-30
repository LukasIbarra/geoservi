<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Alinear esquema con la UI/controlador actual:
        // - tecnico_id: nullable
        // - fecha_inicio: nullable
        // - horometro_en_ejecucion: nullable
        // - estado enum: ['pendiente','en_progreso','completada','cancelada'] con default 'pendiente'
        DB::statement("ALTER TABLE `ordenes_trabajo` MODIFY `tecnico_id` BIGINT UNSIGNED NULL");
        DB::statement("ALTER TABLE `ordenes_trabajo` MODIFY `fecha_inicio` DATETIME NULL");
        DB::statement("ALTER TABLE `ordenes_trabajo` MODIFY `horometro_en_ejecucion` DECIMAL(10,2) NULL");
        DB::statement("ALTER TABLE `ordenes_trabajo` MODIFY `estado` ENUM('pendiente','en_progreso','completada','cancelada') NOT NULL DEFAULT 'pendiente'");
    }

    public function down(): void
    {
        // Revertir a esquema original de la migración base
        DB::statement("ALTER TABLE `ordenes_trabajo` MODIFY `tecnico_id` BIGINT UNSIGNED NOT NULL");
        DB::statement("ALTER TABLE `ordenes_trabajo` MODIFY `fecha_inicio` DATETIME NOT NULL");
        DB::statement("ALTER TABLE `ordenes_trabajo` MODIFY `horometro_en_ejecucion` DECIMAL(10,2) NOT NULL");
        DB::statement("ALTER TABLE `ordenes_trabajo` MODIFY `estado` ENUM('pendiente','en_curso','finalizado','criticidad') NOT NULL");
    }
};
