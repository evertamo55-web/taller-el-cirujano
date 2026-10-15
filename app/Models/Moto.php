<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moto extends Model
{
    protected $table = 'motos';
    protected $primaryKey = 'id_moto';

    protected $fillable = [
        'placa', 
        'id_cliente', 
        'marca', 
        'modelo', 
        'color', 
        'fecha_ultimo_mantenimiento'
    ];

    // Relación: Esta moto pertenece a un cliente
    public function cliente() {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }
}