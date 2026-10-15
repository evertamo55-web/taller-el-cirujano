<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepuestoController extends Controller
{
    // Listar inventario de herramientas con su estado actual (Disponible, Prestado, etc.)
    public function index() {
        $herramientas = DB::table('herramientas')->get();
        return response()->json($herramientas, 200);
    }

    // El Operario registra una nueva herramienta (Activo Fijo) con código único
    public function store(Request $request) {
        $request->validate([
            'codigo_herramienta' => 'required|string|max:50|unique:herramientas,codigo_herramienta',
            'nombre_herramienta' => 'required|string|max:100',
            'estado' => 'required|in:disponible,prestado,mantenimiento,extraviado',
        ]);

        DB::table('herramientas')->insert([
            'codigo_herramienta' => $request->codigo_herramienta,
            'nombre_herramienta' => $request->nombre_herramienta,
            'estado' => $request->estado,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['mensaje' => 'Herramienta inventariada con éxito.'], 201);
    }

    public function show($id) {
        $herramienta = DB::table('herramientas')->where('id_herramienta', $id)->first();
        if (!$herramienta) {
            return response()->json(['error' => 'Herramienta no encontrada.'], 404);
        }
        return response()->json($herramienta, 200);
    }

    // Permitir al Operario cambiar el estado (ej. Mandar a mantenimiento una llave)
    public function update(Request $request, $id) {
        $request->validate([
            'codigo_herramienta' => 'sometimes|required|string|max:50|unique:herramientas,codigo_herramienta,' . $id . ',id_herramienta',
            'nombre_herramienta' => 'sometimes|required|string|max:100',
            'estado' => 'sometimes|required|in:disponible,prestado,mantenimiento,extraviado',
        ]);

        DB::table('herramientas')
            ->where('id_herramienta', $id)
            ->update($request->only(['codigo_herramienta', 'nombre_herramienta', 'estado']) + ['updated_at' => now()]);

        return response()->json(['mensaje' => 'Herramienta actualizada.'], 200);
    }

    public function destroy($id) {
        // Impedir el borrado si la herramienta está actualmente prestada a un técnico
        $prestada = DB::table('prestamos_herramientas')->where('id_herramienta', $id)->whereNull('fecha_devolucion')->exists();
        if ($prestada) {
            return response()->json(['error' => 'No se puede eliminar una herramienta en uso activo por un técnico.'], 400);
        }

        DB::table('herramientas')->where('id_herramienta', $id)->delete();
        return response()->json(null, 204);
    }
}