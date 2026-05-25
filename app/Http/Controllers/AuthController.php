<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $datos = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($datos)) {
            $request->session()->regenerate();
            return redirect()->route('catalogo.index');
        }

        return back()
            ->withErrors(['email' => 'Email o contraseña incorrectos.'])
            ->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.registro');
    }

    public function register(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'min:2', 'max:50'],
            'email' => ['required', 'email', 'unique:usuarios,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $usuario = User::create([
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'password' => Hash::make($datos['password']),
            'tipo_usuario' => 'usuario',
        ]);

        Auth::login($usuario);

        return redirect()->route('catalogo.index');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('catalogo.index');
    }
}