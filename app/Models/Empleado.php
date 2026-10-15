<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'id_empleado';

    protected $fillable = ['nombre_empleado', 'cargo', 'telefono_empleado', 'email_empleado','estado'];

    // Relación: Un técnico tiene muchas órdenes asignadas
    public function ordenesServicio() {
        return $this->hasMany(Ordentrabajo::class, 'id_empleado', 'id_empleado');
    }
}