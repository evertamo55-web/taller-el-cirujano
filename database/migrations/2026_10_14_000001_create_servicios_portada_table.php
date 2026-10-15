<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servicios_portada', function (Blueprint $table) {
            $table->id('id_servicio_portada');
            $table->string('nombre_servicio', 150);
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->integer('orden')->default(0);
            $table->enum('estado', ['visible', 'oculto'])->default('visible');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servicios_portada');
    }
};
