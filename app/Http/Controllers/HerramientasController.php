<?php

namespace App\Http\Controllers;

use App\Models\Herramienta;
use App\Models\Empleado;
use App\Models\Ordentrabajo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HerramientasController extends Controller
{
    /**
     * Lista de herramientas con su estado actual.
     */
    public function index()
    {
        $herramientas = Herramienta::orderBy('nombre_herramienta')->get();
        $tecnicos = Empleado::where('cargo', 'tecnico')->where('estado', 'activo')->get();
        $ordenes = Ordentrabajo::whereIn('estado_servicio', ['pendiente', 'en_progreso'])->get();

        $prestamos = DB::table('prestamos_herramientas')
            ->join('herramientas', 'prestamos_herramientas.id_herramienta', '=', 'herramientas.id_herramienta')
            ->join('empleados', 'prestamos_herramientas.id_empleado', '=', 'empleados.id_empleado')
            ->leftJoin('ordenes_servicio', 'prestamos_herramientas.id_orden_servicio', '=', 'ordenes_servicio.id_orden_servicio')
            ->whereNull('prestamos_herramientas.fecha_devolucion')
            ->select(
                'prestamos_herramientas.*',
                'herramientas.nombre_herramienta',
                'herramientas.codigo_herramienta',
                'empleados.nombre_empleado',
                'ordenes_servicio.id_orden_servicio'
            )
            ->orderBy('prestamos_herramientas.fecha_prestamo', 'desc')
            ->get();

        return view('admin.herramientas.index', compact('herramientas', 'tecnicos', 'ordenes', 'prestamos'));
    }

    /**
     * Registra un préstamo de herramienta a un técnico.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_herramienta' => 'required|exists:herramientas,id_herramienta',
            'id_empleado' => 'required|exists:empleados,id_empleado',
            'id_orden_servicio' => 'nullable|exists:ordenes_servicio,id_orden_servicio',
        ]);

        $herramienta = Herramienta::findOrFail($validated['id_herramienta']);

        if ($herramienta->estado !== 'disponible') {
            return back()->with('error', 'La herramienta no está disponible (estado: ' . $herramienta->estado . ').');
        }

        DB::transaction(function () use ($validated) {
            DB::table('prestamos_herramientas')->insert([
                'id_herramienta' => $validated['id_herramienta'],
                'id_empleado' => $validated['id_empleado'],
                'id_orden_servicio' => $validated['id_orden_servicio'] ?? null,
                'fecha_prestamo' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('herramientas')
                ->where('id_herramienta', $validated['id_herramienta'])
                ->update(['estado' => 'prestado']);
        });

        return redirect()->route('admin.herramientas.index')
            ->with('success', 'Herramienta prestada correctamente.');
    }

    /**
     * Formulario para agregar nueva herramienta.
     */
    public function create()
    {
        return view('admin.herramientas.create');
    }

    /**
     * Guarda una nueva herramienta.
     */
    public function storeHerramienta(Request $request)
    {
        $validated = $request->validate([
            'codigo_herramienta' => 'required|string|max:50|unique:herramientas,codigo_herramienta',
            'nombre_herramienta' => 'required|string|max:100',
            'estado' => 'required|in:disponible,prestado,mantenimiento,extraviado',
        ]);

        Herramienta::create($validated);

        return redirect()->route('admin.herramientas.index')
            ->with('success', 'Herramienta agregada correctamente.');
    }

    /**
     * Formulario para editar una herramienta.
     */
    public function edit($id)
    {
        $herramienta = Herramienta::findOrFail($id);
        return view('admin.herramientas.edit', compact('herramienta'));
    }

    /**
     * Actualiza una herramienta.
     */
    public function update(Request $request, $id)
    {
        $herramienta = Herramienta::findOrFail($id);

        $validated = $request->validate([
            'codigo_herramienta' => 'required|string|max:50|unique:herramientas,codigo_herramienta,' . $id . ',id_herramienta',
            'nombre_herramienta' => 'required|string|max:100',
            'estado' => 'required|in:disponible,prestado,mantenimiento,extraviado',
        ]);

        $herramienta->update($validated);

        return redirect()->route('admin.herramientas.index')
            ->with('success', 'Herramienta actualizada correctamente.');
    }

    /**
     * Elimina una herramienta (solo si no está prestada).
     */
    public function destroy($id)
    {
        $herramienta = Herramienta::findOrFail($id);

        if ($herramienta->estado === 'prestado') {
            return back()->with('error', 'No se puede eliminar una herramienta que está prestada.');
        }

        $herramienta->delete();

        return redirect()->route('admin.herramientas.index')
            ->with('success', 'Herramienta eliminada correctamente.');
    }

    /**
     * Registra la devolución de una herramienta.
     */
    public function devolver($id_prestamo)
    {
        $prestamo = DB::table('prestamos_herramientas')
            ->where('id_prestamo', $id_prestamo)
            ->first();

        if (!$prestamo) {
            return back()->with('error', 'Préstamo no encontrado.');
        }

        if ($prestamo->fecha_devolucion) {
            return back()->with('error', 'Esta herramienta ya fue devuelta.');
        }

        DB::transaction(function () use ($prestamo) {
            DB::table('prestamos_herramientas')
                ->where('id_prestamo', $prestamo->id_prestamo)
                ->update([
                    'fecha_devolucion' => now(),
                    'updated_at' => now(),
                ]);

            DB::table('herramientas')
                ->where('id_herramienta', $prestamo->id_herramienta)
                ->update(['estado' => 'disponible']);
        });

        return redirect()->route('admin.herramientas.index')
            ->with('success', 'Herramienta devuelta correctamente.');
    }
}
