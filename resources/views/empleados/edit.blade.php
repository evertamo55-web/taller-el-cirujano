<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado - Taller El Cirujano</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card { border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); border: none; }
    </style>
</head>
<body>
    <div class="container mt-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Editar Empleado</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('empleados.update', $empleado->id_empleado) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nombre_empleado" class="form-label fw-bold">Nombre Completo</label>
                                <input type="text" name="nombre_empleado" id="nombre_empleado" class="form-control" value="{{ old('nombre_empleado', $empleado->nombre_empleado) }}" required>
                                @error('nombre_empleado')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cargo" class="form-label fw-bold">Cargo</label>
                                <select name="cargo" id="cargo" class="form-select" required>
                                    <option value="tecnico" {{ old('cargo', $empleado->cargo) == 'tecnico' ? 'selected' : '' }}>Técnico</option>
                                    <option value="operario" {{ old('cargo', $empleado->cargo) == 'operario' ? 'selected' : '' }}>Operario</option>
                                    <option value="propietario" {{ old('cargo', $empleado->cargo) == 'propietario' ? 'selected' : '' }}>Propietario</option>
                                </select>
                                @error('cargo')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="telefono_empleado" class="form-label fw-bold">Teléfono</label>
                                <input type="text" name="telefono_empleado" id="telefono_empleado" class="form-control" value="{{ old('telefono_empleado', $empleado->telefono_empleado) }}">
                                @error('telefono_empleado')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email_empleado" class="form-label fw-bold">Correo Electrónico</label>
                                <input type="email" name="email_empleado" id="email_empleado" class="form-control" value="{{ old('email_empleado', $empleado->email_empleado) }}" required>
                                @error('email_empleado')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="estado" class="form-label fw-bold">Estado</label>
                                <select name="estado" id="estado" class="form-select" required>
                                    <option value="activo" {{ old('estado', $empleado->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="inactivo" {{ old('estado', $empleado->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                </select>
                                @error('estado')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary flex-fill">Actualizar Empleado</button>
                                <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
