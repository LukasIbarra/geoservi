<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('maquinarias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo', ['camion', 'excavadora', 'cargador', 'otro']);
            $table->string('marca');
            $table->string('modelo');
            $table->string('serie')->unique();
            $table->decimal('horometro_actual', 10, 2)->default(0);
            $table->decimal('horometro_acumulado', 10, 2)->default(0);
            $table->date('fecha_compra');
            $table->enum('estado', ['activo', 'fuera_de_servicio'])->default('activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinarias');
    }
};
