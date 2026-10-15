<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    public function index()
    {
        $empleados = Empleado::orderBy('id_empleado', 'desc')->get();
        return view('empleados.index', compact('empleados'));
    }

    public function create()
    {
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_empleado' => 'required|string|max:100',
            'cargo' => 'required|in:propietario,operario,tecnico',
            'telefono_empleado' => 'nullable|string|max:20',
            'email_empleado' => 'required|email|unique:empleados,email_empleado', // <-- VALIDACIÓN
            'estado' => 'required|in:activo,inactivo',
        ]);

        Empleado::create($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado registrado correctamente.');
    }

    public function edit($id)
    {
        $empleado = Empleado::findOrFail($id);
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $empleado = Empleado::findOrFail($id);

        $validated = $request->validate([
            'nombre_empleado' => 'required|string|max:100',
            'cargo' => 'required|in:propietario,operario,tecnico',
            'telefono_empleado' => 'nullable|string|max:20',
            'email_empleado' => 'required|email|unique:empleados,email_empleado,' . $id . ',id_empleado', // <-- VALIDACIÓN
            'estado' => 'required|in:activo,inactivo',
        ]);

        $empleado->update($validated);

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado actualizado correctamente.');
    }

    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);
        $empleado->delete();

        return redirect()->route('empleados.index')
            ->with('success', 'Empleado eliminado correctamente.');
    }

    // ========================================================================
    // GESTIÓN DE TÉCNICOS PARA EL ADMINISTRADOR
    // ========================================================================

    /**
     * Lista de técnicos para el panel de administrador.
     */
    public function indexTecnicos()
    {
        $tecnicos = Empleado::where('cargo', 'tecnico')
            ->orderBy('estado', 'desc')
            ->orderBy('nombre_empleado')
            ->get();

        return view('admin.personal', compact('tecnicos'));
    }

    /**
     * Formulario para registrar un nuevo técnico.
     */
    public function createTecnico()
    {
        return view('admin.personal-create');
    }

    /**
     * Guarda un nuevo técnico en el sistema.
     */
    public function storeTecnico(Request $request)
    {
        $validated = $request->validate([
            'nombre_empleado' => 'required|string|max:100',
            'email_empleado' => 'required|email|unique:empleados,email_empleado',
            'telefono_empleado' => 'nullable|string|max:20',
        ]);

        $validated['cargo'] = 'tecnico';
        $validated['estado'] = 'activo';

        Empleado::create($validated);

        return redirect()->route('admin.personal')
            ->with('success', 'Técnico registrado correctamente.');
    }

    /**
     * Soft delete: cambia el técnico a inactivo.
     */
    public function destroyTecnico($id)
    {
        $tecnico = Empleado::findOrFail($id);

        $tecnico->update(['estado' => 'inactivo']);

        return redirect()->route('admin.personal')
            ->with('success', 'Técnico eliminado (inactivado) correctamente.');
    }

    /**
     * Reactiva un técnico que estaba inactivo.
     */
    public function restoreTecnico($id)
    {
        $tecnico = Empleado::findOrFail($id);

        $tecnico->update(['estado' => 'activo']);

        return redirect()->route('admin.personal')
            ->with('success', 'Técnico reactivado correctamente.');
    }

    /**
     * Formulario para editar un técnico.
     */
    public function editTecnico($id)
    {
        $tecnico = Empleado::findOrFail($id);
        return view('admin.personal-edit', compact('tecnico'));
    }

    /**
     * Actualiza los datos de un técnico.
     */
    public function updateTecnico(Request $request, $id)
    {
        $tecnico = Empleado::findOrFail($id);

        $validated = $request->validate([
            'nombre_empleado' => 'required|string|max:100',
            'email_empleado' => 'required|email|unique:empleados,email_empleado,' . $id . ',id_empleado',
            'telefono_empleado' => 'nullable|string|max:20',
        ]);

        $tecnico->update($validated);

        return redirect()->route('admin.personal')
            ->with('success', 'Técnico actualizado correctamente.');
    }
}