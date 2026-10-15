<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Notas Impresas - Taller El Cirujano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border: none; }
        .header-taller { background: #343a40; color: #fff; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .header-taller h1 { margin: 0; font-size: 1.5rem; }
        .header-taller p { margin: 5px 0 0 0; font-size: 0.9rem; color: #adb5bd; }
        .filtro-btn.active { background: #ffc107 !important; color: #000 !important; border-color: #ffc107 !important; }
        .table thead { background: #343a40; color: #fff; }
        .badge-placa { background: #343a40; color: #fff; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; }
        .total-card { background: #d1e7dd; border-left: 4px solid #198754; }
        .filter-card { background: #e7f3ff; border-left: 4px solid #0d6efd; }
        @media print {
            .no-print { display: none !important; }
            .card { box-shadow: none; border: 1px solid #dee2e6; }
            .header-taller { background: #fff !important; color: #000 !important; }
        }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">

        <div class="card mb-4">
            <div class="header-taller">
                <h1>Reporte de Notas Impresas</h1>
                <p>Notas de servicio emitidas al cliente por día, semana o mes</p>
            </div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <a href="{{ route('admin.ganancias') }}" class="btn btn-outline-secondary">
                        ← Volver
                    </a>
                    <div style="display: flex; gap: 10px;">
                        <button onclick="window.print()" class="btn btn-warning">
                            Imprimir
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3 filter-card no-print">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.notasImpresas') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Filtro</label>
                        <div class="d-flex gap-2">
                            <button type="submit" name="filtro" value="dia" class="btn btn-sm filtro-btn {{ $filtro == 'dia' ? 'active' : 'btn-outline-warning' }}">
                                Dia
                            </button>
                            <button type="submit" name="filtro" value="semana" class="btn btn-sm filtro-btn {{ $filtro == 'semana' ? 'active' : 'btn-outline-warning' }}">
                                Semana
                            </button>
                            <button type="submit" name="filtro" value="mes" class="btn btn-sm filtro-btn {{ $filtro == 'mes' ? 'active' : 'btn-outline-warning' }}">
                                Mes
                            </button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ $fecha }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mb-3 total-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div>
                        <p class="text-success fw-bold mb-1">PERIODO</p>
                        <p class="mb-0">{{ $inicio }} al {{ $fin }}</p>
                    </div>
                    <div class="text-end">
                        <p class="text-success fw-bold mb-1">TOTAL GENERAL</p>
                        <p class="fs-4 fw-bold text-success mb-0">
                            Bs. {{ number_format($totalGeneral, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th># Orden</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Motocicleta</th>
                            <th>Técnico</th>
                            <th>Estado</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ordenes as $orden)
                            <tr>
                                <td><strong>#{{ str_pad($orden->id_orden_servicio, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>{{ $orden->fecha_recepcion }}</td>
                                <td>{{ $orden->nombre_cliente }}</td>
                                <td>
                                    @if($orden->placa)
                                        <span class="badge-placa">{{ $orden->placa }}</span>
                                    @else
                                        <span class="badge bg-secondary">S/P</span>
                                    @endif
                                    {{ $orden->marca }} {{ $orden->modelo }}
                                </td>
                                <td>{{ $orden->nombre_empleado }}</td>
                                <td>
                                    <span class="badge bg-{{ $orden->estado_servicio == 'entregado' ? 'success' : ($orden->estado_servicio == 'completado' ? 'info' : 'warning') }}">
                                        {{ strtoupper($orden->estado_servicio) }}
                                    </span>
                                </td>
                                <td style="font-weight: 700;">Bs. {{ number_format($orden->total_mano_obra, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                                    No hay notas impresas en este periodo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <p class="text-center text-muted mt-4 mb-0" style="font-size: 0.85rem;">
            Reporte generado el {{ date('d/m/Y H:i') }} - Taller Mecánico "El Cirujano"
        </p>

    </div>
</body>
</html>
