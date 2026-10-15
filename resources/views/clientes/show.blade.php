@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 style="margin: 0; color: #343a40; font-size: 1.8rem;">Detalle del Cliente</h1>
            <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 0.9rem;">
                Información completa del propietario y sus motocicletas.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('clientes.edit', $cliente->id_cliente) }}" class="btn btn-success" style="width: auto; padding: 10px 20px;">
                Editar
            </a>
            <a href="{{ route('clientes.index') }}" class="btn btn-primary" style="width: auto; padding: 10px 20px;">
                ← Volver
            </a>
        </div>
    </div>

    {{-- Datos del cliente --}}
    <div class="card border-primary">
        <h3 class="card-title" style="color: #0d6efd;">Datos Personales</h3>

        <div class="row">
            <div class="col-6">
                <p style="margin: 5px 0;"><strong>Nombre:</strong> {{ $cliente->nombre }}</p>
                <p style="margin: 5px 0;"><strong>NIT / CI:</strong> {{ $cliente->nit_ci }}</p>
            </div>
            <div class="col-6">
                <p style="margin: 5px 0;"><strong>Teléfono:</strong> {{ $cliente->telefono }}</p>
                <p style="margin: 5px 0;"><strong>Dirección:</strong> {{ $cliente->direccion ?? '—' }}</p>
            </div>
        </div>
    </div>

    {{-- Motocicletas asociadas --}}
    <div class="card border-success">
        <h3 class="card-title" style="color: #198754;">
            Motocicletas Registradas ({{ $cliente->motos->count() }})
        </h3>

        @if($cliente->motos->isEmpty())
            <p class="card-text" style="text-align: center; padding: 20px;">
                Este cliente no tiene motocicletas registradas todavía.
            </p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Placa</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Color</th>
                            <th>Último Mantenimiento</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cliente->motos as $moto)
                        <tr>
                            <td><span class="badge" style="background-color: #212529;">{{ $moto->placa }}</span></td>
                            <td>{{ $moto->marca }}</td>
                            <td>{{ $moto->modelo }}</td>
                            <td>{{ $moto->color ?? '—' }}</td>
                            <td>{{ $moto->fecha_ultimo_mantenimiento ?? 'Sin registro' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection