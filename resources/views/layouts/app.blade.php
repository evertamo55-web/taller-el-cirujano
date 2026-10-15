<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller El Cirujano - Trinidad, Beni</title>
    <!-- Estilos Gráficos Robustos Integrados (Bootstrap Local Forzado) -->
    <style>
        :root {
            --bs-dark: #212529;
            --bs-warning: #ffc107;
            --bs-success: #198754;
            --bs-primary: #0d6efd;
            --bs-danger: #dc3545;
        }
        body { 
            margin: 0; 
            font-family: system-ui, -apple-system, sans-serif; 
            background-color: #f4f6f9; 
            color: #212529; 
            display: flex; 
            flex-direction: column; 
            min-height: 100vh; 
        }
        .container { width: 100%; max-width: 1140px; padding: 0 15px; margin: 0 auto; box-sizing: border-box; }
        .navbar { background-color: var(--bs-dark); padding: 15px 0; color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,.1); }
        .navbar-brand { color: var(--bs-warning); font-weight: 700; text-decoration: none; font-size: 1.3rem; text-transform: uppercase; }
        .navbar-nav { display: flex; list-style: none; padding: 0; margin: 0; gap: 20px; align-items: center; }
        .nav-link { color: #fff; text-decoration: none; font-size: 0.95rem; font-weight: 500; }
        .nav-link:hover { color: var(--bs-warning); }
        .user-info { color: #fff; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; }
        .user-badge { background-color: var(--bs-warning); color: #212529; padding: 3px 10px; border-radius: 50px; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
        .btn-logout { background: transparent; color: #fff; border: 1px solid #6c757d; padding: 6px 14px; border-radius: 5px; font-size: 0.8rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .btn-logout:hover { background-color: var(--bs-danger); border-color: var(--bs-danger); color: #fff; }
        .row { display: flex; flex-wrap: wrap; margin: 15px -15px; }
        .col-3 { flex: 0 0 25%; max-width: 25%; padding: 0 15px; box-sizing: border-box; }
        .col-6 { flex: 0 0 50%; max-width: 50%; padding: 0 15px; box-sizing: border-box; }
        .col-12 { flex: 0 0 100%; max-width: 100%; padding: 0 15px; box-sizing: border-box; }
        .card { background: #fff; border: 1px solid #dee2e6; border-radius: 8px; padding: 20px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,.05); position: relative; }
        .card-title { margin-top: 0; font-size: 1.2rem; font-weight: 700; color: #343a40; }
        .card-text { color: #6c757d; font-size: 0.88rem; line-height: 1.4; }
        .border-primary { border-top: 4px solid var(--bs-primary); }
        .border-success { border-top: 4px solid var(--bs-success); }
        .border-warning { border-top: 4px solid var(--bs-warning); }
        .border-danger { border-top: 4px solid var(--bs-danger); }
        .btn { display: inline-block; width: 100%; padding: 8px 12px; font-size: 0.9rem; font-weight: 700; text-align: center; text-decoration: none; border-radius: 5px; cursor: pointer; box-sizing: border-box; border: none; }
        .btn-primary { background-color: var(--bs-primary); color: #fff; }
        .btn-success { background-color: var(--bs-success); color: #fff; }
        .btn-warning { background-color: var(--bs-warning); color: #212529; }
        .btn-danger { background-color: var(--bs-danger); color: #fff; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 5px; font-weight: 600; }
        .alert-success { background-color: #d1e7dd; color: #0f5132; border-left: 4px solid var(--bs-success); }
        .alert-danger { background-color: #f8d7da; color: #842029; border-left: 4px solid var(--bs-danger); }
        main { flex: 1; padding: 20px 0; }
        footer { background-color: var(--bs-dark); color: #fff; text-align: center; padding: 15px 0; font-size: 0.85rem; border-top: 3px solid var(--bs-warning); margin-top: auto; }
        .footer-flex { display: flex; justify-content: space-between; align-items: center; }
        .font-monospace { font-family: monospace; }
        .text-success { color: var(--bs-success); }
        .text-primary { color: var(--bs-primary); }
        .text-end { text-align: right; }
        .form-label { display: block; margin-bottom: 8px; font-weight: 700; color: #495057; font-size: 0.9rem; }
        .form-control, .form-select { display: block; width: 100%; padding: 8px; font-size: 0.95rem; border: 1px solid #ced4da; border-radius: 5px; box-sizing: border-box; }
        .form-control:focus, .form-select:focus { border-color: var(--bs-warning); outline: none; }
        .table { width: 100%; margin-bottom: 0; border-collapse: collapse; font-size: 0.9rem; }
        .table th { background-color: var(--bs-dark); color: #fff; padding: 12px; text-align: left; }
        .table td { padding: 12px; border-bottom: 1px solid #dee2e6; }
        .table-responsive { width: 100%; overflow-x: auto; background: #fff; border-radius: 6px; }
        .badge { display: inline-block; padding: 4px 8px; font-size: 0.75rem; font-weight: 700; border-radius: 50px; color: #fff; text-transform: uppercase; }
        @media (max-width: 768px) {
            .col-3, .col-6 { flex: 0 0 100%; max-width: 100%; }
            .navbar .container { flex-direction: row; }
            .navbar-nav { gap: 10px; }
            .user-info { flex-direction: row; gap: 8px; }
            .card { padding: 15px; }
            .btn { padding: 10px 16px; font-size: 1rem; }
            .table { font-size: 0.85rem; }
            .container { padding: 0 10px; }
        }

        /* ============================================================
           ESTILOS PARA IMPRESIÓN - Solo sale la nota de servicio
           ============================================================ */
        @media print {
            /* Ocultar la barra de navegación */
            .navbar { display: none !important; }
            /* Ocultar el footer */
            footer { display: none !important; }
            /* Ocultar los botones de acción */
            .btn { display: none !important; }
            /* Ocultar los recuadros de acciones y alertas */
            .card.mb-3 { display: none !important; }
            /* Ocultar el contenedor de mensajes de sesión */
            .alert { display: none !important; }
            /* Ajustar el fondo a blanco */
            body { background: #fff !important; margin: 0 !important; padding: 0 !important; }
            /* Ajustar el contenedor al ancho de la hoja */
            .container { max-width: 100% !important; padding: 0 !important; margin: 0 !important; }
            /* Evitar que la nota se parta en varias hojas */
            .card { page-break-inside: avoid; box-shadow: none !important; border: none !important; }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Taller "El Cirujano"</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @auth
                <ul class="navbar-nav me-auto">
                    @if(Auth::user()->rol === 'propietario')
                    <li class="nav-item"><a class="nav-link" href="{{ url('/admin/reportes') }}">Reportes de Trabajos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.notasImpresas') }}">Notas Impresas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/admin/personal') }}">Personal Técnico</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('admin.portada.index') }}">Portada del Taller</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/admin/servicios') }}">Configurar Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/admin/herramientas') }}">Herramientas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/admin/ganancias') }}">Liquidación 50/50</a></li>
                    @elseif(Auth::user()->rol === 'operario')
                    <li class="nav-item"><a class="nav-link" href="{{ url('/clientes') }}">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/motos') }}">Motocicletas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/ordenes') }}">Órdenes de Trabajo</a></li>
                    @endif
                </ul>
                <div class="user-info">
                    <span>{{ Auth::user()->name }}</span>
                    <span class="user-badge">{{ ucfirst(Auth::user()->rol) }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn-logout">Cerrar Sesión</button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 15px;">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
    </div>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="container footer-flex">
            <span>© {{ date('Y') }} Taller Mecánico "El Cirujano" - Trinidad, Beni.</span>
            <span style="color: var(--bs-warning); font-weight: 700;">INCOS Beni | Técnico Superior en Sistemas Informáticos</span>
        </div>
    </footer>

</body>
</html>