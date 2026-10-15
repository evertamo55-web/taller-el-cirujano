@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 style="margin: 0; color: #343a40; font-size: 1.8rem;">Editar Motocicleta</h1>
            <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 0.9rem;">
                Actualice los datos de la moto {{ $moto->placa ?? 'sin placa' }}.
            </p>
        </div>
        <a href="{{ route('motos.index') }}" class="btn btn-primary" style="width: auto; padding: 10px 20px;">
            ← Volver al listado
        </a>
    </div>

    <div class="card border-success">

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Corrija los siguientes errores:</strong>
                <ul style="margin: 10px 0 0 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('motos.update', $moto->id_moto) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-6">
                    <label class="form-label" for="placa">Placa única (Opcional)</label>
                    <input type="text" name="placa" id="placa" class="form-control"
                           value="{{ old('placa', $moto->placa) }}" maxlength="15"
                           placeholder="Ej: 2534-XYZ">
                    <small style="color: #6c757d;">En Trinidad, la mayoría de las motos no tienen placa. Si la tiene, ingrésela.</small>
                </div>
                <div class="col-6">
                    <label class="form-label" for="id_cliente">Propietario *</label>
                    <select name="id_cliente" id="id_cliente" class="form-select" required>
                        <option value="">-- Seleccione un cliente --</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id_cliente }}" {{ old('id_cliente', $moto->id_cliente) == $cliente->id_cliente ? 'selected' : '' }}>
                                {{ $cliente->nombre }} ({{ $cliente->nit_ci }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label class="form-label" for="marca">Marca *</label>
                    <input type="text" name="marca" id="marca" class="form-control"
                           value="{{ old('marca', $moto->marca) }}" required maxlength="50"
                           placeholder="Ej: Honda">
                </div>
                <div class="col-6">
                    <label class="form-label" for="modelo">Modelo *</label>
                    <input type="text" name="modelo" id="modelo" class="form-control"
                           value="{{ old('modelo', $moto->modelo) }}" required maxlength="50"
                           placeholder="Ej: XR 250 Tornado">
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label class="form-label" for="color">Color</label>
                    <input type="text" name="color" id="color" class="form-control"
                           value="{{ old('color', $moto->color) }}" maxlength="30"
                           placeholder="Ej: Rojo">
                </div>
                <div class="col-6">
                    <label class="form-label" for="fecha_ultimo_mantenimiento">Fecha de último mantenimiento</label>
                    <input type="date" name="fecha_ultimo_mantenimiento" id="fecha_ultimo_mantenimiento"
                           class="form-control" value="{{ old('fecha_ultimo_mantenimiento', $moto->fecha_ultimo_mantenimiento) }}">
                </div>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success" style="width: auto; padding: 10px 25px;">
                    Actualizar Motocicleta
                </button>
                <a href="{{ route('motos.index') }}" class="btn btn-danger" style="width: auto; padding: 10px 25px;">
                    Cancelar
                </a>
            </div>
        </form>

    </div>

</div>
@endsection