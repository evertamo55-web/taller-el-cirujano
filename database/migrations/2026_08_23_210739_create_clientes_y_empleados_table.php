<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clientes', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // Forzar motor transaccional
            $table->id('id_cliente');
            $table->string('nombre', 100);
            $table->string('telefono', 20);
            $table->string('direccion', 255)->nullable();
            $table->string('nit_ci', 20)->unique();
            $table->timestamps();
        });

        Schema::create('empleados', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_empleado');
            $table->string('nombre_empleado', 100);
            $table->enum('cargo', ['propietario', 'operario', 'tecnico'])->default('tecnico');
            $table->string('telefono_empleado', 20)->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('empleados');
        Schema::dropIfExists('clientes');
    }
};