<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioPortada extends Model
{
    protected $table = 'servicios_portada';
    protected $primaryKey = 'id_servicio_portada';

    protected $fillable = [
        'nombre_servicio',
        'descripcion',
        'precio',
        'imagen',
        'orden',
        'estado',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
    ];
}
