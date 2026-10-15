@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 style="margin: 0; color: #343a40; font-size: 1.8rem;">Editar Cliente</h1>
            <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 0.9rem;">
                Actualice los datos del cliente {{ $cliente->nombre }}.
            </p>
        </div>
        <a href="{{ route('clientes.index') }}" class="btn btn-primary" style="width: auto; padding: 10px 20px;">
            ← Volver al listado
        </a>
    </div>

    <div class="card border-warning">

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

        <form method="POST" action="{{ route('clientes.update', $cliente->id_cliente) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-6">
                    <label class="form-label" for="nombre">Nombre completo *</label>
                    <input type="text" name="nombre" id="nombre" class="form-control"
                           value="{{ old('nombre', $cliente->nombre) }}" required maxlength="100">
                </div>
                <div class="col-6">
                    <label class="form-label" for="nit_ci">NIT / CI *</label>
                    <input type="text" name="nit_ci" id="nit_ci" class="form-control"
                           value="{{ old('nit_ci', $cliente->nit_ci) }}" required maxlength="20">
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label class="form-label" for="telefono">Teléfono *</label>
                    <input type="text" name="telefono" id="telefono" class="form-control"
                           value="{{ old('telefono', $cliente->telefono) }}" required maxlength="20">
                </div>
                <div class="col-6">
                    <label class="form-label" for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control"
                           value="{{ old('direccion', $cliente->direccion) }}" maxlength="255">
                </div>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-warning" style="width: auto; padding: 10px 25px;">
                    Actualizar Cliente
                </button>
                <a href="{{ route('clientes.index') }}" class="btn btn-danger" style="width: auto; padding: 10px 25px;">
                    Cancelar
                </a>
            </div>
        </form>

    </div>

</div>
@endsection