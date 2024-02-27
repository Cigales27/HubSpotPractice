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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_empresa', 100);
            $table->string('url_sitio_web', 100);
            $table->text('numero_empresa');
            $table->string('correo_electronico', 100);
            $table->text('url_logo');
            $table->string('direccion', 100);
            $table->string('ciudad', 100);
            $table->string('estado', 100);
            $table->integer('codigo_postal');
            $table->integer('activo')->default(1);
            $table->integer('id_usuario');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
