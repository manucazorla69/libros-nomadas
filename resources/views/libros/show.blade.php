@extends('layouts.app')

@section('content')

<div class="detalle-wrapper">
    <div class="detalle-card">
        <img 
            src="{{ asset($libro->imagen) }}" 
            alt="Portada de {{ $libro->titulo }}"
        >

        <div class="info-libro">
            <h1>{{ $libro->titulo }}</h1>

            <p><strong>Autor:</strong> {{ $libro->autor }}</p>

            <p>
                <strong>Categoría:</strong>
                {{ $libro->categoria->nombre ?? 'Sin categoría' }}
            </p>

            <p>
                <strong>Publicado por:</strong>
                {{ $libro->usuario->nombre ?? 'Usuario desconocido' }}
            </p>

            <p>
                <strong>Estado:</strong>
                <span class="estado-texto">{{ ucfirst($libro->estado) }}</span>
            </p>

            <p>
                <strong>Descripción:</strong><br>
                {{ $libro->descripcion ?: 'Sin descripción disponible.' }}
            </p>

            @guest
                <div class="login-solicitud">
                    <p>Para solicitar este intercambio necesitas iniciar sesión.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Iniciar sesión
                    </a>
                </div>
            @else
                @if(auth()->id() === $libro->id_usuario)
                    <div class="login-solicitud">
                        <p>Este libro es tuyo.</p>
                        <a href="{{ route('libros.owner', $libro) }}" class="btn btn-primary">
                            Gestionar mi libro
                        </a>
                    </div>
                @elseif($libro->estado !== 'disponible')
                    <p class="error">
                        Este libro ya no está disponible para intercambio.
                    </p>
                @else
                    <div class="login-solicitud">
                        <h2>Solicitar intercambio</h2>

                        @if($misLibros->isEmpty())
                            <p>
                                Para solicitar este libro necesitas tener al menos un libro propio disponible para ofrecer.
                            </p>

                            <a href="{{ route('libros.create') }}" class="btn btn-primary">
                                Publicar un libro
                            </a>
                        @else
                            <p>
                                La solicitud de intercambio la conectaremos en el siguiente paso.
                            </p>

                            <form method="POST" action="{{ route('solicitudes.store') }}" class="detalle-form">
                                @csrf

                                <input type="hidden" name="id_libro" value="{{ $libro->id }}">

                                <label for="id_libro_ofrecido">Libro que ofreces a cambio</label>
                                <select id="id_libro_ofrecido" name="id_libro_ofrecido" class="form-select" required>
                                    <option value="">Selecciona uno de tus libros</option>

                                    @foreach($misLibros as $miLibro)
                                        <option value="{{ $miLibro->id }}">
                                            {{ $miLibro->titulo }}
                                        </option>
                                    @endforeach
                                </select>

                                <label for="mensaje">Mensaje para el propietario</label>
                                <textarea
                                    id="mensaje"
                                    name="mensaje"
                                    class="form-control"
                                    rows="4"
                                    required
                                    placeholder="Escribe un mensaje para proponer el intercambio..."
                                ></textarea>

                                <button type="submit" class="btn btn-primary">
                                    Solicitar intercambio
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            @endguest
        </div>
    </div>
</div>

@endsection