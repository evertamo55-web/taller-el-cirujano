@extends('layouts.app')

@section('content')
<div class="container">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <div>
            <h1 style="margin: 0; color: #343a40; font-size: 1.8rem;">Configuración de Servicios (Mano de Obra)</h1>
            <p style="margin: 5px 0 0 0; color: #6c757d; font-size: 0.9rem;">
                Administre los precios de los servicios que se cobran en el taller.
            </p>
        </div>
        <a href="{{ route('admin.servicios.create') }}" class="btn btn-warning" style="width: auto; padding: 10px 20px;">
            + Nuevo Servicio
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre del Servicio</th>
                        <th>Precio Mano de Obra</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servicios as $servicio)
                        <tr>
                            <td>{{ $servicio->id_servicio }}</td>
                            <td>{{ $servicio->nombre_servicio }}</td>
                            <td><strong>Bs. {{ number_format($servicio->precio_mano_obra, 2) }}</strong></td>
                            <td style="display: flex; gap: 6px;">
                                <a href="{{ route('admin.servicios.edit', $servicio->id_servicio) }}"
                                   class="btn btn-success"
                                   style="width: auto; padding: 6px 12px; font-size: 0.8rem;">
                                    Editar
                                </a>
                                <form method="POST"
                                      action="{{ route('admin.servicios.destroy', $servicio->id_servicio) }}"
                                      style="display: inline;"
                                      onsubmit="return confirm('¿Eliminar este servicio?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-danger"
                                            style="width: auto; padding: 6px 12px; font-size: 0.8rem;">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 30px; color: #6c757d;">
                                No hay servicios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection