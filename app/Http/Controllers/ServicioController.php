<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::orderBy('nombre_servicio')->get();
        return view('admin.servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('admin.servicios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_servicio' => 'required|string|max:150',
            'precio_mano_obra' => 'required|numeric|min:0',
        ]);

        Servicio::create($validated);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio registrado correctamente.');
    }

    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('admin.servicios.edit', compact('servicio'));
    }

    public function update(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

        $validated = $request->validate([
            'nombre_servicio' => 'required|string|max:150',
            'precio_mano_obra' => 'required|numeric|min:0',
        ]);

        $servicio->update($validated);

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);

        // Verificar si tiene órdenes asociadas
        $tieneOrdenes = \DB::table('detalle_servicios')
            ->where('id_servicio', $id)
            ->count() > 0;

        if ($tieneOrdenes) {
            return redirect()->route('admin.servicios.index')
                ->with('error', 'No se puede eliminar un servicio con órdenes registradas.');
        }

        $servicio->delete();

        return redirect()->route('admin.servicios.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}