<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('motos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_moto');
            $table->string('placa', 15)->unique();
            $table->foreignId('id_cliente')->constrained('clientes', 'id_cliente')->onDelete('cascade');
            $table->string('marca', 50);
            $table->string('modelo', 50);
            $table->string('color', 30)->nullable();
            $table->date('fecha_ultimo_mantenimiento')->nullable();
            $table->timestamps();
        });

        Schema::create('servicios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_servicio');
            $table->string('nombre_servicio', 150);
            $table->decimal('precio_mano_obra', 10, 2)->default(0.00);
            $table->timestamps();
        });

        Schema::create('herramientas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_herramienta');
            $table->string('codigo_herramienta', 50)->unique();
            $table->string('nombre_herramienta', 100);
            $table->enum('estado', ['disponible', 'prestado', 'mantenimiento', 'extraviado'])->default('disponible');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('herramientas');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('motos');
    }
};