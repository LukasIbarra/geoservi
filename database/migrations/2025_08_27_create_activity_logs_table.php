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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('tipo_accion'); // crear, editar, eliminar, asignar, completar, iniciar, etc.
            $table->string('entidad_tipo'); // maquinaria, pauta, orden, usuario, etc.
            $table->unsignedBigInteger('entidad_id')->nullable();
            $table->string('descripcion');
            $table->text('descripcion_detallada')->nullable();
            $table->json('datos_anteriores')->nullable();
            $table->json('datos_nuevos')->nullable();
            $table->string('icono')->default('fa-info-circle');
            $table->string('color')->default('text-gray-500');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index(['entidad_tipo', 'entidad_id']);
            $table->index('tipo_accion');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
