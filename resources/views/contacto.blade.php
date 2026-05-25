@extends('layouts.app')

@section('content')

<section class="perfil-container">
    <h1>Formulario de contacto</h1>

    <section class="perfil-card">
        <p>
            Puedes utilizar este formulario para contactar con el equipo de desarrollo de Libros Nómadas.
        </p>

        @if($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <form method="POST" action="{{ route('contacto.store') }}" class="needs-validation" novalidate>
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
                >
            </div>

            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input
                    type="text"
                    id="apellidos"
                    name="apellidos"
                    class="form-control"
                    placeholder="Apellidos"
                    value="{{ old('apellidos') }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="ejemplo@gmail.com"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="comentario" class="form-label">Mensaje</label>
                <textarea
                    id="comentario"
                    name="comentario"
                    class="form-control"
                    rows="5"
                    placeholder="Escribe aquí tu mensaje..."
                    required
                >{{ old('comentario') }}</textarea>
            </div>

            <div class="contacto-botones">
                <button type="submit" class="btn btn-primary">
                    Enviar
                </button>

                <button type="reset" class="btn btn-secondary">
                    Borrar
                </button>
            </div>
        </form>
    </section>
</section>

@endsection