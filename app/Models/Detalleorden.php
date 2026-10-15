<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Detalleorden extends Model
{
    protected $table = 'detalle_servicios';
    protected $primaryKey = 'id_detalle';

    protected $fillable = [
        'id_orden_servicio',
        'id_servicio',
        'repuesto_traido_cliente',
        'subtotal',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
    ];

    // ========================================================================
    // RELACIONES
    // ========================================================================

    /**
     * El detalle pertenece a una orden de servicio.
     */
    public function orden()
    {
        return $this->belongsTo(Ordentrabajo::class, 'id_orden_servicio', 'id_orden_servicio');
    }

    /**
     * El detalle se refiere a un servicio del catálogo (mano de obra).
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'id_servicio', 'id_servicio');
    }
}