<?php

namespace App\Http\Controllers;

use App\Models\Ordentrabajo;
use App\Models\Servicio;
use App\Models\Moto;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class OrdentrabajoController extends Controller
{
    // ========================================================================
    // 1. LISTAR EL HISTORIAL DE ÓRDENES
    // ========================================================================
    public function index(Request $request)
    {
        $ordenes = Ordentrabajo::with(['moto.cliente', 'empleado'])
            ->orderBy('id_orden_servicio', 'desc')
            ->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($ordenes, 200);
        }

        return view('ordenes.index', compact('ordenes'));
    }

    // ========================================================================
    // 2. FORMULARIO DE APERTURA DE ÓRDENES
    // ========================================================================
    public function create()
    {
        $motos = Moto::with('cliente')->orderBy('placa')->get();
        $empleados = Empleado::where('cargo', 'tecnico')->where('estado', 'activo')->get();
        $servicios = Servicio::orderBy('nombre_servicio')->get();
        $herramientas = DB::table('herramientas')->where('estado', 'disponible')->get();

        return view('ordenes.create', compact('motos', 'empleados', 'servicios', 'herramientas'));
    }

    // ========================================================================
    // 3. APERTURA TRANSACCIONAL DE ORDEN DE TRABAJO (ACID)
    // ========================================================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_moto'                      => 'required|exists:motos,id_moto',
            'id_empleado'                  => 'required|exists:empleados,id_empleado',
            'descripcion_falla'            => 'required|string',
            'servicios'                    => 'nullable|array',
            'servicios.*.id_servicio'      => 'nullable|exists:servicios,id_servicio',
            'servicios.*.repuesto_cliente' => 'nullable|string',
            'herramientas'                 => 'nullable|array',
            'herramientas.*'               => 'exists:herramientas,id_herramienta',
        ]);

        try {
            $orden = DB::transaction(function () use ($validated) {

                // 3.1. Insertar la cabecera de la orden
                $orden = Ordentrabajo::create([
                    'id_moto'            => $validated['id_moto'],
                    'id_empleado'        => $validated['id_empleado'],
                    'fecha_recepcion'    => now()->toDateString(),
                    'descripcion_falla'  => $validated['descripcion_falla'],
                    'estado_servicio'    => 'pendiente',
                    'total_mano_obra'    => 0.00,
                    'ganancia_taller'    => 0.00,
                    'ganancia_tecnico'   => 0.00,
                ]);

                $totalManoObra = 0.00;

                // 3.2. Insertar los servicios (mano de obra)
                if (!empty($validated['servicios'])) {
                    foreach ($validated['servicios'] as $item) {
                        if (!isset($item['id_servicio'])) continue;

                        $servicio = Servicio::findOrFail($item['id_servicio']);
                        $subtotal = $servicio->precio_mano_obra;
                        $totalManoObra += $subtotal;

                        DB::table('detalle_servicios')->insert([
                            'id_orden_servicio'       => $orden->id_orden_servicio,
                            'id_servicio'             => $servicio->id_servicio,
                            'repuesto_traido_cliente' => $item['repuesto_cliente'] ?? 'Ninguno',
                            'subtotal'                => $subtotal,
                            'created_at'              => now(),
                            'updated_at'              => now(),
                        ]);
                    }
                }

                // 3.3. Registrar el préstamo de herramientas
                if (!empty($validated['herramientas'])) {
                    foreach ($validated['herramientas'] as $id_herramienta) {
                        DB::table('prestamos_herramientas')->insert([
                            'id_orden_servicio' => $orden->id_orden_servicio,
                            'id_herramienta'    => $id_herramienta,
                            'id_empleado'       => $validated['id_empleado'],
                            'fecha_prestamo'    => now(),
                            'created_at'        => now(),
                            'updated_at'        => now(),
                        ]);

                        DB::table('herramientas')
                            ->where('id_herramienta', $id_herramienta)
                            ->update(['estado' => 'prestado']);
                    }
                }

                // 3.4. Calcular el 50/50
                $orden->update([
                    'total_mano_obra'  => $totalManoObra,
                    'ganancia_taller'  => $totalManoObra * 0.50,
                    'ganancia_tecnico' => $totalManoObra * 0.50,
                ]);

                return $orden;
            });

            if (!$request->wantsJson() && !$request->is('api/*')) {
                return redirect()->route('ordenes.index')
                    ->with('success', 'Orden de trabajo #' . $orden->id_orden_servicio . ' aperturada con éxito transaccional.');
            }

            return response()->json(['status' => 'success', 'datos' => $orden], 201);

        } catch (\Exception $e) {
            if (!$request->wantsJson() && !$request->is('api/*')) {
                return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
            }
            return response()->json(['status' => 'error', 'mensaje' => $e->getMessage()], 422);
        }
    }

    // ========================================================================
    // 4. VER EL DETALLE / NOTA DE SERVICIO
    // ========================================================================
    public function show(Request $request, $id)
    {
        $orden = Ordentrabajo::with(['moto.cliente', 'empleado', 'detalles.servicio'])->find($id);

        if (!$orden) {
            abort(404, 'La orden no existe.');
        }

        $herramientas = DB::table('prestamos_herramientas')
            ->join('herramientas', 'prestamos_herramientas.id_herramienta', '=', 'herramientas.id_herramienta')
            ->where('prestamos_herramientas.id_orden_servicio', $id)
            ->select('herramientas.*', 'prestamos_herramientas.fecha_prestamo', 'prestamos_herramientas.fecha_devolucion')
            ->get();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['orden' => $orden, 'herramientas' => $herramientas], 200);
        }

        return view('ordenes.show', compact('orden', 'herramientas'));
    }

    // ========================================================================
    // 5. FORMULARIO DE EDICIÓN DE ORDEN
    // ========================================================================
    public function edit($id)
    {
        $orden = Ordentrabajo::with(['moto', 'empleado'])->findOrFail($id);
        $motos = Moto::with('cliente')->orderBy('placa')->get();
        $empleados = Empleado::where('cargo', 'tecnico')->where('estado', 'activo')->get();

        return view('ordenes.edit', compact('orden', 'motos', 'empleados'));
    }

    // ========================================================================
    // 6. ACTUALIZAR ORDEN
    // ========================================================================
    public function update(Request $request, $id)
    {
        $orden = Ordentrabajo::findOrFail($id);

        $validated = $request->validate([
            'id_moto'              => 'required|exists:motos,id_moto',
            'id_empleado'          => 'required|exists:empleados,id_empleado',
            'descripcion_falla'    => 'required|string',
            'diagnostico_tecnico'  => 'nullable|string',
            'estado_servicio'      => 'required|in:pendiente,en_progreso,completado,entregado',
        ]);

        $orden->update($validated);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($orden, 200);
        }

        return redirect()->route('ordenes.index')
            ->with('success', 'Orden #' . $orden->id_orden_servicio . ' actualizada correctamente.');
    }

    // ========================================================================
    // 7. ELIMINAR ORDEN
    // ========================================================================
    public function destroy(Request $request, $id)
    {
        $orden = Ordentrabajo::findOrFail($id);

        $prestamos = DB::table('prestamos_herramientas')
            ->where('id_orden_servicio', $id)
            ->get();

        foreach ($prestamos as $prestamo) {
            DB::table('herramientas')
                ->where('id_herramienta', $prestamo->id_herramienta)
                ->update(['estado' => 'disponible']);
        }

        $orden->delete();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(null, 204);
        }

        return redirect()->route('ordenes.index')
            ->with('success', 'Orden eliminada correctamente.');
    }

    // ========================================================================
    // 8. CAMBIAR EL ESTADO DE LA ORDEN
    // ========================================================================
    public function cambiarEstado(Request $request, $id)
    {
        $orden = Ordentrabajo::findOrFail($id);

        $validated = $request->validate([
            'estado_servicio' => 'required|in:pendiente,en_progreso,completado,entregado',
        ]);

        if ($validated['estado_servicio'] === 'entregado') {
            $tieneServicios = DB::table('detalle_servicios')
                ->where('id_orden_servicio', $id)
                ->count() > 0;

            if (!$tieneServicios) {
                return back()->with('error', 'No se puede entregar una orden sin servicios registrados.');
            }
        }

        $orden->update(['estado_servicio' => $validated['estado_servicio']]);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($orden, 200);
        }

        return redirect()->route('ordenes.show', $orden->id_orden_servicio)
            ->with('success', 'Estado actualizado a: ' . strtoupper($validated['estado_servicio']));
    }

    // ========================================================================
    // 9. REGISTRAR PAGO Y LIQUIDAR 50/50
    // ========================================================================
    public function registrarPago(Request $request, $id)
    {
        $orden = Ordentrabajo::findOrFail($id);

        $totalManoObra = DB::table('detalle_servicios')
            ->where('id_orden_servicio', $id)
            ->sum('subtotal');

        if ($totalManoObra == 0) {
            return back()->with('error', 'No se puede registrar el pago de una orden sin servicios.');
        }

        $orden->update([
            'estado_servicio'   => 'entregado',
            'total_mano_obra'   => $totalManoObra,
            'ganancia_taller'   => $totalManoObra * 0.50,
            'ganancia_tecnico'  => $totalManoObra * 0.50,
        ]);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'status' => 'success',
                'orden' => $orden,
                'total_mano_obra' => $totalManoObra,
                'ganancia_taller' => $totalManoObra * 0.50,
                'ganancia_tecnico' => $totalManoObra * 0.50,
            ], 200);
        }

        return redirect()->route('ordenes.show', $orden->id_orden_servicio)
            ->with('success', 'Pago registrado. Orden entregada y comisión 50/50 liquidada.');
    }

    // ========================================================================
    // 10. ENDPOINT INTERNO API/AJAX: Motos por cliente
    // ========================================================================
    public function getMotosPorCliente($id_cliente)
    {
        $motos = Moto::where('id_cliente', $id_cliente)
            ->select('id_moto', 'placa', 'marca', 'modelo')
            ->get();

        return response()->json($motos, 200);
    }

    // ========================================================================
    // 10.5 DEVOLVER HERRAMIENTA
    // ========================================================================
    public function devolverHerramienta(Request $request, $id_prestamo)
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
                    'updated_at'       => now(),
                ]);

            DB::table('herramientas')
                ->where('id_herramienta', $prestamo->id_herramienta)
                ->update(['estado' => 'disponible']);
        });

        return redirect()->route('ordenes.show', $prestamo->id_orden_servicio)
            ->with('success', 'Herramienta devuelta correctamente.');
    }

    // ========================================================================
    // 11. ENDPOINT API/AJAX: Trabajos y comisiones del técnico
    // ========================================================================
    public function trabajosTecnico($id_empleado)
    {
        $ordenes = DB::table('ordenes_servicio')
            ->join('motos', 'ordenes_servicio.id_moto', '=', 'motos.id_moto')
            ->select('ordenes_servicio.*', 'motos.placa', 'motos.marca', 'motos.modelo')
            ->where('ordenes_servicio.id_empleado', $id_empleado)
            ->get();

        return response()->json([
            'mecanico_id'            => $id_empleado,
            'ganancia_acumulada_50'  => $ordenes->sum('ganancia_tecnico'),
            'mis_ordenes'            => $ordenes,
        ], 200);
    }
}