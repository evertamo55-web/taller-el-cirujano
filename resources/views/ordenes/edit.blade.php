@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 style="margin: 0; color: #343a40; font-size: 1.8rem;">Editar Orden de Servicio</h1>
            <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 0.9rem;">
                Orden #{{ $orden->id_orden_servicio }} — Actualice el estado, diagnóstico o datos generales.
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

        <form method="POST" action="{{ route('ordenes.update', $orden->id_orden_servicio) }}">
            @csrf
            @method('PUT')

            {{-- Fila 1: Moto y Técnico --}}
            <div class="row">
                <div class="col-6">
                    <label class="form-label" for="id_moto">Motocicleta *</label>
                    <select name="id_moto" id="id_moto" class="form-select" required>
                        @foreach($motos as $moto)
                            <option value="{{ $moto->id_moto }}"
                                {{ old('id_moto', $orden->id_moto) == $moto->id_moto ? 'selected' : '' }}>
                                {{ $moto->placa }} — {{ $moto->marca }} {{ $moto->modelo }}
                                @if($moto->cliente)
                                    ({{ $moto->cliente->nombre }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label" for="id_empleado">Técnico Asignado *</label>
                    <select name="id_empleado" id="id_empleado" class="form-select" required>
                        @foreach($empleados as $empleado)
                            <option value="{{ $empleado->id_empleado }}"
                                {{ old('id_empleado', $orden->id_empleado) == $empleado->id_empleado ? 'selected' : '' }}>
                                {{ $empleado->nombre_empleado }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Fila 2: Falla reportada --}}
            <div class="row">
                <div class="col-12">
                    <label class="form-label" for="descripcion_falla">Descripción de la Falla / Problema Reportado *</label>
                    <textarea name="descripcion_falla" id="descripcion_falla" class="form-control"
                              rows="3" required>{{ old('descripcion_falla', $orden->descripcion_falla) }}</textarea>
                </div>
            </div>

            {{-- Fila 3: Diagnóstico técnico --}}
            <div class="row">
                <div class="col-12">
                    <label class="form-label" for="diagnostico_tecnico">Diagnóstico Técnico</label>
                    <textarea name="diagnostico_tecnico" id="diagnostico_tecnico" class="form-control"
                              rows="3" placeholder="Ingrese el diagnóstico del mecánico (opcional)">{{ old('diagnostico_tecnico', $orden->diagnostico_tecnico) }}</textarea>
                </div>
            </div>

            {{-- Fila 4: Estado del servicio --}}
            <div class="row">
                <div class="col-6">
                    <label class="form-label" for="estado_servicio">Estado del Servicio *</label>
                    <select name="estado_servicio" id="estado_servicio" class="form-select" required>
                        <option value="pendiente"   {{ old('estado_servicio', $orden->estado_servicio) == 'pendiente'   ? 'selected' : '' }}>Pendiente</option>
                        <option value="en_progreso" {{ old('estado_servicio', $orden->estado_servicio) == 'en_progreso' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completado"  {{ old('estado_servicio', $orden->estado_servicio) == 'completado'  ? 'selected' : '' }}>Completado</option>
                        <option value="entregado"   {{ old('estado_servicio', $orden->estado_servicio) == 'entregado'   ? 'selected' : '' }}>Entregado</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">Mano de Obra Registrada</label>
                    <input type="text" class="form-control"
                           value="Bs. {{ number_format($orden->total_mano_obra, 2) }}"
                           readonly
                           style="background-color: #f8f9fa; font-weight: 700; color: #198754;">
                    <small style="color: #6c757d; font-size: 0.8rem;">
                        Corte Taller: Bs. {{ number_format($orden->ganancia_taller, 2) }} |
                        Corte Técnico: Bs. {{ number_format($orden->ganancia_tecnico, 2) }}
                    </small>
                </div>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-warning" style="width: auto; padding: 10px 25px;">
                    Actualizar Orden
                </button>
                <a href="{{ route('ordenes.index') }}" class="btn btn-danger" style="width: auto; padding: 10px 25px;">
                    Cancelar
                </a>
            </div>
        </form>

    </div>

</div>
@endsection