<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    // Definimos la llave primaria personalizada de LKM para evitar conflictos
    protected $primaryKey = 'id_servicio'; 

    protected $fillable = ['nombre_servicio', 'precio_mano_obra'];

    // Relación: Un servicio puede estar registrado en muchos detalles de órdenes
    public function detalles() {
        return $this->hasMany(Detalleorden::class, 'id_servicio', 'id_servicio');
    }
}