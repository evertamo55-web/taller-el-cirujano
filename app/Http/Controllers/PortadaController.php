<?php

namespace App\Http\Controllers;

use App\Models\ServicioPortada;
use App\Models\ConfiguracionTaller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortadaController extends Controller
{
    /**
     * Muestra la lista de servicios de la portada.
     */
    public function index()
    {
        $servicios = ServicioPortada::orderBy('orden')->get();
        $taller = ConfiguracionTaller::first() ?? new ConfiguracionTaller();
        return view('admin.portada.index', compact('servicios', 'taller'));
    }

    /**
     * Muestra el formulario para agregar un servicio a la portada.
     */
    public function create()
    {
        return view('admin.portada.create');
    }

    /**
     * Guarda un nuevo servicio en la portada.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_servicio' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'orden' => 'required|integer|min:0',
            'estado' => 'required|in:visible,oculto',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('servicios_portada', 'public');
        }

        ServicioPortada::create($validated);

        return redirect()->route('admin.portada.index')
            ->with('success', 'Servicio agregado a la portada correctamente.');
    }

    /**
     * Muestra el formulario para editar un servicio de la portada.
     */
    public function edit($id)
    {
        $servicio = ServicioPortada::findOrFail($id);
        return view('admin.portada.edit', compact('servicio'));
    }

    /**
     * Actualiza un servicio de la portada.
     */
    public function update(Request $request, $id)
    {
        $servicio = ServicioPortada::findOrFail($id);

        $validated = $request->validate([
            'nombre_servicio' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio' => 'nullable|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'orden' => 'required|integer|min:0',
            'estado' => 'required|in:visible,oculto',
        ]);

        if ($request->hasFile('imagen')) {
            if ($servicio->imagen) {
                Storage::disk('public')->delete($servicio->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('servicios_portada', 'public');
        }

        $servicio->update($validated);

        return redirect()->route('admin.portada.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Elimina (soft delete) un servicio de la portada.
     */
    public function destroy($id)
    {
        $servicio = ServicioPortada::findOrFail($id);

        if ($servicio->imagen) {
            Storage::disk('public')->delete($servicio->imagen);
        }

        $servicio->delete();

        return redirect()->route('admin.portada.index')
            ->with('success', 'Servicio eliminado de la portada correctamente.');
    }

    /**
     * Muestra el formulario de configuración del taller.
     */
    public function configTaller()
    {
        $taller = ConfiguracionTaller::first() ?? new ConfiguracionTaller();
        return view('admin.portada.config-taller', compact('taller'));
    }

    /**
     * Guarda la configuración del taller.
     */
    public function storeConfigTaller(Request $request)
    {
        $taller = ConfiguracionTaller::first() ?? new ConfiguracionTaller();

        $validated = $request->validate([
            'nombre_taller' => 'required|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'horario' => 'nullable|string|max:100',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'imagen_hero' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($taller->logo) {
                Storage::disk('public')->delete($taller->logo);
            }
            $validated['logo'] = $request->file('logo')->store('configuracion', 'public');
        }

        if ($request->hasFile('imagen_hero')) {
            if ($taller->imagen_hero) {
                Storage::disk('public')->delete($taller->imagen_hero);
            }
            $validated['imagen_hero'] = $request->file('imagen_hero')->store('configuracion', 'public');
        }

        $taller->fill($validated);
        $taller->save();

        return redirect()->route('admin.portada.index')
            ->with('success', 'Configuración del taller guardada correctamente.');
    }
}
