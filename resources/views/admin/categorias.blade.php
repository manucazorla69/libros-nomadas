@extends('layouts.app')

@section('content')

<section class="perfil-container">
    <h1>Panel de administración: categorías</h1>

    <section class="perfil-card">
        <h2>Añadir categoría</h2>

        @if($errors->any())
            <p class="error">{{ $errors->first() }}</p>
        @endif

        <form action="{{ route('admin.categorias.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="mb-3">
                <label for="nombre_categoria" class="form-label">Nueva categoría</label>
                <input
                    type="text"
                    id="nombre_categoria"
                    name="nombre"
                    class="form-control"
                    placeholder="Nueva categoría"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">
                Añadir categoría
            </button>
        </form>
    </section>

    <section class="perfil-card">
        <h2>Categorías existentes</h2>

        @if($categorias->isEmpty())
            <p>No hay categorías registradas.</p>
        @else
            <table class="table table-dark table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->id }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>
                                <form action="{{ route('admin.categorias.destroy', $categoria) }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <label>
                                        <input type="checkbox" name="confirmar_borrado" required>
                                        Confirmar borrado
                                    </label>

                                    <button type="submit" class="btn btn-danger">
                                        Borrar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
</section>

@endsection