@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 style="margin: 0; color: #343a40; font-size: 1.8rem;">Gestión de Clientes</h1>
            <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 0.9rem;">
                Registro integral de propietarios de motocicletas en Trinidad.
            </p>
        </div>
        <a href="{{ route('clientes.create') }}" class="btn btn-warning" style="width: auto; padding: 10px 20px;">
            + Nuevo Cliente
        </a>
    </div>

    {{-- BUSCADOR EN TIEMPO REAL --}}
    <div class="card mb-3" style="padding: 15px;">
        <label for="buscador-clientes" style="font-weight: 700; margin-bottom: 8px;">Buscar Cliente</label>
        <div class="input-group">
            <span class="input-group-text">&#128269;</span>
            <input type="text" id="buscador-clientes" class="form-control"
                   placeholder="Escriba nombre, NIT/CI o teléfono..."
                   autocomplete="off">
            <button type="button" id="btn-buscar-clientes" class="btn btn-primary">
                Buscar
            </button>
        </div>
        <small style="color: #6c757d; margin-top: 5px;">
            Los resultados se filtran automáticamente mientras escribe.
        </small>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table" id="tabla-clientes">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>NIT / CI</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Motos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clientes as $cliente)
                        <tr>
                            <td><strong>{{ $cliente->id_cliente }}</strong></td>
                            <td>{{ $cliente->nombre }}</td>
                            <td><span class="badge" style="background-color: #6c757d;">{{ $cliente->nit_ci }}</span></td>
                            <td>{{ $cliente->telefono }}</td>
                            <td>{{ $cliente->direccion ?? '—' }}</td>
                            <td>
                                <span class="badge" style="background-color: #0d6efd;">
                                    {{ $cliente->motos->count() }}
                                </span>
                            </td>
                            <td style="display: flex; gap: 6px;">
                                <a href="{{ route('clientes.show', $cliente->id_cliente) }}"
                                   class="btn btn-primary"
                                   style="width: auto; padding: 6px 12px; font-size: 0.8rem;">
                                    Ver
                                </a>
                                <a href="{{ route('clientes.edit', $cliente->id_cliente) }}"
                                   class="btn btn-success"
                                   style="width: auto; padding: 6px 12px; font-size: 0.8rem;">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: #6c757d;">
                                No hay clientes registrados todavía.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buscador = document.getElementById('buscador-clientes');
        const tabla = document.getElementById('tabla-clientes').querySelector('tbody');

        function buscar() {
            const termino = buscador.value.trim();

            fetch(`{{ route('clientes.buscar') }}?q=${encodeURIComponent(termino)}`)
                .then(res => res.json())
                .then(data => {
                    tabla.innerHTML = '';

                    if (data.length === 0) {
                        tabla.innerHTML = <tr><td colspan="7" style="text-align:center; color:#6c757d;">No se encontraron resultados.</td></tr>;
                        return;
                    }

                    data.forEach(cliente => {
                        const fila = `
                            <tr>
                                <td><strong>${cliente.id_cliente}</strong></td>
                                <td>${cliente.nombre}</td>
                                <td><span class="badge" style="background-color: #6c757d;">${cliente.nit_ci}</span></td>
                                <td>${cliente.telefono}</td>
                                <td>${cliente.direccion ?? '—'}</td>
                                <td><span class="badge" style="background-color: #0d6efd;">0</span></td>
                                <td style="display: flex; gap: 6px;">
                                    <a href="/clientes/${cliente.id_cliente}" class="btn btn-primary" style="width: auto; padding: 6px 12px; font-size: 0.8rem;">Ver</a>
                                    <a href="/clientes/${cliente.id_cliente}/edit" class="btn btn-success" style="width: auto; padding: 6px 12px; font-size: 0.8rem;">Editar</a>
                                </td>
                            </tr>
                        `;
                        tabla.innerHTML += fila;
                    });
                });
        });
    });
</script>
@endsection