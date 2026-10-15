<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos asignables masivamente.
     * Se agrega 'rol' e 'id_empleado' para el control RBAC.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'id_empleado',
    ];

    /**
     * Campos ocultos en las respuestas JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversión de tipos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relación: un usuario pertenece a un empleado del taller.
     * Permite acceder a $user->empleado->nombre_empleado
     */
    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'id_empleado', 'id_empleado');
    }

    /**
     * Helper: verifica si el usuario tiene un rol determinado.
     * Uso: if (auth()->user()->tieneRol('propietario')) { ... }
     */
    public function tieneRol(string $rol): bool
    {
        return $this->rol === $rol;
    }
}