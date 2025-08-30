<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/[timestamp]_create_notificaciones_table.php
public function up()
{
    Schema::create('notificaciones', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('mensaje');
        $table->enum('tipo', ['critica', 'preventiva', 'informativa']);
        $table->foreignId('usuario_id')->constrained('users')->onDelete('cascade');
        $table->boolean('leido')->default(false);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notificaciones');
    }
};
