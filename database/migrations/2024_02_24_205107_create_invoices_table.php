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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('id_empresa');
            $table->integer('id_usuario');
            $table->integer('id_cliente');
            $table->string('nombre_invoice', 100);
            $table->text('numero_invoice');
            $table->date('fecha_invoice');
            $table->date('fecha_vencimiento_invoice');
            $table->text('comentario_invoice')->nullable();
            $table->decimal('subtotal_invoice', 8, 2);
            $table->decimal('impuesto_invoice', 8, 2);
            $table->decimal('total_invoice', 8, 2);
            $table->integer('activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
