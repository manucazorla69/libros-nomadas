<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $buscar = trim($request->get('buscar', ''));

        $libros = Libro::with('categoria')
            ->where('estado', 'disponible')
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($q) use ($buscar) {
                    $q->where('titulo', 'like', "%$buscar%")
                      ->orWhere('autor', 'like', "%$buscar%")
                      ->orWhereHas('categoria', function ($cat) use ($buscar) {
                          $cat->where('nombre', 'like', "%$buscar%");
                      });
                });
            })
            ->get();

        $categorias = Categoria::orderBy('nombre')->get();

        return view('catalogo.index', compact('libros', 'categorias', 'buscar'));
    }
}