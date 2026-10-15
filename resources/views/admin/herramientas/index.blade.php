<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Herramientas - Taller El Cirujano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border: none; }
        .header-taller { background: #343a40; color: #fff; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .header-taller h1 { margin: 0; font-size: 1.5rem; }
        .header-taller p { margin: 5px 0 0 0; font-size: 0.9rem; color: #adb5bd; }
        .table thead { background: #343a40; color: #fff; }
        .badge-disponible { background: #198754; color: #fff; }
        .badge-prestado { background: #dc3545; color: #fff; }
        .badge-mantenimiento { background: #ffc107; color: #000; }
        .badge-extraviado { background: #6c757d; color: #fff; }
        .filter-card { background: #e7f3ff; border-left: 4px solid #0d6efd; }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">

        <div class="card mb-4">
            <div class="header-taller">
                <h1>Herramientas del Taller</h1>
                <p>Gestión de préstamos y devoluciones de herramientas</p>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.ganancias') }}" class="btn btn-outline-secondary">← Volver</a>
                        <a href="{{ route('admin.herramientas.create') }}" class="btn btn-success">+ Agregar Herramienta</a>
                    </div>
                    <div class="d-flex gap-3">
                        <span class="badge badge-disponible">{{ $herramientas->where('estado', 'disponible')->count() }} Disponibles</span>
                        <span class="badge badge-prestado">{{ $herramientas->where('estado', 'prestado')->count() }} Prestadas</span>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Préstamo de herramienta -->
        <div class="card mb-4 filter-card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Prestar Herramienta a Técnico</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.herramientas.store-herramienta') }}">
                    @csrf
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Herramienta *</label>
                            <select name="id_herramienta" class="form-select" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($herramientas->where('estado', 'disponible') as $h)
                                    <option value="{{ $h->id_herramienta }}">{{ $h->nombre_herramienta }} ({{ $h->codigo_herramienta }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Técnico *</label>
                            <select name="id_empleado" class="form-select" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($tecnicos as $t)
                                    <option value="{{ $t->id_empleado }}">{{ $t->nombre_empleado }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Orden (opcional)</label>
                            <select name="id_orden_servicio" class="form-select">
                                <option value="">-- Ninguna --</option>
                                @foreach($ordenes as $o)
                                    <option value="{{ $o->id_orden_servicio }}">#{{ str_pad($o->id_orden_servicio, 5, '0', STR_PAD_LEFT) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Prestar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de inventario -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Inventario de Herramientas</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($herramientas as $h)
                            <tr>
                                <td><span class="badge bg-secondary">{{ $h->codigo_herramienta }}</span></td>
                                <td><strong>{{ $h->nombre_herramienta }}</strong></td>
                                <td><span class="badge badge-{{ $h->estado }}">{{ ucfirst($h->estado) }}</span></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.herramientas.edit', $h->id_herramienta) }}" class="btn btn-primary btn-sm">Editar</a>
                                        @if($h->estado !== 'prestado')
                                            <form method="POST" action="{{ route('admin.herramientas.destroy', $h->id_herramienta) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta herramienta?')">Eliminar</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No hay herramientas registradas.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Préstamos activos -->
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">Herramientas en Custodia (No Devueltas)</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Herramienta</th>
                            <th>Técnico</th>
                            <th>Orden</th>
                            <th>Fecha Préstamo</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($prestamos as $p)
                            <tr>
                                <td><strong>{{ $p->nombre_herramienta }}</strong><br><small class="text-muted">{{ $p->codigo_herramienta }}</small></td>
                                <td>{{ $p->nombre_empleado }}</td>
                                <td>
                                    @if($p->id_orden_servicio)
                                        <span class="badge bg-info">#{{ str_pad($p->id_orden_servicio, 5, '0', STR_PAD_LEFT) }}</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $p->fecha_prestamo }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.herramientas.devolver', $p->id_prestamo) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('¿Confirmar devolución?')">Devolver</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-3">No hay herramientas prestadas actualmente.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
