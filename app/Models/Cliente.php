<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    // Definimos la llave primaria personalizada de LKM
    protected $primaryKey = 'id_cliente'; 

    protected $fillable = ['nombre', 'telefono', 'direccion', 'nit_ci'];

    // Relación: Un cliente tiene muchas motos
    public function motos() {
        return $this->hasMany(Moto::class, 'id_cliente', 'id_cliente');
    }
}