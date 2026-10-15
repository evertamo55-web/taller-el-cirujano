<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Ganancias - Taller El Cirujano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: #f4f6f9; 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card { 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border: none;
        }
        .header-taller {
            background: #ffc107;
            color: #000;
            padding: 20px;
            border-radius: 10px 10px 0 0;
            text-align: center;
        }
        .ganancia-total {
            background: #d1e7dd;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
        }
        .ganancia-total h1 {
            color: #198754;
            font-weight: 900;
            margin: 10px 0 0 0;
        }
        .table thead {
            background: #343a40;
            color: #fff;
        }
        .badge-placa {
            background: #343a40;
            color: #fff;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">

        {{-- Encabezado --}}
        <div class="card mb-4">
            <div class="header-taller">
                <h2 class="mb-1">TALLER "EL CIRUJANO"</h2>
                <p class="mb-0">Consulta de Ganancias del Técnico</p>
            </div>
            <div class="card-body text-center">
                <h4 class="mt-2">Hola, <strong>{{ $tecnico->nombre_empleado }}</strong></h4>
                <p class="text-muted mb-3">
                    Aquí puedes consultar tus ganancias acumuladas del 50% por concepto de mano de obra.
                </p>

                <div class="ganancia-total">
                    <h5 class="text-muted mb-0">Ganancia Total Acumulada</h5>
                    <h1>Bs. {{ number_format($totalGanado, 2) }}</h1>
                </div>
            </div>
        </div>

        {{-- Detalle de órdenes --}}
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">📋 Detalle de Órdenes Entregadas</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th># Orden</th>
                                <th>Fecha</th>
                                <th>Motocicleta</th>
                                <th>Mano de Obra</th>
                                <th>Mi Ganancia (50%)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ordenes as $orden)
                                <tr>
                                    <td><strong>#{{ str_pad($orden->id_orden_servicio, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                    <td>{{ $orden->fecha_recepcion }}</td>
                                    <td>
                                        @if($orden->placa)
                                            <span class="badge-placa">{{ $orden->placa }}</span>
                                        @else
                                            <span class="badge bg-secondary">S/P</span>
                                        @endif
                                        {{ $orden->marca }} {{ $orden->modelo }}
                                    </td>
                                    <td>Bs. {{ number_format($orden->total_mano_obra, 2) }}</td>
                                    <td class="text-primary fw-bold">
                                        Bs. {{ number_format($orden->ganancia_tecnico, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        No tienes órdenes entregadas todavía.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Pie de página --}}
        <p class="text-center text-muted mt-4 mb-0">
            © {{ date('Y') }} Taller Mecánico "El Cirujano" - Trinidad, Beni
        </p>
        <p class="text-center text-muted" style="font-size: 0.85rem;">
            Este enlace es de solo lectura y caduca al final del día.
        </p>
    </div>
</body>
</html>