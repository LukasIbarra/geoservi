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
        Schema::create('pautas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('tipo_equipo', ['camion', 'maquinaria', 'ambos']);
            $table->text('descripcion')->nullable();
            $table->integer('frecuencia_horas')->nullable();
            $table->integer('frecuencia_dias')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pautas');
    }
};
