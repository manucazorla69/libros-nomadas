@extends('layouts.app')

@section('content')

<div class="perfil-container">
    <h1>Mi perfil</h1>

    <section class="perfil-card perfil-datos">
        <p><strong>Nombre:</strong> {{ $usuario->nombre }}</p>
        <p><strong>Email:</strong> {{ $usuario->email }}</p>
        <p><strong>Rango:</strong> {{ ucfirst($usuario->tipo_usuario) }}</p>
    </section>

    <section class="perfil-card">
        <h2>📚 Mis libros en el catálogo</h2>

        <div class="perfil-libros-grid">
            @forelse($libros as $libro)
                <a href="{{ route('libros.owner', $libro) }}" class="perfil-libro-item">
                    <img 
                        src="{{ asset($libro->imagen) }}" 
                        alt="Portada de {{ $libro->titulo }}"
                    >
                    <p>{{ $libro->titulo }}</p>
                </a>
            @empty
                <p>No tienes libros publicados actualmente.</p>
            @endforelse
        </div>
    </section>

    <section class="perfil-card">
        <h2>📤 Solicitudes enviadas</h2>

        @forelse($solicitudesEnviadas as $solicitud)
            <article class="solicitud-box">
                <p>
                    Has solicitado el libro:
                    <strong>{{ $solicitud->libroPedido->titulo ?? 'Libro no disponible' }}</strong>
                </p>

                <p class="solicitud-destacado">
                    <strong>Ofreciste a cambio:</strong>
                    {{ $solicitud->libroOfrecido->titulo ?? 'Libro no disponible' }}
                </p>

                <p>
                    <strong>Tu mensaje:</strong>
                    "{{ $solicitud->mensaje }}"
                </p>

                <p>
                    <strong>Estado:</strong>
                    <span class="estado-texto">{{ ucfirst($solicitud->estado) }}</span>
                </p>

                @if($solicitud->estado === 'aceptada')
                    @if(isset($disputasPorSolicitud[$solicitud->id]))
                        <p class="success">
                            Ya existe una disputa para este intercambio.
                            Estado:
                            <strong>{{ ucfirst($disputasPorSolicitud[$solicitud->id]) }}</strong>
                        </p>
                    @else
                        <form action="{{ route('disputas.store') }}" method="POST" class="form-disputa">
                            @csrf
                            <input type="hidden" name="id_solicitud" value="{{ $solicitud->id }}">

                            <label for="motivo_enviada_{{ $solicitud->id }}">
                                Reportar incidencia
                            </label>

                            <textarea
                                name="motivo"
                                id="motivo_enviada_{{ $solicitud->id }}"
                                rows="3"
                                required
                                placeholder="Explica brevemente el problema del intercambio"
                            ></textarea>

                            <button type="submit">Reportar disputa</button>
                        </form>
                    @endif
                @endif
            </article>
        @empty
            <p>No has enviado ninguna solicitud todavía.</p>
        @endforelse
    </section>

    <section class="perfil-card">
        <h2>📥 Solicitudes recibidas</h2>

        @forelse($solicitudesRecibidas as $solicitud)
            <article class="solicitud-box">
                <p>
                    <strong>{{ $solicitud->solicitante->nombre ?? 'Usuario desconocido' }}</strong>
                    quiere tu libro:
                    <em>{{ $solicitud->libroPedido->titulo ?? 'Libro no disponible' }}</em>
                </p>

                <p class="solicitud-destacado">
                    <strong>Te ofrece a cambio:</strong>
                    {{ $solicitud->libroOfrecido->titulo ?? 'Libro no disponible' }}
                </p>

                <p>
                    <strong>Mensaje:</strong>
                    "{{ $solicitud->mensaje }}"
                </p>

                @if($solicitud->estado === 'pendiente')
                    <div class="acciones-solicitud">
                        <form action="{{ route('solicitudes.update', $solicitud) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="accion" value="aceptar">

                            <button type="submit" class="btn-aceptar">
                                Aceptar intercambio
                            </button>
                        </form>

                        <form action="{{ route('solicitudes.update', $solicitud) }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <input type="hidden" name="accion" value="rechazar">

                            <button type="submit" class="btn-rechazar">
                                Rechazar
                            </button>
                        </form>
                    </div>
                @else
                    <p>
                        <strong>Estado:</strong>
                        <span class="estado-texto">{{ ucfirst($solicitud->estado) }}</span>
                    </p>
                @endif

                @if($solicitud->estado === 'aceptada')
                    @if(isset($disputasPorSolicitud[$solicitud->id]))
                        <p class="success">
                            Ya existe una disputa para este intercambio.
                            Estado:
                            <strong>{{ ucfirst($disputasPorSolicitud[$solicitud->id]) }}</strong>
                        </p>
                    @else
                        <form action="{{ route('disputas.store') }}" method="POST" class="form-disputa">
                            @csrf
                            <input type="hidden" name="id_solicitud" value="{{ $solicitud->id }}">

                            <label for="motivo_recibida_{{ $solicitud->id }}">
                                Reportar incidencia
                            </label>

                            <textarea
                                name="motivo"
                                id="motivo_recibida_{{ $solicitud->id }}"
                                rows="3"
                                required
                                placeholder="Explica brevemente el problema del intercambio"
                            ></textarea>

                            <button type="submit">Reportar disputa</button>
                        </form>
                    @endif
                @endif
            </article>
        @empty
            <p>No tienes peticiones pendientes.</p>
        @endforelse
    </section>

    <section class="perfil-card">
        <h2>⚠️ Mis disputas reportadas</h2>

        @forelse($misDisputas as $disputa)
            <article class="solicitud-box">
                <p>
                    <strong>Intercambio:</strong>
                    {{ $disputa->solicitud->libroPedido->titulo ?? 'Libro no disponible' }}
                    por
                    {{ $disputa->solicitud->libroOfrecido->titulo ?? 'Libro no disponible' }}
                </p>

                <p>
                    <strong>Motivo:</strong><br>
                    {{ $disputa->motivo }}
                </p>

                <p>
                    <strong>Estado:</strong>
                    <span class="estado-texto">{{ ucfirst($disputa->estado) }}</span>
                </p>

                @if($disputa->estado === 'resuelta')
                    <p class="success">
                        <strong>Disputa resuelta.</strong><br>
                        {{ $disputa->respuesta_admin ?: 'El administrador ha marcado esta disputa como resuelta.' }}
                    </p>
                @else
                    <p class="error">
                        La disputa está pendiente de revisión por parte del administrador.
                    </p>
                @endif
            </article>
        @empty
            <p>No has reportado ninguna disputa.</p>
        @endforelse
    </section>

    <section class="perfil-card historial-card">
        <h2>✅ Historial de intercambios</h2>
        <p class="historial-ayuda">
            Aquí aparecen los libros que ya han formado parte de un intercambio.
        </p>

        <div class="perfil-libros-grid small">
            @forelse($historial as $libro)
                <a href="{{ route('libros.show', $libro) }}" class="perfil-libro-item small">
                    <img 
                        src="{{ asset($libro->imagen) }}" 
                        alt="Portada de {{ $libro->titulo }}"
                    >
                    <p>{{ $libro->titulo }}</p>
                </a>
            @empty
                <p>Aún no has completado ningún intercambio.</p>
            @endforelse
        </div>
    </section>
</div>

@endsection