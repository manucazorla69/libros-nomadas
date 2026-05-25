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
                <strong>Estado:</strong>
                <span class="estado-texto">{{ ucfirst($libro->estado) }}</span>
            </p>

            <p>
                <strong>Descripción:</strong><br>
                {{ $libro->descripcion ?: 'Sin descripción disponible.' }}
            </p>

            <form 
                method="POST" 
                action="{{ route('libros.destroy', $libro) }}" 
                class="detalle-form"
            >
                @csrf
                @method('DELETE')

                <label class="check-confirmacion">
                    <input type="checkbox" name="confirmar_borrado" value="1" required>
                    Confirmo que quiero borrar este libro.
                </label>

                <button type="submit" class="btn-rechazar">
                    🗑️ Borrar libro
                </button>
            </form>
        </div>
    </div>
</div>

@endsection