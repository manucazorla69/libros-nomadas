@extends('layouts.app')

@section('content')

<section class="home-hero">
    <div class="hero-content">
        <span class="hero-badge">Lectura compartida · Universidad de Granada</span>

        <h1>Haz que tus libros viajen más lejos que tú</h1>

        <p>
            Cada intercambio abre una puerta: una historia que cambia de manos,
            un lector nuevo y una aventura que vuelve a empezar.
        </p>

        <div class="hero-actions">
            @auth
                <a href="{{ route('libros.create') }}" class="btn btn-primary btn-hero">Publicar libro</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary btn-hero">Publicar libro</a>
            @endauth
        </div>
    </div>

    <div class="hero-panel">
        <span class="panel-label">Catálogo activo</span>
        <p class="hero-panel-numero">{{ $libros->count() }}</p>
        <p>libros disponibles esperando nuevo lector</p>
    </div>
</section>

<section class="catalogo-panel">
    <div class="catalogo-header">
        <div>
            <h2>Catálogo de libros</h2>
            <p>Busca por título, autor o categoría y encuentra tu próximo intercambio.</p>
        </div>
    </div>

    <form action="{{ route('catalogo.index') }}" method="GET" class="search-bar">
        <label for="buscar" class="sr-only">Buscar libros por título, autor o categoría</label>

        <input
            type="text"
            id="buscar"
            name="buscar"
            class="form-control"
            placeholder="Buscar por título, autor o categoría..."
            value="{{ $buscar }}"
            required
        >

        <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <div class="category-chips">
        <a href="{{ route('catalogo.index') }}" class="chip">Todas</a>

        @foreach($categorias as $categoria)
            <a href="{{ route('catalogo.index', ['buscar' => $categoria->nombre]) }}" class="chip">
                {{ $categoria->nombre }}
            </a>
        @endforeach
    </div>

    <section class="rejilla-libros">
        @forelse($libros as $libro)
            <article class="ficha-resumen">
                <div class="book-cover">
                    <img
                        src="{{ asset($libro->imagen) }}"
                        alt="Portada de {{ $libro->titulo }}"
                        class="img-libro"
                    >
                </div>

                <div class="book-info">
                    <h3>{{ $libro->titulo }}</h3>
                    <p>{{ $libro->autor }}</p>

                    <a href="{{ route('libros.show', $libro) }}" class="btn btn-primary btn-card">
                        Ver detalles
                    </a>
                </div>
            </article>
        @empty
            <p class="no-result">No se encontraron libros.</p>
        @endforelse
    </section>
</section>

@endsection