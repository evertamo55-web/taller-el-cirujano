<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestamoHerramienta extends Model
{
    protected $table = 'prestamos_herramientas';
    protected $primaryKey = 'id_prestamo';

    protected $fillable = [
        'id_orden_servicio',
        'id_herramienta',
        'id_empleado',
        'fecha_prestamo',
        'fecha_devolucion',
    ];

    protected $casts = [
        'fecha_prestamo'   => 'datetime',
        'fecha_devolucion' => 'datetime',
    ];

    public function orden()
    {
        return $this->belongsTo(Ordentrabajo::class, 'id_orden_servicio', 'id_orden_servicio');
    }

    public function herramienta()
    {
        return $this->belongsTo(Herramienta::class, 'id_herramienta', 'id_herramienta');
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }
}