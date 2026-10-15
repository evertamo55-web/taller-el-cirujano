<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller Mecánico "El Cirujano" - Mantenimiento Preventivo y Correctivo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --bs-dark: #212529;
            --bs-warning: #ffc107;
            --bs-primary: #0d6efd;
            --bs-success: #198754;
        }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            margin: 0;
            padding: 0;
        }
        .hero {
            background: linear-gradient(135deg, #212529 0%, #343a40 100%);
            color: #fff;
            padding: 80px 0;
            text-align: center;
        }
        .hero h1 {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 15px;
        }
        .hero h1 span { color: var(--bs-warning); }
        .hero p {
            font-size: 1.2rem;
            color: #adb5bd;
            max-width: 600px;
            margin: 0 auto 30px;
        }
        .btn-hero {
            background: var(--bs-warning);
            color: #000;
            font-weight: 800;
            padding: 15px 40px;
            font-size: 1.1rem;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-hero:hover {
            background: #ffca2c;
            color: #000;
            transform: translateY(-2px);
        }
        .services-section {
            padding: 60px 0;
            background: #f4f6f9;
        }
        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }
        .section-title h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #343a40;
        }
        .section-title p {
            color: #6c757d;
        }
        .service-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: all 0.3s;
            height: 100%;
            border-top: 4px solid var(--bs-warning);
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }
        .service-card h4 {
            font-weight: 700;
            margin-bottom: 10px;
            color: #343a40;
        }
        .service-card .price {
            font-size: 1.5rem;
            font-weight: 900;
            color: var(--bs-success);
            margin-bottom: 15px;
        }
        .service-card p {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .info-section {
            padding: 60px 0;
            background: #fff;
        }
        .info-card {
            text-align: center;
            padding: 20px;
        }
        .info-card h5 {
            font-weight: 700;
            margin-top: 15px;
            color: #343a40;
        }
        .info-card p {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .cta-section {
            background: var(--bs-dark);
            color: #fff;
            padding: 50px 0;
            text-align: center;
        }
        .cta-section h2 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 20px;
        }
        .cta-section p {
            color: #adb5bd;
            margin-bottom: 25px;
        }
        .footer {
            background: #1a1d20;
            color: #6c757d;
            text-align: center;
            padding: 20px 0;
            font-size: 0.85rem;
        }
        @media (max-width: 768px) {
            .hero h1 { font-size: 2rem; }
            .hero p { font-size: 1rem; }
        }
    </style>
</head>
<body>

    <!-- HERO -->
    <section class="hero" @if($taller && $taller->imagen_hero) style="background: linear-gradient(135deg, rgba(33,37,41,0.85) 0%, rgba(52,58,64,0.85) 100%), url('{{ asset('storage/' . $taller->imagen_hero) }}') center/cover;" @endif>
        <div class="container">
            <h1>{{ $taller->nombre_taller ?? 'Taller Mecánico "El Cirujano"' }}</h1>
            <p>Mantenimiento preventivo y correctivo de motocicletas. Servicio de calidad, transparencia y precios justos.</p>
            <a href="{{ route('login') }}" class="btn-hero">Ingresar al Sistema</a>
        </div>
    </section>

    <!-- SERVICIOS -->
    <section class="services-section">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Servicios</h2>
                <p>Soluciones completas para su motocicleta</p>
            </div>
            <div class="row g-4">
                @forelse($servicios as $servicio)
                    <div class="col-md-4">
                        <div class="service-card">
                            @if($servicio->imagen)
                                <img src="{{ asset('storage/' . $servicio->imagen) }}" alt="{{ $servicio->nombre_servicio }}" style="width: 100%; height: 180px; object-fit: cover; border-radius: 10px; margin-bottom: 15px;">
                            @endif
                            <h4>{{ $servicio->nombre_servicio }}</h4>
                            @if($servicio->precio)
                                <p class="price">Bs. {{ number_format($servicio->precio, 2) }}</p>
                            @endif
                            @if($servicio->descripcion)
                                <p>{{ $servicio->descripcion }}</p>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p style="color: #6c757d; padding: 40px;">Próximamente más servicios...</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- INFO -->
    <section class="info-section">
        <div class="container">
            <div class="section-title">
                <h2>¿Por Qué Elegirnos?</h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="info-card">
                        <h5>Calidad Garantizada</h5>
                        <p>Trabajos realizados por técnicos especializados con experiencia comprobada.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <h5>Precios Transparentes</h5>
                        <p>Conozca el costo antes de realizar cualquier trabajo. Sin cargos ocultos.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-card">
                        <h5>Atención Personalizada</h5>
                        <p>Atención al cliente de lunes a sábado en horarios cómodos.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta-section">
        <div class="container">
            <h2>¿Necesita Servicio para su Motocicleta?</h2>
            <p>Visítenos en Trinidad, Beni o comuníquese con nosotros</p>
            <a href="{{ route('login') }}" class="btn-hero">Acceder al Sistema</a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">
            @if($taller)
                <p>
                    @if($taller->direccion){{ $taller->direccion }} | @endif
                    @if($taller->telefono){{ $taller->telefono }} | @endif
                    @if($taller->horario){{ $taller->horario }}@endif
                </p>
            @endif
            <p>© {{ date('Y') }} {{ $taller->nombre_taller ?? 'Taller Mecánico "El Cirujano"' }}</p>
        </div>
    </footer>

</body>
</html>
