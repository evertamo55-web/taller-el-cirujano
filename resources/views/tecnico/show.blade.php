@extends('layouts.app')

@section('content')

    {{-- Botones superiores --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <a href="{{ route('ordenes.index') }}" class="btn btn-primary">
            ← Volver al listado
        </a>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('ordenes.edit', $orden->id_orden_servicio) }}" class="btn btn-success">
                Editar
            </a>
            <a href="#" onclick="window.print()" class="btn btn-warning">
                Imprimir Nota de Servicio
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ============ BOTONES DE CAMBIO DE ESTADO ============ --}}
    <div class="card" style="background: #fff3cd; border-left: 5px solid #ffc107;">
        <h4 style="margin-top: 0; color: #856404;">🔄 Acciones sobre la Orden</h4>
        <p style="margin: 5px 0 15px 0; color: #856404;">
            Estado actual: 
            <span class="badge" style="font-size: 1rem; padding: 6px 14px; background: 
                @if($orden->estado_servicio == 'pendiente') #6c757d
                @elseif($orden->estado_servicio == 'en_progreso') #0d6efd
                @elseif($orden->estado_servicio == 'completado') #198754
                @else #ffc107; color: #000
                @endif">
                {{ strtoupper($orden->estado_servicio) }}
            </span>
        </p>

        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            @if($orden->estado_servicio == 'pendiente')
                <form method="POST" action="{{ route('ordenes.cambiarEstado', $orden->id_orden_servicio) }}">
                    @csrf
                    <input type="hidden" name="estado_servicio" value="en_progreso">
                    <button type="submit" class="btn btn-primary">▶️ Iniciar Trabajo</button>
                </form>
            @endif

            @if($orden->estado_servicio == 'en_progreso')
                <form method="POST" action="{{ route('ordenes.cambiarEstado', $orden->id_orden_servicio) }}">
                    @csrf
                    <input type="hidden" name="estado_servicio" value="completado">
                    <button type="submit" class="btn btn-success">✔️ Marcar como Completado</button>
                </form>
            @endif

            @if($orden->estado_servicio == 'completado')
                <form method="POST" action="{{ route('ordenes.registrarPago', $orden->id_orden_servicio) }}">
                    @csrf
                    <button type="submit" class="btn btn-warning" style="font-weight: 800;">
                        💰 Registrar Pago y Entregar
                    </button>
                </form>
            @endif

            @if($orden->estado_servicio == 'entregado')
                <div class="alert alert-success" style="margin: 0;">
                    ✅ Orden entregada y pagada. Comisión 50/50 liquidada.
                </div>
            @endif
        </div>
    </div>

    {{-- ============ NOTA DE SERVICIO ============ --}}
    <div class="card">

        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="margin: 0; font-weight: 900; color: #343a40;">TALLER MECÁNICO "EL CIRUJANO"</h1>
            <p style="margin: 5px 0; color: #6c757d;">Servicio Especializado de Mantenimiento Preventivo y Correctivo</p>
            <p style="margin: 0; color: #6c757d;">Trinidad, Beni — Bolivia</p>
        </div>

        <hr style="border: 2px solid #ffc107;">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
            <h3 style="margin: 0;">ORDEN DE TRABAJO #{{ str_pad($orden->id_orden_servicio, 5, '0', STR_PAD_LEFT) }}</h3>
            <span style="color: #6c757d; font-weight: 600;">Fecha: {{ $orden->fecha_recepcion }}</span>
        </div>

        {{-- Información del Cliente --}}
        <h4 style="color: #0d6efd; margin-top: 30px;">Información del Cliente</h4>
        <div class="row">
            <div class="col-6">
                <p><strong>Nombre:</strong> {{ $orden->moto->cliente->nombre ?? 'N/A' }}</p>
                <p><strong>CI / NIT:</strong> {{ $orden->moto->cliente->nit_ci ?? 'N/A' }}</p>
            </div>
            <div class="col-6">
                <p><strong>Teléfono:</strong> {{ $orden->moto->cliente->telefono ?? 'N/A' }}</p>
                <p><strong>Dirección:</strong> {{ $orden->moto->cliente->direccion ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Datos del Vehículo --}}
        <h4 style="color: #0d6efd; margin-top: 20px;">Datos del Vehículo</h4>
        <div class="row">
            <div class="col-6">
                <p><strong>Placa:</strong> 
                    @if($orden->moto->placa)
                        <span class="badge" style="background: #343a40; color: #fff; padding: 6px 12px;">{{ $orden->moto->placa }}</span>
                    @else
                        <span class="badge" style="background: #6c757d; color: #fff; padding: 6px 12px;">NO TIENE PLACA</span>
                    @endif
                </p>
                <p><strong>Marca / Modelo:</strong> {{ $orden->moto->marca }} — {{ $orden->moto->modelo }}</p>
            </div>
            <div class="col-6">
                <p><strong>Color:</strong> {{ $orden->moto->color ?? 'N/A' }}</p>
                <p><strong>Mecánico Asignado:</strong> {{ $orden->empleado->nombre_empleado ?? 'N/A' }}</p>
            </div>
        </div>

        {{-- Falla Reportada --}}
        <h4 style="color: #0d6efd; margin-top: 20px;">Falla Reportada por el Cliente</h4>
        <div style="padding: 15px; background: #f8f9fa; border-left: 4px solid #ffc107; margin-bottom: 20px;">
            {{ $orden->descripcion_falla }}
        </div>

        {{-- Trabajos y Repuestos --}}
        <h4 style="color: #0d6efd; margin-top: 20px;">Trabajos Realizados y Repuestos Suministrados</h4>
        <table>
            <thead>
                <tr>
                    <th>Servicio / Mano de Obra</th>
                    <th>Repuesto Traído por el Cliente</th>
                    <th>Costo Repuesto</th>
                    <th>Subtotal Obra</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orden->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->servicio->nombre_servicio ?? 'N/A' }}</td>
                        <td>{{ $detalle->repuesto_traido_cliente ?? 'Ninguno' }}</td>
                        <td>Bs. 0.00</td>
                        <td>Bs. {{ number_format($detalle->subtotal, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #6c757d;">
                            No hay servicios registrados en esta orden.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Totales --}}
        <div style="text-align: right; margin-top: 25px; padding-top: 20px; border-top: 2px solid #e9ecef;">
            <p style="font-size: 1.3rem; margin-bottom: 10px;">
                <strong>TOTAL A PAGAR (Mano de Obra Liquida):</strong> 
                <span style="color: #198754; font-weight: 900;">
                    Bs. {{ number_format($orden->total_mano_obra, 2) }}
                </span>
            </p>
            <p style="color: #6c757d; margin: 5px 0;">Corte Taller (50%): Bs. {{ number_format($orden->ganancia_taller, 2) }}</p>
            <p style="color: #6c757d; margin: 5px 0;">Corte Técnico (50%): Bs. {{ number_format($orden->ganancia_tecnico, 2) }}</p>
        </div>

    </div>

@endsection