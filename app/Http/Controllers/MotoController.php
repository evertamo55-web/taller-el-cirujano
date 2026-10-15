<?php

namespace App\Http\Controllers;

use App\Models\Moto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MotoController extends Controller
{
    public function index(Request $request)
    {
        $motos = DB::table('motos')
            ->join('clientes', 'motos.id_cliente', '=', 'clientes.id_cliente')
            ->select(
                'motos.id_moto',
                'motos.placa',
                'motos.marca',
                'motos.modelo',
                'motos.color',
                'motos.fecha_ultimo_mantenimiento',
                'motos.id_cliente',
                'clientes.nombre as nombre_cliente',
                'clientes.telefono'
            )
            ->orderBy('motos.id_moto', 'desc')
            ->get();

        if ($request->wantsJson()) {
            return response()->json($motos, 200);
        }

        return view('motos.index', compact('motos'));
    }

    public function buscar(Request $request)
    {
        $termino = $request->input('q');

        $motos = DB::table('motos')
            ->join('clientes', 'motos.id_cliente', '=', 'clientes.id_cliente')
            ->select(
                'motos.id_moto',
                'motos.placa',
                'motos.marca',
                'motos.modelo',
                'motos.color',
                'motos.fecha_ultimo_mantenimiento',
                'motos.id_cliente',
                'clientes.nombre as nombre_cliente',
                'clientes.telefono'
            )
            ->where(function ($query) use ($termino) {
                $query->where('motos.placa', 'LIKE', "%{$termino}%")
                      ->orWhere('motos.marca', 'LIKE', "%{$termino}%")
                      ->orWhere('motos.modelo', 'LIKE', "%{$termino}%")
                      ->orWhere('clientes.nombre', 'LIKE', "%{$termino}%");
            })
            ->orderByRaw("CASE
                WHEN clientes.nombre = ? THEN 0
                WHEN clientes.nombre LIKE ? THEN 1
                WHEN motos.placa = ? THEN 0
                WHEN motos.placa LIKE ? THEN 1
                ELSE 2
            END, motos.id_moto DESC", [$termino, "{$termino}%", $termino, "{$termino}%"])
            ->limit(10)
            ->get();

        return response()->json($motos);
    }

    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('motos.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        // Convertir cualquier variante de "sin placa" a NULL
        $this->normalizarPlaca($request);

        $validated = $request->validate([
            'placa'                       => 'nullable|string|max:15|unique:motos,placa',
            'id_cliente'                  => 'required|exists:clientes,id_cliente',
            'marca'                       => 'required|string|max:50',
            'modelo'                      => 'required|string|max:50',
            'color'                       => 'nullable|string|max:30',
            'fecha_ultimo_mantenimiento'  => 'nullable|date',
        ]);

        $moto = Moto::create($validated);

        if ($request->wantsJson()) {
            return response()->json($moto, 201);
        }

        return redirect()->route('motos.index')
            ->with('success', 'Motocicleta registrada correctamente.');
    }

    public function show(Request $request, $id)
    {
        $moto = Moto::with('cliente')->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json($moto, 200);
        }

        return view('motos.show', compact('moto'));
    }

    public function edit($id)
    {
        $moto = Moto::findOrFail($id);
        $clientes = Cliente::orderBy('nombre')->get();
        return view('motos.edit', compact('moto', 'clientes'));
    }

    public function update(Request $request, $id)
    {
        $moto = Moto::findOrFail($id);

        // Convertir cualquier variante de "sin placa" a NULL
        $this->normalizarPlaca($request);

        $validated = $request->validate([
            'placa'                       => 'nullable|string|max:15|unique:motos,placa,' . $id . ',id_moto',
            'id_cliente'                  => 'required|exists:clientes,id_cliente',
            'marca'                       => 'required|string|max:50',
            'modelo'                      => 'required|string|max:50',
            'color'                       => 'nullable|string|max:30',
            'fecha_ultimo_mantenimiento'  => 'nullable|date',
        ]);

        $moto->update($validated);

        if ($request->wantsJson()) {
            return response()->json($moto, 200);
        }

        return redirect()->route('motos.index')
            ->with('success', 'Motocicleta actualizada correctamente.');
    }

    public function destroy(Request $request, $id)
    {
        $moto = Moto::findOrFail($id);

        $tieneOrdenes = DB::table('ordenes_servicio')
            ->where('id_moto', $id)
            ->count() > 0;

        if ($tieneOrdenes) {
            $mensaje = 'No se puede eliminar una motocicleta con órdenes de servicio registradas.';

            if ($request->wantsJson()) {
                return response()->json(['error' => $mensaje], 400);
            }

            return redirect()->route('motos.index')->with('error', $mensaje);
        }

        $moto->delete();

        if ($request->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()->route('motos.index')
            ->with('success', 'Motocicleta eliminada correctamente.');
    }

    /**
     * Convierte cualquier variante de "sin placa" a NULL
     * para evitar conflictos con la restricción UNIQUE.
     */
    private function normalizarPlaca(Request $request)
    {
        if (!$request->filled('placa')) {
            $request->merge(['placa' => null]);
            return;
        }

            $placa = strtolower(trim($request->placa));

    // Si la placa contiene alguna de estas frases, se considera sin placa
    $frases = [
        'no tiene',
        'sin placa',
        'sin placas',
        's/p',
        's/p.',
        's/n',
        'ninguna',
        'ninguno',
];

    foreach ($frases as $frase) {
        if (str_contains($placa, $frase)) {
            $request->merge(['placa' => null]);
            return;
        }
    }

    // Si es solo un guion o vacío
    if ($placa === '-' || $placa === '') {
        $request->merge(['placa' => null]);
    }
 }

}