@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 style="margin: 0; font-weight: 800;">Apertura de Orden de Trabajo</h1>
            <p style="color: #6c757d; margin-top: 5px; margin-bottom: 0;">
                Registro transaccional de ingreso de motocicleta al taller.
            </p>
        </div>
        <a href="{{ route('ordenes.index') }}" class="btn btn-primary" style="width: auto; padding: 10px 20px;">
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

        <form method="POST" action="{{ route('ordenes.store') }}" id="form-orden">
            @csrf

            {{-- Fila 1: Moto y Técnico --}}
            <div class="row">
                <div class="col-6">
                    <label class="form-label" for="id_moto">Seleccionar Motocicleta (Placa) *</label>
                    <select name="id_moto" id="id_moto" class="form-select" required>
                        <option value="">-- Seleccione --</option>
                        @foreach($motos as $moto)
                            <option value="{{ $moto->id_moto }}" {{ old('id_moto') == $moto->id_moto ? 'selected' : '' }}>
                                {{ $moto->placa ?? 'Sin placa' }} — {{ $moto->marca }} {{ $moto->modelo }}
                                @if($moto->cliente)
                                    ({{ $moto->cliente->nombre }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label" for="id_empleado">Asignar Técnico Mecánico *</label>
                    <select name="id_empleado" id="id_empleado" class="form-select" required>
                        <option value="">-- Seleccione --</option>
                        @foreach($empleados as $empleado)
                            <option value="{{ $empleado->id_empleado }}" {{ old('id_empleado') == $empleado->id_empleado ? 'selected' : '' }}>
                                {{ $empleado->nombre_empleado }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Fila 2: Descripción de la falla --}}
            <div class="row">
                <div class="col-12">
                    <label class="form-label" for="descripcion_falla">Descripción de la Falla / Problema Reportado *</label>
                    <textarea name="descripcion_falla" id="descripcion_falla" class="form-control"
                              rows="3" required
                              placeholder="Ej. El motor pierde fuerza en subidas y humea azul...">{{ old('descripcion_falla') }}</textarea>
                </div>
            </div>

            {{-- Fila 3: Servicios (Mano de Obra) - AHORA OPCIONAL --}}
            <div class="row" style="margin-top: 15px;">
                <div class="col-12">
                    <label class="form-label" style="font-weight: 800; color: #198754;">
                        Servicios a Realizar (Mano de Obra)
                    </label>
                    <small style="color: #6c757d; display: block; margin-bottom: 10px;">
                        Opcional: Puede seleccionar uno o varios servicios, o dejarlo vacío si aún no se define.
                    </small>
                    @foreach($servicios as $index => $servicio)
                        <div style="display: flex; align-items: center; gap: 15px; padding: 10px; background: #f8f9fa; border-radius: 6px; margin-bottom: 8px;">
                            
                            <input type="checkbox"
                                   name="servicios[{{ $servicio->id_servicio }}][id_servicio]"
                                   id="servicio_{{ $servicio->id_servicio }}"
                                   value="{{ $servicio->id_servicio }}"
                                   style="width: 20px; height: 20px;"
                                   onchange="toggleRepuesto({{ $servicio->id_servicio }}, this.checked)">
                            
                            <label for="servicio_{{ $servicio->id_servicio }}" style="flex: 1; margin: 0; font-weight: 600; cursor: pointer;">
                                {{ $servicio->nombre_servicio }} — Bs. {{ number_format($servicio->precio_mano_obra, 2) }}
                            </label>
                            
                            <input type="text"
                                   name="servicios[{{ $servicio->id_servicio }}][repuesto_cliente]"
                                   id="repuesto_{{ $servicio->id_servicio }}"
                                   placeholder="Repuesto traído por el cliente (opcional)"
                                   class="form-control"
                                   style="max-width: 320px; display: none;"
                                   disabled>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Fila 4: Herramientas en custodia --}}
            <div class="row" style="margin-top: 15px;">
                <div class="col-12">
                    <label class="form-label" style="font-weight: 800; color: #0d6efd;">
                        Herramientas Requeridas (Préstamo Custodia)
                    </label>
                    @foreach($herramientas as $herramienta)
                        <div style="display: flex; align-items: center; gap: 15px; padding: 10px; background: #f8f9fa; border-radius: 6px; margin-bottom: 8px;">
                            <input type="checkbox"
                                   name="herramientas[]"
                                   id="herramienta_{{ $herramienta->id_herramienta }}"
                                   value="{{ $herramienta->id_herramienta }}"
                                   style="width: 20px; height: 20px;">
                            <label for="herramienta_{{ $herramienta->id_herramienta }}" style="flex: 1; margin: 0; font-weight: 600; cursor: pointer;">
                                {{ $herramienta->nombre_herramienta }}
                                <small style="color: #6c757d; font-weight: 400;">({{ $herramienta->codigo_herramienta }})</small>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-warning" style="width: auto; padding: 12px 30px; font-weight: 800;">
                    Abrir Orden Transaccional
                </button>
                <a href="{{ route('ordenes.index') }}" class="btn btn-danger" style="width: auto; padding: 12px 30px;">
                    Cancelar
                </a>
            </div>
        </form>

    </div>

</div>

<script>
    function toggleRepuesto(idServicio, marcado) {
        const input = document.getElementById('repuesto_' + idServicio);
        if (input) {
            input.style.display = marcado ? 'block' : 'none';
            input.disabled = !marcado;
            if (!marcado) input.value = '';
        }
    }
</script>
@endsection