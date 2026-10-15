<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionTaller extends Model
{
    protected $table = 'configuracion_taller';
    protected $primaryKey = 'id_config';

    protected $fillable = [
        'nombre_taller',
        'direccion',
        'telefono',
        'email',
        'horario',
        'logo',
        'imagen_hero',
    ];
}
