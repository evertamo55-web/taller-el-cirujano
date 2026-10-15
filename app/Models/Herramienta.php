<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Herramienta extends Model
{
    protected $table = 'herramientas';
    protected $primaryKey = 'id_herramienta';

    protected $fillable = [
        'codigo_herramienta',
        'nombre_herramienta',
        'estado',
    ];

    /**
     * Relación: una herramienta puede tener muchos préstamos asociados.
     */
    public function prestamos()
    {
        return $this->hasMany(PrestamoHerramienta::class, 'id_herramienta', 'id_herramienta');
    }
}