<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';

    protected $fillable = [
        'id_libro',
        'id_libro_ofrecido',
        'id_solicitante',
        'id_propietario',
        'mensaje',
        'estado',
    ];

    public function libroPedido()
    {
        return $this->belongsTo(Libro::class, 'id_libro');
    }

    public function libroOfrecido()
    {
        return $this->belongsTo(Libro::class, 'id_libro_ofrecido');
    }

    public function solicitante()
    {
        return $this->belongsTo(User::class, 'id_solicitante');
    }

    public function propietario()
    {
        return $this->belongsTo(User::class, 'id_propietario');
    }
}