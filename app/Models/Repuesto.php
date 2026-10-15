<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    // Redirige el modelo viejo para que controle la nueva tabla de activos fijos
    protected $table = 'herramientas';
    protected $primaryKey = 'id_herramienta';

    protected $fillable = [
        'codigo_herramienta',
        'nombre_herramienta',
        'estado'
    ];
}