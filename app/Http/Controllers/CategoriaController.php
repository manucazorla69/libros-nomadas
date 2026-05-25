<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    private function comprobarAdmin()
    {
        if (!Auth::check() || Auth::user()->tipo_usuario !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->comprobarAdmin();

        $categorias = Categoria::orderBy('nombre')->get();

        return view('admin.categorias', compact('categorias'));
    }

    public function store(Request $request)
    {
        $this->comprobarAdmin();

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:50', 'unique:categorias,nombre'],
        ]);

        Categoria::create([
            'nombre' => $datos['nombre'],
        ]);

        return redirect()
            ->route('admin.categorias')
            ->with('success', 'Categoría añadida correctamente.');
    }

    public function destroy(Categoria $categoria)
    {
        $this->comprobarAdmin();

        $categoria->delete();

        return redirect()
            ->route('admin.categorias')
            ->with('success', 'Categoría borrada correctamente.');
    }
}