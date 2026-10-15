@extends('layouts.app')

@section('content')
<div class="container">

    <div style="margin-bottom: 25px;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.8rem;">Reportes de Trabajos Realizados</h1>
        <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 0.9rem;">
            Detalle completo de cada orden: cliente, moto, técnico y servicios realizados.
        </p>
    </div>

    {{-- Filtros de fecha --}}
    <div class="card mb-3" style="padding: 15px;">
        <form method="GET" action="{{ route('admin.reportes') }}" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: end;">
            <div>
                <label for="fecha_inicio" style="font-weight: 700; display: block; margin-bottom: 5px;">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ $fechaInicio }}">
            </div>
            <div>
                <label for="fecha_fin" style="font-weight: 700; display: block; margin-bottom: 5px;">Fecha Fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ $fechaFin }}">
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="padding: 10px 25px;">Filtrar</button>
            </div>
        </form>
    </div>

    @if($ordenes->isEmpty())
        <div class="card">
            <p style="text-align: center; padding: 30px; color: #6c757d;">
                No hay órdenes registradas en este período.
            </p>
        </div>
    @else
        @foreach($ordenes as $o)
            <div class="card" style="margin-bottom: 20px;">
                
                {{-- Encabezado de la orden --}}
                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #ffc107; padding-bottom: 10px; margin-bottom: 15px;">
                    <h3 style="margin: 0; color: #343a40;">
                        Orden #{{ str_pad($o->id_orden_servicio, 5, '0', STR_PAD_LEFT) }}
                    </h3>
                    <span class="badge" style="background-color: 
                        @if($o->estado_servicio == 'pendiente') #6c757d
                        @elseif($o->estado_servicio == 'en_progreso') #0d6efd
                        @elseif($o->estado_servicio == 'completado') #198754
                        @else #20c997
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $o->estado_servicio)) }}
                    </span>
                </div>

                {{-- Datos del cliente y vehículo --}}
                <div class="row" style="margin-bottom: 15px;">
                    <div class="col-6">
                        <p><strong>Cliente:</strong> {{ $o->nombre_cliente }}</p>
                        <p><strong>NIT/CI:</strong> {{ $o->nit_ci }}</p>
                        <p><strong>Fecha:</strong> {{ $o->fecha_recepcion }}</p>
                    </div>
                    <div class="col-6">
                        <p><strong>Moto:</strong> 
                            @if($o->placa)
                                <span class="badge" style="background-color: #343a40;">{{ $o->placa }}</span>
                            @else
                                <span class="badge" style="background-color: #6c757d;">Sin placa</span>
                            @endif
                            — {{ $o->marca }} {{ $o->modelo }}
                        </p>
                        <p><strong>Técnico Asignado:</strong> {{ $o->nombre_empleado }}</p>
                        <p><strong>Falla Reportada:</strong> {{ $o->descripcion_falla }}</p>
                    </div>
                </div>

                {{-- Servicios realizados --}}
                <h4 style="color: #0d6efd; margin-top: 15px; font-size: 1rem;">Servicios Realizados</h4>
                @if(isset($serviciosPorOrden[$o->id_orden_servicio]) && $serviciosPorOrden[$o->id_orden_servicio]->count() > 0)
                    <table class="table" style="margin-bottom: 15px;">
                        <thead>
                            <tr>
                                <th>Servicio / Mano de Obra</th>
                                <th>Repuesto Traído por el Cliente</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($serviciosPorOrden[$o->id_orden_servicio] as $servicio)
                                <tr>
                                    <td>{{ $servicio->nombre_servicio }}</td>
                                    <td>{{ $servicio->repuesto_traido_cliente ?? 'Ninguno' }}</td>
                                    <td>Bs. {{ number_format($servicio->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color: #6c757d; font-style: italic;">No se registraron servicios en esta orden.</p>
                @endif

                {{-- Totales --}}
                <div style="text-align: right; border-top: 1px solid #dee2e6; padding-top: 10px;">
                    <p style="margin: 5px 0;"><strong>Total Mano de Obra:</strong> Bs. {{ number_format($o->total_mano_obra, 2) }}</p>
                    <p style="margin: 5px 0; color: #198754;"><strong>Corte Taller (50%):</strong> Bs. {{ number_format($o->ganancia_taller, 2) }}</p>
                    <p style="margin: 5px 0; color: #0d6efd;"><strong>Corte Técnico (50%):</strong> Bs. {{ number_format($o->ganancia_tecnico, 2) }}</p>
                </div>

            </div>
        @endforeach
    @endif

</div>
@endsection