<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordentrabajo extends Model
{
    protected $table = 'ordenes_servicio';
    protected $primaryKey = 'id_orden_servicio';

    protected $fillable = [
        'id_moto',
        'id_empleado',
        'fecha_recepcion',
        'fecha_entrega_estimada',
        'descripcion_falla',
        'diagnostico_tecnico',
        'estado_servicio',
        'total_mano_obra',
        'ganancia_taller',
        'ganancia_tecnico',
    ];

    // ========================================================================
    // RELACIONES
    // ========================================================================

    /**
     * La orden pertenece a una motocicleta.
     */
    public function moto()
    {
        return $this->belongsTo(Moto::class, 'id_moto', 'id_moto');
    }

    /**
     * La orden es atendida por un empleado (técnico mecánico).
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }

    /**
     * La orden tiene muchos detalles (líneas de servicios / mano de obra).
     * Se usa en la Nota de Servicio para mostrar el desglose.
     */
    public function detalles()
    {
        return $this->hasMany(Detalleorden::class, 'id_orden_servicio', 'id_orden_servicio');
    }

    /**
     * La orden tiene muchos préstamos de herramientas asociados.
     */
    public function prestamos()
    {
        return $this->hasMany(PrestamoHerramienta::class, 'id_orden_servicio', 'id_orden_servicio');
    }

    // ========================================================================
    // HELPERS
    // ========================================================================

    /**
     * Devuelve el cliente asociado a través de la moto.
     * Uso: $orden->cliente->nombre
     */
    public function getClienteAttribute()
    {
        return $this->moto ? $this->moto->cliente : null;
    }
}