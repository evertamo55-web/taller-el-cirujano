@extends('layouts.app')

@section('content')
<div class="container">

    <div style="margin-bottom: 25px;">
        <h1 style="margin: 0; color: #343a40; font-size: 1.8rem;">Liquidación Financiera y Comisiones 50/50</h1>
        <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 0.9rem;">
            Consolidado dinámico de mano de obra en tiempo real (Respetando la 3NF en MySQL)
        </p>
    </div>

    {{-- Filtros de fecha --}}
    <div class="card mb-3" style="padding: 15px;">
        <form method="GET" action="{{ route('admin.ganancias') }}" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: end;">
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

    {{-- Tarjetas resumen --}}
    <div class="row" style="margin-bottom: 20px;">
        <div class="col-3">
            <div class="card" style="border-top: 4px solid #6c757d;">
                <p style="margin: 0; color: #6c757d; font-size: 0.85rem; font-weight: 700;">TOTAL BRUTO MANO DE OBRA</p>
                <p style="margin: 8px 0 0 0; font-size: 1.5rem; font-weight: 900; color: #343a40;">
                    Bs. {{ number_format($totalBruto, 2) }}
                </p>
            </div>
        </div>
        <div class="col-3">
            <div class="card" style="border-top: 4px solid #0d6efd;">
                <p style="margin: 0; color: #0d6efd; font-size: 0.85rem; font-weight: 700;">PAGO ACUMULADO TÉCNICOS (50%)</p>
                <p style="margin: 8px 0 0 0; font-size: 1.5rem; font-weight: 900; color: #0d6efd;">
                    Bs. {{ number_format($totalTecnicos, 2) }}
                </p>
            </div>
        </div>
        <div class="col-3">
            <div class="card" style="border-top: 4px solid #198754;">
                <p style="margin: 0; color: #198754; font-size: 0.85rem; font-weight: 700;">INGRESO NETO TALLER (50%)</p>
                <p style="margin: 8px 0 0 0; font-size: 1.5rem; font-weight: 900; color: #198754;">
                    Bs. {{ number_format($totalTaller, 2) }}
                </p>
            </div>
        </div>
        <div class="col-3">
            <div class="card" style="border-top: 4px solid #ffc107;">
                <p style="margin: 0; color: #856404; font-size: 0.85rem; font-weight: 700;">MOTOS ATENDIDAS</p>
                <p style="margin: 8px 0 0 0; font-size: 1.5rem; font-weight: 900; color: #856404;">
                    {{ $totalMotos }}
                </p>
            </div>
        </div>
    </div>

    {{-- Tabla de desglose por técnico --}}
    <div class="card">
        <h3 style="margin-top: 0; color: #343a40; font-size: 1.1rem;">Desglose Individual de Producción por Técnico Mecánico</h3>

        @if($reporte->isEmpty())
            <p style="text-align: center; padding: 30px; color: #6c757d;">
                No hay registros de liquidaciones en este período contable.
            </p>
        @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Técnico Mecánico</th>
                            <th>Motos Atendidas</th>
                            <th>Mano de Obra Bruta</th>
                            <th style="color: #0d6efd;">Comisión Técnico (50%)</th>
                            <th style="color: #198754;">Ingreso Taller (50%)</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reporte as $item)
                            <tr>
                                <td><strong>{{ $item->nombre_empleado }}</strong></td>
                                <td>{{ $item->total_motos_atendidas }}</td>
                                <td>Bs. {{ number_format($item->total_mano_obra_bruto, 2) }}</td>
                                <td style="color: #0d6efd; font-weight: 700;">
                                    Bs. {{ number_format($item->ganancia_tecnico_50, 2) }}
                                </td>
                                <td style="color: #198754; font-weight: 700;">
                                    Bs. {{ number_format($item->ganancia_taller_50, 2) }}
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('tecnico.finalizarJornada', $item->id_empleado) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">
                                            Finalizar Jornada
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection