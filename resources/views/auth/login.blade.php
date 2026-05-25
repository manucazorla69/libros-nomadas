@extends('layouts.app')

@section('content')

<div class="auth-container">
    <h1>Iniciar sesión</h1>

    <p class="sub">
        Accede a tu cuenta para publicar libros, gestionar solicitudes y participar en intercambios.
    </p>

    @if($errors->any())
        <p class="error">{{ $errors->first() }}</p>
    @endif

    <form method="POST" action="{{ route('login.store') }}" class="auth-form needs-validation" novalidate>
        @csrf

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
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Entrar
        </button>
    </form>

    <p class="auth-link">
        ¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a>
    </p>

    <div class="perfil-card mt-4">
        <h2>Usuarios de prueba</h2>
        <p><strong>Admin:</strong> manuel@lecturacompartida.com</p>
        <p><strong>Usuario:</strong> javier@lecturacompartida.com</p>
        <p><strong>Contraseña:</strong> 123456</p>
    </div>
</div>

@endsection