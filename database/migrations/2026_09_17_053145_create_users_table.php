<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla users con soporte RBAC para el taller.
     * Solo el propietario y el operario poseen credenciales.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->enum('rol', ['propietario', 'operario', 'tecnico'])->default('operario');
            $table->unsignedBigInteger('id_empleado')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_empleado')
                  ->references('id_empleado')
                  ->on('empleados')
                  ->onDelete('SET NULL')
                  ->onUpdate('CASCADE');
        });
    }

    /**
     * Revierte la migración.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};