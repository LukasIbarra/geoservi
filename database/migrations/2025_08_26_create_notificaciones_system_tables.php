<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabla de reglas de notificación
        Schema::create('notificacion_reglas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maquinaria_id')->nullable()->constrained('maquinarias')->onDelete('cascade');
            $table->enum('tipo_notificacion', ['critica', 'preventiva', 'informativa']);
            $table->integer('horas_umbral')->comment('Horas antes de mantención para activar notificación');
            $table->json('canales')->comment('Array de canales: email, sms, whatsapp');
            $table->boolean('activa')->default(true);
            $table->timestamps();
            
            $table->index(['maquinaria_id', 'activa']);
            $table->index('horas_umbral');
        });

        // Tabla de envíos de notificaciones
        Schema::create('notificacion_envios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maquinaria_id')->constrained('maquinarias')->onDelete('cascade');
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->enum('tipo', ['critica', 'preventiva', 'informativa']);
            $table->enum('canal', ['email', 'sms', 'whatsapp', 'push']);
            $table->text('mensaje');
            $table->enum('estado', ['pendiente', 'enviado', 'fallido', 'leido'])->default('pendiente');
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamp('fecha_lectura')->nullable();
            $table->integer('intentos')->default(0);
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['usuario_id', 'estado']);
            $table->index(['maquinaria_id', 'tipo']);
            $table->index('fecha_envio');
        });

        // Tabla de configuración de notificaciones por usuario
        Schema::create('notificacion_configuracion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
            $table->enum('canal', ['email', 'sms', 'whatsapp']);
            $table->string('direccion')->comment('Email o número de teléfono');
            $table->time('horario_inicio')->default('08:00');
            $table->time('horario_fin')->default('20:00');
            $table->string('dias_semana')->default('L,M,X,J,V')->comment('Días habilitados');
            $table->json('tipos_permitidos')->nullable()->comment('Tipos de notificación permitidos');
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->unique(['usuario_id', 'canal', 'direccion']);
            $table->index(['usuario_id', 'activo']);
        });

        // Tabla de plantillas de notificación
        Schema::create('notificacion_plantillas', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('nombre');
            $table->enum('canal', ['email', 'sms', 'whatsapp']);
            $table->string('asunto')->nullable();
            $table->text('contenido');
            $table->json('variables')->nullable()->comment('Variables disponibles para la plantilla');
            $table->boolean('activa')->default(true);
            $table->timestamps();
            
            $table->index(['canal', 'activa']);
        });

        // Agregar campos de notificación a usuarios
        Schema::table('users', function (Blueprint $table) {
            $table->string('telefono')->nullable()->after('email');
            $table->string('whatsapp')->nullable()->after('telefono');
            $table->boolean('notificaciones_activas')->default(true)->after('whatsapp');
            $table->enum('rol_notificacion', ['tecnico', 'supervisor', 'jefe', 'gerente'])->nullable()->after('notificaciones_activas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['telefono', 'whatsapp', 'notificaciones_activas', 'rol_notificacion']);
        });
        
        Schema::dropIfExists('notificacion_plantillas');
        Schema::dropIfExists('notificacion_configuracion');
        Schema::dropIfExists('notificacion_envios');
        Schema::dropIfExists('notificacion_reglas');
    }
};
