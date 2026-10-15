<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Servicio Portada - Taller El Cirujano</title>
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
            <div class="col-md-7">
                <div class="card">
                    <div class="header-taller">
                        <h1>Nuevo Servicio para Portada</h1>
                        <p>Agregue un servicio que se mostrará en la página pública</p>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 20px;">
                            <a href="{{ route('admin.portada.index') }}" class="btn btn-outline-secondary">← Volver al Panel</a>
                        </div>
                        <form method="POST" action="{{ route('admin.portada.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre del Servicio *</label>
                                <input type="text" name="nombre_servicio" class="form-control" value="{{ old('nombre_servicio') }}" placeholder="Ej: Mantenimiento Preventivo" required>
                                @error('nombre_servicio')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3" placeholder="Descripción del servicio...">{{ old('descripcion') }}</textarea>
                                @error('descripcion')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Precio (opcional)</label>
                                <input type="number" name="precio" class="form-control" value="{{ old('precio') }}" placeholder="Ej: 50.00" step="0.01" min="0">
                                <small style="color: #6c757d;">Deje vacío si no quiere mostrar precio</small>
                                @error('precio')
                                    <div class="text-danger small">{{ $message }}</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Imagen (opcional)</label>
                                <input type="file" name="imagen" class="form-control" accept="image/*">
                                @error('imagen')
                                    <div class="text-danger small">{{ $message }}</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Orden *</label>
                                <input type="number" name="orden" class="form-control" value="{{ old('orden', 0) }}" required>
                                <small style="color: #6c757d;">Posición en la portada (0 = primero)</small>
                                @error('orden')
                                    <div class="text-danger small">{{ $message }}</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Estado *</label>
                                <select name="estado" class="form-select" required>
                                    <option value="visible" {{ old('estado', 'visible') == 'visible' ? 'selected' : '' }}>Visible</option>
                                    <option value="oculto" {{ old('estado') == 'oculto' ? 'selected' : '' }}>Oculto</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Guardar Servicio</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
