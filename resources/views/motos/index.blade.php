@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 style="margin: 0; color: #343a40; font-size: 1.8rem;">Parque Automotor y Control de Vehículos</h1>
            <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 0.9rem;">
                Registro físico de motocicletas indexadas en el taller.
            </p>
        </div>
        <a href="{{ route('motos.create') }}" class="btn btn-success" style="width: auto; padding: 10px 20px;">
            + Nueva Moto
        </a>
    </div>

    {{-- BUSCADOR EN TIEMPO REAL --}}
    <div class="card mb-3" style="padding: 15px;">
        <label for="buscador-motos" style="font-weight: 700; margin-bottom: 8px;">Buscar Motocicleta</label>
        <div class="input-group">
            <span class="input-group-text">&#128269;</span>
            <input type="text" id="buscador-motos" class="form-control"
                   placeholder="Escriba placa, marca, modelo o nombre del propietario..."
                   autocomplete="off">
            <button type="button" id="btn-buscar-motos" class="btn btn-warning">
                Buscar
            </button>
        </div>
        <small style="color: #6c757d; margin-top: 5px;">
            Los resultados se filtran automáticamente mientras escribe.
        </small>
    </div>

    <div class="card">
        <table class="table" id="tabla-motos">
            <thead>
                <tr>
                    <th>Placa Única</th>
                    <th>Marca / Fabricante</th>
                    <th>Modelo / Línea</th>
                    <th>Color Exterior</th>
                    <th>Propietario Asociado</th>
                    <th>Último Mantenimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($motos as $moto)
                    <tr>
                        <td>
                            @if($moto->placa)
                                <span class="badge bg-dark">{{ $moto->placa }}</span>
                            @else
                                <span class="badge bg-secondary">Sin placa</span>
                            @endif
                        </td>
                        <td>{{ $moto->marca }}</td>
                        <td>{{ $moto->modelo }}</td>
                        <td>{{ $moto->color }}</td>
                        <td>
                            {{ $moto->nombre_cliente }}
                            <br><small style="color: #6c757d;">Teléfono: {{ $moto->telefono }}</small>
                        </td>
                        <td>{{ $moto->fecha_ultimo_mantenimiento }}</td>
                        <td>
                            <a href="{{ route('motos.show', $moto->id_moto) }}" class="btn btn-primary btn-sm">Ver</a>
                            <a href="{{ route('motos.edit', $moto->id_moto) }}" class="btn btn-success btn-sm">Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #6c757d;">
                            No hay motocicletas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buscador = document.getElementById('buscador-motos');
        const tabla = document.getElementById('tabla-motos').querySelector('tbody');
        const btnBuscar = document.getElementById('btn-buscar-motos');

        function buscar() {
            const termino = buscador.value.trim();

            fetch(`{{ route('motos.buscar') }}?q=${encodeURIComponent(termino)}`)
                .then(res => res.json())
                .then(data => {
                    tabla.innerHTML = '';

                    if (data.length === 0) {
                        tabla.innerHTML = '<tr><td colspan="7" style="text-align:center; color:#6c757d;">No se encontraron resultados.</td></tr>';
                        return;
                    }

                    data.forEach(moto => {
                        const placa = moto.placa
                            ? '<span class="badge bg-dark">' + moto.placa + '</span>'
                            : '<span class="badge bg-secondary">Sin placa</span>';

                        const fila = '<tr>' +
                            '<td>' + placa + '</td>' +
                            '<td>' + moto.marca + '</td>' +
                            '<td>' + moto.modelo + '</td>' +
                            '<td>' + (moto.color ?? '') + '</td>' +
                            '<td>' + moto.nombre_cliente + '<br><small style="color:#6c757d;">Teléfono: ' + moto.telefono + '</small></td>' +
                            '<td>' + (moto.fecha_ultimo_mantenimiento ?? '') + '</td>' +
                            '<td><a href="/motos/' + moto.id_moto + '" class="btn btn-primary btn-sm">Ver</a> ' +
                            '<a href="/motos/' + moto.id_moto + '/edit" class="btn btn-success btn-sm">Editar</a></td>' +
                            '</tr>';
                        tabla.innerHTML += fila;
                    });
                });
        }

        btnBuscar.addEventListener('click', buscar);
        buscador.addEventListener('keyup', function(e) { if (e.key === 'Enter') buscar(); }););
    });
</script>
@endsection