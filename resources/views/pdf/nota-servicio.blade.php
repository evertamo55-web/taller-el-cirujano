<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de Servicio #{{ str_pad($orden->id_orden_servicio, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body { font-family: 'Helvetica', Arial, sans-serif; font-size: 14px; color: #333; margin: 40px; }
        .header { text-align: center; border-bottom: 3px solid #ffc107; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 24px; color: #333; }
        .header p { margin: 5px 0; color: #666; }
        .section { margin-bottom: 25px; }
        .section h3 { color: #0d6efd; border-bottom: 1px solid #dee2e6; padding-bottom: 8px; margin-bottom: 15px; }
        .row { display: flex; margin-bottom: 15px; }
        .col { flex: 1; }
        .label { font-weight: bold; color: #495057; }
        .value { color: #212529; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #343a40; color: #fff; padding: 10px; text-align: left; }
        td { padding: 10px; border-bottom: 1px solid #dee2e6; }
        .totals { text-align: right; margin-top: 20px; }
        .totals p { margin: 5px 0; }
        .total-final { font-size: 18px; font-weight: 900; color: #198754; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; }
        .badge-pendiente { background: #6c757d; color: #fff; }
        .badge-en_progreso { background: #0d6efd; color: #fff; }
        .badge-completado { background: #198754; color: #fff; }
        .badge-entregado { background: #ffc107; color: #000; }
        .footer { margin-top: 40px; padding-top: 20px; border-top: 1px solid #dee2e6; text-align: center; color: #6c757d; font-size: 12px; }
        .info-box { background: #f8f9fa; border-left: 4px solid #ffc107; padding: 15px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>TALLER MECÁNICO "EL CIRUJANO"</h1>
        <p>Servicio Especializado de Mantenimiento Preventivo y Correctivo</p>
        <p>Trinidad, Beni — Bolivia</p>
    </div>

    <div class="section">
        <div class="row">
            <div class="col">
                <p class="label">ORDEN DE TRABAJO #{{ str_pad($orden->id_orden_servicio, 5, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="col" style="text-align: right;">
                <p class="label">Fecha: {{ $orden->fecha_recepcion }}</p>
                <p>
                    Estado:
                    <span class="badge badge-{{ $orden->estado_servicio }}">
                        {{ strtoupper($orden->estado_servicio) }}
                    </span>
                </p>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Información del Cliente</h3>
        <div class="row">
            <div class="col">
                <p><span class="label">Nombre:</span> {{ $orden->moto->cliente->nombre ?? 'N/A' }}</p>
                <p><span class="label">CI / NIT:</span> {{ $orden->moto->cliente->nit_ci ?? 'N/A' }}</p>
            </div>
            <div class="col">
                <p><span class="label">Teléfono:</span> {{ $orden->moto->cliente->telefono ?? 'N/A' }}</p>
                <p><span class="label">Dirección:</span> {{ $orden->moto->cliente->direccion ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Datos del Vehículo</h3>
        <div class="row">
            <div class="col">
                <p><span class="label">Placa:</span>
                    @if($orden->moto->placa)
                        {{ $orden->moto->placa }}
                    @else
                        <span style="color: #dc3545;">NO TIENE PLACA</span>
                    @endif
                </p>
                <p><span class="label">Marca / Modelo:</span> {{ $orden->moto->marca }} — {{ $orden->moto->modelo }}</p>
            </div>
            <div class="col">
                <p><span class="label">Color:</span> {{ $orden->moto->color ?? 'N/A' }}</p>
                <p><span class="label">Mecánico Asigned:</span> {{ $orden->empleado->nombre_empleado ?? 'N/A' }}</p>
            </div>
        </div>
    </div>

    <div class="section">
        <h3>Falla Reportada por el Cliente</h3>
        <div class="info-box">
            {{ $orden->descripcion_falla }}
        </div>
    </div>

    <div class="section">
        <h3>Trabajos Realizados y Repuestos Suministrados</h3>
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
                        <td colspan="4" style="text-align: center; color: #6c757d;">No hay servicios registrados en esta orden.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="totals">
        <p class="total-final">TOTAL A PAGAR (Mano de Obra Liquida): Bs. {{ number_format($orden->total_mano_obra, 2) }}</p>
        <p>Corte Taller (50%): Bs. {{ number_format($orden->ganancia_taller, 2) }}</p>
        <p>Corte Técnico (50%): Bs. {{ number_format($orden->ganancia_tecnico, 2) }}</p>
    </div>

    <div class="footer">
        <p>© {{ date('Y') }} Taller Mecánico "El Cirujano" - Trinidad, Beni</p>
        <p>Este documento es un comprobante formal del servicio realizado.</p>
    </div>

</body>
</html>
