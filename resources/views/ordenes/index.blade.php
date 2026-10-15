@extends('layouts.app')

@section('content')
<div class="container">

    {{-- Encabezado con botón Nueva Orden --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 style="margin: 0; font-weight: 800;">Gestión de Órdenes de Servicio</h1>
            <p style="color: #6c757d; margin-top: 5px; margin-bottom: 0;">
                Historial transaccional de órdenes registradas en el taller.
            </p>
        </div>
        <a href="{{ route('ordenes.create') }}" class="btn btn-warning" style="width: auto; padding: 10px 20px;">
            + Aperturar Nueva Orden
        </a>
    </div>

    {{-- Tabla de órdenes --}}
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th># Orden</th>
                    <th>Motocicleta (Placa)</th>
                    <th>Técnico Asignado</th>
                    <th>Fecha Recepción</th>
                    <th>Mano de Obra Bruta</th>
                    <th style="color: #198754;">Corte Taller (50%)</th>
                    <th style="color: #0d6efd;">Corte Técnico (50%)</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ordenes as $o)
                    <tr>
                        <td><strong>#{{ $o->id_orden_servicio }}</strong></td>
                        <td>
                            <span class="badge" style="background-color: #212529; color: #ffc107; font-family: monospace; padding: 6px 10px;">
                                {{ $o->moto->placa ?? 'S/P' }}
                            </span>
                            <br>
                            <small style="color: #6c757d;">
                                {{ $o->moto->marca ?? '' }} {{ $o->moto->modelo ?? '' }}
                            </small>
                        </td>
                        <td>
                            {{ $o->empleado->nombre_empleado ?? 'No asignado' }}
                        </td>
                        <td class="font-monospace text-muted">{{ $o->fecha_recepcion }}</td>
                        <td><strong>Bs. {{ number_format($o->total_mano_obra, 2) }}</strong></td>
                        <td style="color: #198754; font-weight: 700;">
                            Bs. {{ number_format($o->ganancia_taller, 2) }}
                        </td>
                        <td style="color: #0d6efd; font-weight: 700;">
                            Bs. {{ number_format($o->ganancia_tecnico, 2) }}
                        </td>
                        <td>
                            @php
                                $colores = [
                                    'pendiente'   => '#6c757d',
                                    'en_progreso' => '#0d6efd',
                                    'completado'  => '#198754',
                                    'entregado'   => '#20c997',
                                ];
                                $color = $colores[$o->estado_servicio] ?? '#6c757d';
                            @endphp
                            <span class="badge" style="background-color: {{ $color }};">
                                {{ ucfirst(str_replace('_', ' ', $o->estado_servicio)) }}
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; gap: 6px;">
                                <a href="{{ route('ordenes.show', $o->id_orden_servicio) }}"
                                   class="btn btn-primary"
                                   style="width: auto; padding: 6px 12px; font-size: 0.8rem;">
                                    Ver Nota
                                </a>
                                <a href="{{ route('ordenes.edit', $o->id_orden_servicio) }}"
                                   class="btn btn-success"
                                   style="width: auto; padding: 6px 12px; font-size: 0.8rem;">
                                    Editar
                                </a>
                                <form method="POST"
                                      action="{{ route('ordenes.destroy', $o->id_orden_servicio) }}"
                                      style="display: inline;"
                                      onsubmit="return confirm('¿Está seguro de eliminar esta orden?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger"
                                            style="width: auto; padding: 6px 12px; font-size: 0.8rem;">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: #6c757d; padding: 30px 0;">
                            No hay órdenes de servicio registradas en el sistema local.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection