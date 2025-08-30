<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/[timestamp]_create_maquinaria_pauta_table.php
public function up()
{
    Schema::create('maquinaria_pauta', function (Blueprint $table) {
        $table->id();
        $table->foreignId('maquinaria_id')->constrained()->onDelete('cascade');
        $table->foreignId('pauta_id')->constrained()->onDelete('cascade');
        $table->decimal('ultima_mantencion_horas', 10, 2)->default(0);
        $table->date('ultima_mantencion_fecha')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maquinaria_pauta');
    }
};
