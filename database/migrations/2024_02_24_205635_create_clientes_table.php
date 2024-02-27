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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_cliente', 100);
            $table->text('numero_cliente');
            $table->string('correo_electronico', 100);
            $table->string('direccion', 100);
            $table->string('ciudad', 100);
            $table->string('estado', 100);
            $table->integer('codigo_postal');
            $table->integer('id_empresa');
            $table->integer('activo')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
