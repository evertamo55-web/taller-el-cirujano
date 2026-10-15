<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Herramienta - Taller El Cirujano</title>
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
                        <h1>Agregar Nueva Herramienta</h1>
                        <p>Registre una herramienta al inventario</p>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <a href="{{ route('admin.herramientas.index') }}" class="btn btn-outline-secondary">← Volver al Panel</a>
                        </div>
                        <form method="POST" action="{{ route('admin.herramientas.store-herramienta') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Código *</label>
                                <input type="text" name="codigo_herramienta" class="form-control" value="{{ old('codigo_herramienta') }}" placeholder="Ej: HER-004" required>
                                @error('codigo_herramienta')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre *</label>
                                <input type="text" name="nombre_herramienta" class="form-control" value="{{ old('nombre_herramienta') }}" placeholder="Ej: Juego de Llaves" required>
                                @error('nombre_herramienta')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Estado *</label>
                                <select name="estado" class="form-select" required>
                                    <option value="disponible" {{ old('estado', 'disponible') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                    <option value="prestado" {{ old('estado') == 'prestado' ? 'selected' : '' }}>Prestado</option>
                                    <option value="mantenimiento" {{ old('estado') == 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                                    <option value="extraviado" {{ old('estado') == 'extraviado' ? 'selected' : '' }}>Extraviado</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Guardar Herramienta</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
