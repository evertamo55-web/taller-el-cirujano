@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Encabezado --}}
    <div class="card border-warning" style="margin-bottom: 20px;">
        <h2 class="card-title" style="color: #b8860b;">Panel del Técnico Mecánico</h2>
        <p class="card-text">
            Bienvenido, <strong>{{ Auth::user()->name }}</strong>. 
            Aquí puedes consultar tus trabajos asignados y tu comisión acumulada del 50%.
        </p>
    </div>

    {{-- Tarjetas de resumen (diseño móvil optimizado) --}}
    <div class="row">
        <div class="col-6">
            <div class="card border-primary" style="text-align: center;">
                <p style="font-size: 0.8rem; color: #6c757d; margin: 0; text-transform: uppercase; font-weight: 700;">
                    Motos Atendidas
                </p>
                <h3 style="font-size: 2.2rem; margin: 10px 0 0 0; color: #0d6efd;">
                    {{ $motosAtendidas }}
                </h3>
            </div>
        </div>
        <div class="col-6">
            <div class="card border-success" style="text-align: center;">
                <p style="font-size: 0.8rem; color: #6c757d; margin: 0; text-transform: uppercase; font-weight: 700;">
                    Mano de Obra Bruta
                </p>
                <h3 style="font-size: 1.8rem; margin: 10px 0 0 0; color: #198754;">
                    Bs. {{ number_format($totalManoObra, 2) }}
                </h3>
            </div>
        </div>
    </div>

    {{-- Comisión destacada del 50% --}}
    <div class="card" style="background: linear-gradient(135deg, #198754 0%, #0f5132 100%); color: #fff; text-align: center;">
        <p style="font-size: 0.9rem; margin: 0; text-transform: uppercase; font-weight: 700; opacity: 0.9;">
            Tu Comisión Acumulada (50%)
        </p>
        <h1 style="font-size: 3rem; margin: 10px 0; font-weight: 700;">
            Bs. {{ number_format($comisionTecnico, 2) }}
        </h1>
        <p style="font-size: 0.8rem; margin: 0; opacity: 0.85;">
            Calculado sobre mano de obra de órdenes entregadas
        </p>
    </div>

    {{-- Lista de trabajos pendientes --}}
    <div class="card border-warning">
        <h3 class="card-title">Mis Trabajos Asignados</h3>

        @if($ordenesPendientes->isEmpty())
            <p class="card-text" style="text-align: center; padding: 20px;">
                No tienes trabajos pendientes por el momento.
            </p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Moto</th>
                            <th>Cliente</th>
                            <th>Falla Reportada</th>
                            <th>Mano de Obra</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ordenesPendientes as $orden)
                        <tr>
                            <td><strong>#{{ $orden->id_orden_servicio }}</strong></td>
                            <td>
                                <strong>{{ $orden->placa }}</strong><br>
                                <small style="color: #6c757d;">{{ $orden->marca }} {{ $orden->modelo }}</small>
                            </td>
                            <td>{{ $orden->nombre_cliente }}</td>
                            <td style="font-size: 0.85rem;">{{ Str::limit($orden->descripcion_falla, 50) }}</td>
                            <td><strong>Bs. {{ number_format($orden->total_mano_obra, 2) }}</strong></td>
                            <td>
                                @if($orden->estado_servicio === 'pendiente')
                                    <span class="badge" style="background-color: #6c757d;">Pendiente</span>
                                @elseif($orden->estado_servicio === 'en_progreso')
                                    <span class="badge" style="background-color: #0d6efd;">En Progreso</span>
                                @else
                                    <span class="badge" style="background-color: #198754;">Completado</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Nota informativa --}}
    <div class="card" style="background: #fff3cd; border-left: 4px solid #ffc107;">
        <p style="font-size: 0.85rem; margin: 0; color: #664d03;">
            <strong>Nota:</strong> El monto mostrado corresponde al 50% de la mano de obra 
            de las órdenes que hayas completado y que ya fueron entregadas al cliente. 
            El propietario valida este mismo reporte desde su panel administrativo.
        </p>
    </div>

</div>
@endsection