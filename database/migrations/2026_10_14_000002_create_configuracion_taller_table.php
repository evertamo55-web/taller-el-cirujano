<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configuracion_taller', function (Blueprint $table) {
            $table->id('id_config');
            $table->string('nombre_taller', 100)->default('Taller El Cirujano');
            $table->string('direccion', 255)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('horario', 100)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('imagen_hero', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configuracion_taller');
    }
};
