<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $table = 'libros';

    protected $fillable = [
        'titulo',
        'autor',
        'descripcion',
        'imagen',
        'id_categoria',
        'id_usuario',
        'estado',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}