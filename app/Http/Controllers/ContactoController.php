<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function index()
    {
        return view('contacto');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => ['required', 'string'],
            'apellidos' => ['required', 'string'],
            'email' => ['required', 'email'],
            'comentario' => ['required', 'string'],
        ]);

        return redirect()
            ->route('contacto')
            ->with('success', 'Formulario enviado correctamente.');
    }
}