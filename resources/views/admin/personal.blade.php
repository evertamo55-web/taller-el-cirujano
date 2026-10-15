<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Técnico - Taller El Cirujano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border: none; }
        .table thead { background: #343a40; color: #fff; }
        .badge-activo { background: #198754; color: #fff; }
        .badge-inactivo { background: #6c757d; color: #fff; }
        .btn-sm { padding: 4px 10px; font-size: 0.8rem; }
        .header-taller { background: #343a40; color: #fff; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .header-taller h1 { margin: 0; font-size: 1.5rem; }
        .header-taller p { margin: 5px 0 0 0; font-size: 0.9rem; color: #adb5bd; }
        .stat-card { border-left: 4px solid; }
        .stat-card.green { border-left-color: #198754; }
        .stat-card.red { border-left-color: #dc3545; }
        .stat-card.gray { border-left-color: #6c757d; }
        .filter-card { background: #e7f3ff; border-left: 4px solid #0d6efd; }
        .filter-card .btn { min-width: 80px; }
        .filter-card .btn.active { background: #0d6efd; color: #fff; }
        .table th { font-weight: 600; text-transform: uppercase; font-size: 0.8rem; }
        .table td { vertical-align: middle; }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">

        <div class="card mb-4">
            <div class="header-taller">
                <h1>Personal Técnico</h1>
                <p>Gestión de técnicos mecánicos del taller</p>
            </div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div>
                        <p style="margin: 0; color: #6c757d; font-size: 0.9rem;">
                            {{ $tecnicos->where('estado', 'activo')->count() }} activos / {{ $tecnicos->where('estado', 'inactivo')->count() }} inactivos
                        </p>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('admin.ganancias') }}" class="btn btn-outline-secondary" style="width: auto; padding: 10px 20px;">
                            ← Volver
                        </a>
                        <a href="{{ route('admin.personal.create') }}" class="btn btn-success" style="width: auto; padding: 10px 20px;">
                            + Nuevo Técnico
                        </a>
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

        <div class="card">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Teléfono</th>
                            <th>Correo Electrónico</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tecnicos as $tecnico)
                            <tr>
                                <td>{{ $tecnico->id_empleado }}</td>
                                <td><strong>{{ $tecnico->nombre_empleado }}</strong></td>
                                <td>{{ $tecnico->telefono_empleado }}</td>
                                <td>{{ $tecnico->email_empleado }}</td>
                                <td>
                                    <span class="badge badge-{{ $tecnico->estado }}">
                                        {{ ucfirst($tecnico->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('admin.personal.edit', $tecnico->id_empleado) }}" class="btn btn-primary btn-sm">
                                            Editar
                                        </a>
                                        @if($tecnico->estado === 'activo')
                                            <form method="POST" action="{{ route('admin.personal.destroy', $tecnico->id_empleado) }}" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar a {{ $tecnico->nombre_empleado }}? Pasará a inactivo.')">
                                                    Eliminar
                                                </button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.personal.restore', $tecnico->id_empleado) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Reactivar
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: #6c757d;">
                                    No hay técnicos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mt-3" style="padding: 15px; background: #e7f3ff; border-left: 4px solid #0d6efd;">
            <p style="margin: 0; color: #0d6efd; font-size: 0.9rem;">
                <strong>Nota:</strong> Los técnicos inactivos no aparecen en el selector del operario, pero sus datos y reportes financieros se mantienen intactos. Puedes reactivarlos en cualquier momento.
            </p>
        </div>

    </div>
</body>
</html>
