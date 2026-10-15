@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <h1 style="margin: 0; font-weight: 800;">Editar Servicio</h1>
        <a href="{{ route('admin.servicios.index') }}" class="btn btn-primary" style="width: auto; padding: 10px 20px;">
            ← Volver al listado
        </a>
    </div>

    <div class="card border-success">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.servicios.update', $servicio->id_servicio) }}">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-12">
                    <label class="form-label" for="nombre_servicio">Nombre del Servicio *</label>
                    <input type="text" name="nombre_servicio" id="nombre_servicio"
                           class="form-control" value="{{ old('nombre_servicio', $servicio->nombre_servicio) }}"
                           required maxlength="150">
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <label class="form-label" for="precio_mano_obra">Precio Mano de Obra (Bs.) *</label>
                    <input type="number" name="precio_mano_obra" id="precio_mano_obra"
                           class="form-control" value="{{ old('precio_mano_obra', $servicio->precio_mano_obra) }}"
                           required step="0.01" min="0">
                </div>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success" style="width: auto; padding: 10px 25px;">
                    Actualizar Servicio
                </button>
                <a href="{{ route('admin.servicios.index') }}" class="btn btn-danger" style="width: auto; padding: 10px 25px;">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

</div>
@endsection