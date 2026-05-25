@extends('layouts.app')

@section('content')

<div class="auth-container">
    <h1>Crear cuenta</h1>

    <p class="sub">
        Únete a Libros Nómadas y empieza a compartir tus lecturas.
    </p>

    @if($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('registro.store') }}" class="auth-form needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input 
                type="text" 
                id="nombre" 
                name="nombre" 
                class="form-control" 
                placeholder="Nombre"
                value="{{ old('nombre') }}"
                required
                minlength="2"
                maxlength="50"
            >
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input 
                type="email" 
                id="email" 
                name="email" 
                class="form-control" 
                placeholder="Correo electrónico"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input 
                type="password" 
                id="password" 
                name="password" 
                class="form-control" 
                placeholder="Contraseña"
                required
                minlength="6"
            >
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
            <input 
                type="password" 
                id="password_confirmation" 
                name="password_confirmation" 
                class="form-control" 
                placeholder="Confirmar contraseña"
                required
                minlength="6"
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Registrarse
        </button>
    </form>

    <p class="auth-link">
        ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a>
    </p>
</div>

@endsection