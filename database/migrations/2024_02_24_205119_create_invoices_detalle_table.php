<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices_detalle', function (Blueprint $table) {
            $table->id();
            $table->integer('id_invoice');
            $table->string('nombre_producto');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->integer('activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices_detalle');
    }
};
