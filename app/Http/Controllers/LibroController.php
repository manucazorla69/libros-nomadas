<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibroController extends Controller
{
    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('libros.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:150'],
            'autor' => ['required', 'string', 'max:100'],
            'descripcion' => ['required', 'string'],
            'categoria' => ['required', 'exists:categorias,id'],
            'imagen' => ['required', 'image', 'mimes:jpg,jpeg,png,webp'],
        ]);

        if (!is_dir(public_path('uploads'))) {
            mkdir(public_path('uploads'), 0755, true);
        }

        $extension = $request->file('imagen')->extension();
        $nombreImagen = uniqid('libro_', true) . '.' . $extension;

        $request->file('imagen')->move(public_path('uploads'), $nombreImagen);

        Libro::create([
            'titulo' => $datos['titulo'],
            'autor' => $datos['autor'],
            'descripcion' => $datos['descripcion'],
            'id_categoria' => $datos['categoria'],
            'id_usuario' => Auth::id(),
            'imagen' => 'uploads/' . $nombreImagen,
            'estado' => 'disponible',
        ]);

        return redirect()
            ->route('perfil')
            ->with('success', 'Libro publicado correctamente.');
    }

    public function show(Libro $libro)
    {
        $libro->load(['categoria', 'usuario']);

        $misLibros = collect();

        if (Auth::check()) {
            $misLibros = Libro::where('id_usuario', Auth::id())
                ->where('estado', 'disponible')
                ->where('id', '!=', $libro->id)
                ->get();
        }

        return view('libros.show', compact('libro', 'misLibros'));
    }

    public function showOwner(Libro $libro)
    {
        if ($libro->id_usuario !== Auth::id()) {
            abort(403);
        }

        $libro->load(['categoria', 'usuario']);

        return view('libros.owner', compact('libro'));
    }

    public function destroy(Request $request, Libro $libro)
    {
        if ($libro->id_usuario !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'confirmar_borrado' => ['accepted'],
        ]);

        if (!empty($libro->imagen) && file_exists(public_path($libro->imagen))) {
            unlink(public_path($libro->imagen));
        }

        $libro->delete();

        return redirect()
            ->route('perfil')
            ->with('success', 'Libro borrado correctamente.');
    }
}