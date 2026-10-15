<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Taller - Taller El Cirujano</title>
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
                        <h1>Configurar Datos del Taller</h1>
                        <p>Información mostrada en la portada pública</p>
                    </div>
                    <div class="card-body">
                        <div style="margin-bottom: 20px;">
                            <a href="{{ route('admin.portada.index') }}" class="btn btn-outline-secondary">← Volver al Panel</a>
                        </div>
                        <form method="POST" action="{{ route('admin.portada.store-config-taller') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre del Taller *</label>
                                <input type="text" name="nombre_taller" class="form-control" value="{{ old('nombre_taller', $taller->nombre_taller) }}" required>
                                @error('nombre_taller')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Dirección</label>
                                <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $taller->direccion) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $taller->telefono) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $taller->email) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Horario</label>
                                <input type="text" name="horario" class="form-control" value="{{ old('horario', $taller->horario) }}" placeholder="Ej: Lunes a Sábado 8:00 - 18:00">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Logo</label>
                                <input type="file" name="logo" class="form-control" accept="image/*">
                                @if($taller->logo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $taller->logo) }}" style="max-height: 80px;" alt="Logo actual">
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Imagen Principal (Hero)</label>
                                <input type="file" name="imagen_hero" class="form-control" accept="image/*">
                                @if($taller->imagen_hero)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $taller->imagen_hero) }}" style="max-height: 150px;" alt="Imagen hero actual">
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-success w-100">Guardar Configuración</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
