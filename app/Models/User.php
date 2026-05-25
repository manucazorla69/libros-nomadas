<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'tipo_usuario',
    ];

    protected $hidden = [
        'password',
    ];

    public function libros()
    {
        return $this->hasMany(Libro::class, 'id_usuario');
    }

    public function solicitudesEnviadas()
    {
        return $this->hasMany(Solicitud::class, 'id_solicitante');
    }

    public function solicitudesRecibidas()
    {
        return $this->hasMany(Solicitud::class, 'id_propietario');
    }
}