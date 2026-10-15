@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <a href="{{ route('motos.index') }}" class="btn btn-primary" style="width: auto; padding: 10px 20px;">
            ← Volver al listado
        </a>
        <a href="{{ route('motos.edit', $moto->id_moto) }}" class="btn btn-success" style="width: auto; padding: 10px 20px;">
            Editar
        </a>
    </div>

    <div class="card" style="padding: 30px;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.8rem;">Detalle de la Motocicleta</h1>
        <p style="margin: 5px 0 25px 0; color: #6c757d; font-size: 0.9rem;">
            Información completa del vehículo y su propietario.
        </p>

        <h4 style="color: #198754; margin-top: 0;">Datos del Vehículo</h4>
        <div class="row">
            <div class="col-6">
                <p><strong>Placa:</strong> 
                    @if($moto->placa)
                        <span class="badge bg-dark">{{ $moto->placa }}</span>
                    @else
                        <span class="badge bg-secondary">NO TIENE PLACA</span>
                    @endif
                </p>
                <p><strong>Marca:</strong> {{ $moto->marca }}</p>
                <p><strong>Modelo:</strong> {{ $moto->modelo }}</p>
            </div>
            <div class="col-6">
                <p><strong>Color:</strong> {{ $moto->color ?? 'N/A' }}</p>
                <p><strong>Último mantenimiento:</strong> {{ $moto->fecha_ultimo_mantenimiento ?? 'N/A' }}</p>
            </div>
        </div>

        <hr style="margin: 25px 0; border: 1px solid #e9ecef;">

        <h4 style="color: #0d6efd; margin-top: 0;">Propietario</h4>
        <div class="row">
            <div class="col-6">
                <p><strong>Nombre:</strong> {{ $moto->cliente->nombre ?? 'N/A' }}</p>
                <p><strong>NIT / CI:</strong> {{ $moto->cliente->nit_ci ?? 'N/A' }}</p>
            </div>
            <div class="col-6">
                <p><strong>Teléfono:</strong> {{ $moto->cliente->telefono ?? 'N/A' }}</p>
                <p><strong>Dirección:</strong> {{ $moto->cliente->direccion ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

</div>
@endsection