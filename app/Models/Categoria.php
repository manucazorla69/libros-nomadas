<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
    ];

    public function libros()
    {
        return $this->hasMany(Libro::class, 'id_categoria');
    }
}