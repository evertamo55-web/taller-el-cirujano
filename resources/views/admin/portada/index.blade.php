<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portada del Taller - Taller El Cirujano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border: none; }
        .table thead { background: #343a40; color: #fff; }
        .header-taller { background: #343a40; color: #fff; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .header-taller h1 { margin: 0; font-size: 1.5rem; }
        .header-taller p { margin: 5px 0 0 0; font-size: 0.9rem; color: #adb5bd; }
        .badge-visible { background: #198754; color: #fff; }
        .badge-oculto { background: #6c757d; color: #fff; }
        .service-img { width: 60px; height: 60px; object-fit: cover; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">

        <div class="card mb-4">
            <div class="header-taller">
                <h1>Portada del Taller</h1>
                <p>Gestión de servicios y información mostrada en la página pública</p>
            </div>
            <div class="card-body">
                <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('admin.ganancias') }}" class="btn btn-outline-secondary">
                            ← Volver
                        </a>
                        <p style="margin: 0; color: #6c757d; align-self: center;">
                            {{ $servicios->where('estado', 'visible')->count() }} visibles / {{ $servicios->count() }} total
                        </p>
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <a href="{{ route('admin.portada.config-taller') }}" class="btn btn-outline-primary">
                            Configurar Taller
                        </a>
                        <a href="{{ route('admin.portada.create') }}" class="btn btn-success">
                            + Nuevo Servicio
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
                            <th>Orden</th>
                            <th>Imagen</th>
                            <th>Servicio</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($servicios as $servicio)
                            <tr>
                                <td style="text-align: center;">{{ $servicio->orden }}</td>
                                <td>
                                    @if($servicio->imagen)
                                        <img src="{{ asset('storage/' . $servicio->imagen) }}" class="service-img" alt="Imagen">
                                    @else
                                        <div class="service-img d-flex align-items-center justify-content-center bg-light">
                                            <span style="color: #6c757d; font-size: 0.7rem;">Sin imagen</span>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $servicio->nombre_servicio }}</strong></td>
                                <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $servicio->descripcion ?? '—' }}</td>
                                <td>
                                    @if($servicio->precio)
                                        Bs. {{ number_format($servicio->precio, 2) }}
                                    @else
                                        <span style="color: #6c757d;">No mostrar</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $servicio->estado }}">{{ ucfirst($servicio->estado) }}</span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 5px;">
                                        <a href="{{ route('admin.portada.edit', $servicio->id_servicio_portada) }}" class="btn btn-primary btn-sm">Editar</a>
                                        <form method="POST" action="{{ route('admin.portada.destroy', $servicio->id_servicio_portada) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este servicio de la portada?')">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                                    No hay servicios en la portada. Agregue uno con el botón verde.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>
