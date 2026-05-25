<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disputa extends Model
{
    protected $table = 'disputas';

    protected $fillable = [
        'id_solicitud',
        'id_usuario_reporta',
        'motivo',
        'estado',
        'respuesta_admin',
        'fecha_resolucion',
    ];

    public function solicitud()
    {
        return $this->belongsTo(Solicitud::class, 'id_solicitud');
    }

    public function usuarioReporta()
    {
        return $this->belongsTo(User::class, 'id_usuario_reporta');
    }
}