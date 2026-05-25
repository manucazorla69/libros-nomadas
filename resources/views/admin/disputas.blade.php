@extends('layouts.app')

@section('content')

<section class="perfil-container">
    <h1>Gestión de disputas</h1>

    @if($disputas->isEmpty())
        <section class="perfil-card">
            <p>No hay disputas registradas.</p>
        </section>
    @else
        <div class="lista-solicitudes">
            @foreach($disputas as $disputa)
                <article class="solicitud-box">
                    <h2>
                        Disputa #{{ $disputa->id }}
                        — {{ ucfirst($disputa->estado) }}
                    </h2>

                    <p>
                        <strong>Reportada por:</strong>
                        {{ $disputa->usuarioReporta->nombre ?? 'Usuario desconocido' }}
                        —
                        <a href="mailto:{{ $disputa->usuarioReporta->email ?? '' }}?subject=Disputa%20en%20Libros%20Nómadas">
                            {{ $disputa->usuarioReporta->email ?? 'Sin email' }}
                        </a>
                    </p>

                    <p class="solicitud-destacado">
                        <strong>Libro pedido:</strong>
                        {{ $disputa->solicitud->libroPedido->titulo ?? 'Libro no disponible' }}
                    </p>

                    <p class="solicitud-destacado">
                        <strong>Libro ofrecido:</strong>
                        {{ $disputa->solicitud->libroOfrecido->titulo ?? 'Libro no disponible' }}
                    </p>

                    <p>
                        <strong>Propietario:</strong>
                        {{ $disputa->solicitud->propietario->nombre ?? 'Usuario desconocido' }}
                        —
                        <a href="mailto:{{ $disputa->solicitud->propietario->email ?? '' }}">
                            {{ $disputa->solicitud->propietario->email ?? 'Sin email' }}
                        </a>
                    </p>

                    <p>
                        <strong>Solicitante:</strong>
                        {{ $disputa->solicitud->solicitante->nombre ?? 'Usuario desconocido' }}
                        —
                        <a href="mailto:{{ $disputa->solicitud->solicitante->email ?? '' }}">
                            {{ $disputa->solicitud->solicitante->email ?? 'Sin email' }}
                        </a>
                    </p>

                    <p>
                        <strong>Motivo:</strong><br>
                        {{ $disputa->motivo }}
                    </p>

                    <p>
                        <strong>Fecha:</strong>
                        {{ $disputa->created_at->format('d/m/Y H:i') }}
                    </p>

                    @if($disputa->estado === 'resuelta')
                        <p class="success">
                            <strong>Disputa resuelta.</strong><br>

                            @if(!empty($disputa->respuesta_admin))
                                {{ $disputa->respuesta_admin }}
                            @else
                                El administrador ha marcado esta disputa como resuelta.
                            @endif
                        </p>

                        @if($disputa->fecha_resolucion)
                            <p>
                                <strong>Fecha de resolución:</strong>
                                {{ \Carbon\Carbon::parse($disputa->fecha_resolucion)->format('d/m/Y H:i') }}
                            </p>
                        @endif
                    @else
                        <form 
                            action="{{ route('admin.disputas.resolve', $disputa) }}" 
                            method="POST" 
                            class="form-disputa"
                        >
                            @csrf
                            @method('PATCH')

                            <label for="respuesta_{{ $disputa->id }}">
                                Respuesta del administrador
                            </label>

                            <textarea
                                id="respuesta_{{ $disputa->id }}"
                                name="respuesta_admin"
                                class="form-control"
                                rows="4"
                                required
                                placeholder="Ej: Hemos revisado la incidencia y nos pondremos en contacto contigo por correo."
                            ></textarea>

                            <button type="submit" class="btn-aceptar">
                                Marcar como resuelta
                            </button>
                        </form>
                    @endif
                </article>
            @endforeach
        </div>
    @endif
</section>

@endsection