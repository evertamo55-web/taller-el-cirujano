<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Técnico - Taller El Cirujano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border: none; }
        .header-taller { background: #343a40; color: #fff; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
        .header-taller h1 { margin: 0; font-size: 1.5rem; }
        .header-taller p { margin: 5px 0 0 0; font-size: 0.9rem; color: #adb5bd; }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="header-taller">
                        <h1>Editar Técnico</h1>
                        <p>Actualice los datos del técnico</p>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 20px;">
                            <a href="{{ route('admin.personal') }}" class="btn btn-outline-secondary">
                                ← Volver al Panel
                            </a>
                        </div>
                        <form method="POST" action="{{ route('admin.personal.update', $tecnico->id_empleado) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre Completo *</label>
                                <input type="text" name="nombre_empleado" class="form-control" value="{{ old('nombre_empleado', $tecnico->nombre_empleado) }}" required>
                                @error('nombre_empleado')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Correo Electrónico *</label>
                                <input type="email" name="email_empleado" class="form-control" value="{{ old('email_empleado', $tecnico->email_empleado) }}" required>
                                @error('email_empleado')
                                    <div class="text-danger small">{{ $message }}</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Teléfono</label>
                                <input type="text" name="telefono_empleado" class="form-control" value="{{ old('telefono_empleado', $tecnico->telefono_empleado) }}">
                                @error('telefono_empleado')
                                    <div class="text-danger small">{{ $message }}</div>
                                @endif
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">Actualizar</button>
                                <a href="{{ route('admin.personal') }}" class="btn btn-secondary">Volver</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
