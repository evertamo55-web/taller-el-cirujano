<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ordenes_servicio', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_orden_servicio');
            $table->foreignId('id_moto')->constrained('motos', 'id_moto')->onDelete('restrict');
            $table->foreignId('id_empleado')->constrained('empleados', 'id_empleado')->onDelete('restrict');
            $table->date('fecha_recepcion');
            $table->date('fecha_entrega_estimada')->nullable();
            $table->text('descripcion_falla');
            $table->text('diagnostico_tecnico')->nullable();
            $table->decimal('total_mano_obra', 10, 2)->default(0.00);
            $table->enum('estado_servicio', ['pendiente', 'en_progreso', 'completado', 'entregado'])->default('pendiente');
            
            // 💰 Campos Financieros de Transparencia agregados para tu Tesis
            $table->decimal('ganancia_taller', 10, 2)->default(0.00);
            $table->decimal('ganancia_tecnico', 10, 2)->default(0.00);
            
            $table->timestamps();
        });

        Schema::create('detalle_servicios', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_detalle');
            $table->foreignId('id_orden_servicio')->constrained('ordenes_servicio', 'id_orden_servicio')->onDelete('cascade');
            $table->foreignId('id_servicio')->constrained('servicios', 'id_servicio')->onDelete('restrict');
            $table->string('repuesto_traido_cliente', 150)->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });

        Schema::create('prestamos_herramientas', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->id('id_prestamo');
            $table->foreignId('id_orden_servicio')->constrained('ordenes_servicio', 'id_orden_servicio')->onDelete('cascade');
            $table->foreignId('id_herramienta')->constrained('herramientas', 'id_herramienta')->onDelete('restrict');
            $table->foreignId('id_empleado')->constrained('empleados', 'id_empleado')->onDelete('restrict');
            $table->timestamp('fecha_prestamo')->useCurrent();
            $table->timestamp('fecha_devolucion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('prestamos_herramientas');
        Schema::dropIfExists('detalle_servicios');
        Schema::dropIfExists('ordenes_servicio');
    }
};