<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/[timestamp]_create_ordenes_trabajo_table.php
public function up()
{
    Schema::create('ordenes_trabajo', function (Blueprint $table) {
        $table->id();
        $table->foreignId('maquinaria_id')->constrained()->onDelete('cascade');
        $table->foreignId('pauta_id')->constrained()->onDelete('cascade');
        $table->foreignId('tecnico_id')->constrained('users')->onDelete('cascade');
        $table->dateTime('fecha_inicio');
        $table->dateTime('fecha_fin')->nullable();
        $table->decimal('horometro_en_ejecucion', 10, 2);
        $table->enum('estado', ['pendiente', 'en_curso', 'finalizado', 'criticidad']);
        $table->text('observaciones')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes_trabajo');
    }
};
