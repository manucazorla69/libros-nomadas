<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros Nómadas</title>
    <meta name="description" content="Libros Nómadas es una plataforma de intercambio de libros de segunda mano entre usuarios.">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
</head>

<body>

<header class="site-header">
    <nav class="topbar" aria-label="Menú superior">
        <div class="brand">
            <a href="{{ route('catalogo.index') }}">
                <span>Libros</span><strong>Nómadas</strong>
            </a>
            <p>Lecturas que viajan entre lectores</p>
        </div>

        <div class="usuario-info">
            @auth
                <a href="{{ route('perfil') }}" class="user-pill">
                    Hola, <strong>{{ ucfirst(auth()->user()->nombre) }}</strong>
                    ({{ ucfirst(auth()->user()->tipo_usuario) }})
                </a>

                <form action="{{ route('logout') }}" method="POST" class="logout-form">
                    @csrf
                    <button type="submit" class="logout-top">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}">Iniciar sesión</a>
                <a href="{{ route('registro') }}">Registrarse</a>
            @endauth
        </div>

        <details class="nav-dropdown">
            <summary>
                <span class="menu-icon">☰</span>
                <span class="menu-text">Menú</span>
            </summary>

            <div class="dropdown-panel">
                <a href="{{ route('catalogo.index') }}">🏠 Inicio / Catálogo</a>

                @auth
                    <a href="{{ route('perfil') }}">👤 Mi perfil</a>
                    <a href="{{ route('libros.create') }}">📚 Publicar libro</a>

                    @if(auth()->user()->tipo_usuario === 'admin')
                        <a href="{{ route('admin.categorias') }}">⚙️ Gestionar categorías</a>
                        <a href="{{ route('admin.disputas') }}">⚠️ Gestionar disputas</a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="logout-link">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">🔐 Iniciar sesión</a>
                    <a href="{{ route('registro') }}">✨ Registrarse</a>
                @endauth
            </div>
        </details>
    </nav>
</header>

<div class="contenedor-layout">

    <aside class="menu-lateral" aria-label="Menú lateral">
        <h2 class="menu-lateral-titulo">Navegación</h2>

        <nav class="menu-lateral-nav">
            <a href="{{ route('catalogo.index') }}">🏠 Inicio / Catálogo</a>

            @auth
                <a href="{{ route('perfil') }}">👤 Mi perfil</a>
                <a href="{{ route('libros.create') }}">📚 Publicar libro</a>

                @if(auth()->user()->tipo_usuario === 'admin')
                    <a href="{{ route('admin.categorias') }}">⚙️ Gestionar categorías</a>
                    <a href="{{ route('admin.disputas') }}">⚠️ Gestionar disputas</a>
                @endif
            @else
                <a href="{{ route('login') }}">🔐 Iniciar sesión</a>
                <a href="{{ route('registro') }}">✨ Registrarse</a>
            @endauth
        </nav>
    </aside>

    <main class="zona-central">
        @if(session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        @yield('content')
    </main>

</div>

<footer>
    <div class="pie-contenido">
        <p>&copy; {{ date('Y') }} - Libros Nómadas · Proyecto Laravel</p>

       <nav class="enlaces-pie" aria-label="Enlaces del pie de página">
            <a href="{{ route('contacto') }}">Contacto</a>
            <a href="{{ asset('como_se_hizo.pdf') }}" target="_blank" rel="noopener noreferrer">
                Informe del proyecto en PDF
            </a>
        </nav>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>