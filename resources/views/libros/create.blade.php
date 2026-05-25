@extends('layouts.app')

@section('content')

<div class="page-container">
    <div class="form-card">
        <h1>Publicar nuevo libro</h1>

        <p class="sub">
            Comparte un libro con la comunidad de Libros Nómadas.
        </p>

        @if($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <form 
            action="{{ route('libros.store') }}" 
            method="POST" 
            enctype="multipart/form-data" 
            class="form-libro needs-validation" 
            novalidate
        >
            @csrf

            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input 
                    type="text" 
                    id="titulo" 
                    name="titulo" 
                    class="form-control" 
                    placeholder="Ej: El nombre del viento"
                    value="{{ old('titulo') }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input 
                    type="text" 
                    id="autor" 
                    name="autor" 
                    class="form-control" 
                    placeholder="Ej: Patrick Rothfuss"
                    value="{{ old('autor') }}"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea 
                    id="descripcion" 
                    name="descripcion" 
                    class="form-control" 
                    placeholder="Cuenta de qué trata el libro..." 
                    rows="5" 
                    required
                >{{ old('descripcion') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select id="categoria" name="categoria" class="form-select" required>
                    <option value="">Selecciona una categoría</option>

                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}" @selected(old('categoria') == $cat->id)>
                            {{ $cat->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen de portada</label>
                <input 
                    type="file" 
                    id="imagen" 
                    name="imagen" 
                    class="form-control" 
                    accept="image/*" 
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Publicar libro
            </button>
        </form>
    </div>
</div>

@endsection