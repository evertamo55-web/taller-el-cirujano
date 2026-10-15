<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleOrdenController extends Controller
{
    // Añadir dinámicamente un servicio a una orden abierta desde la Web del Operario
    public function store(Request $request) {
        $request->validate([
            'id_orden_servicio' => 'required|exists:ordenes_servicio,id_orden_servicio',
            'id_servicio' => 'required|exists:servicios,id_servicio',
            'repuesto_traido_cliente' => 'nullable|string|max:150',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // Obtener el precio fijo de la mano de obra del catálogo
                $servicio = DB::table('servicios')->where('id_servicio', $request->id_servicio)->first();
                $subtotal = $servicio->precio_mano_obra;

                // 1. Insertar físicamente la línea de detalle
                DB::table('detalle_servicios')->insert([
                    'id_orden_servicio' => $request->id_orden_servicio,
                    'id_servicio' => $request->id_servicio,
                    'repuesto_traido_cliente' => $request->repuesto_traido_cliente ?? 'Ninguno',
                    'subtotal' => $subtotal,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                // 2. RECALCULAR FINANZAS AUTOMÁTICAMENTE (50% / 50%) en la cabecera
                $orden = DB::table('ordenes_servicio')->where('id_orden_servicio', $request->id_orden_servicio)->first();
                $nuevoTotal = $orden->total_mano_obra + $subtotal;

                DB::table('ordenes_servicio')
                    ->where('id_orden_servicio', $request->id_orden_servicio)
                    ->update([
                        'total_mano_obra' => $nuevoTotal,
                        'ganancia_taller' => $nuevoTotal * 0.50,
                        'ganancia_tecnico' => $nuevoTotal * 0.50,
                        'updated_at' => now()
                    ]);

                return response()->json(['mensaje' => 'Línea de servicio agregada y ganancias recalculadas.'], 201);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Fallo transaccional: ' . $e->getMessage()], 422);
        }
    }

    // Quitar un servicio cargado por error en la orden de trabajo
    public function destroy($id) {
        try {
            return DB::transaction(function () use ($id) {
                $detalle = DB::table('detalle_servicios')->where('id_detalle', $id)->first();
                if (!$detalle) {
                    return response()->json(['error' => 'Detalle no encontrado.'], 404);
                }

                // Restar los montos de la orden principal antes de eliminar la línea física
                $orden = DB::table('ordenes_servicio')->where('id_orden_servicio', $detalle->id_orden_servicio)->first();
                $nuevoTotal = max(0, $orden->total_mano_obra - $detalle->subtotal);

                DB::table('ordenes_servicio')
                    ->where('id_orden_servicio', $detalle->id_orden_servicio)
                    ->update([
                        'total_mano_obra' => $nuevoTotal,
                        'ganancia_taller' => $nuevoTotal * 0.50,
                        'ganancia_tecnico' => $nuevoTotal * 0.50,
                        'updated_at' => now()
                    ]);

                DB::table('detalle_servicios')->where('id_detalle', $id)->delete();
                return response()->json(null, 204);
            });
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al revertir montos: ' . $e->getMessage()], 422);
        }
    }
}