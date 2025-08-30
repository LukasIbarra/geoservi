<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/[timestamp]_create_orden_trabajo_items_table.php
public function up()
{
    Schema::create('orden_trabajo_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('orden_id')->constrained('ordenes_trabajo')->onDelete('cascade');
        $table->foreignId('pauta_item_id')->constrained()->onDelete('cascade');
        $table->boolean('cumplido')->default(false);
        $table->text('comentario')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_trabajo_items');
    }
};
