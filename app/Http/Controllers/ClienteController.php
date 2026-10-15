<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Lista de clientes.
     * - Web: devuelve la vista clientes/index.blade.php
     * - AJAX/JSON: devuelve JSON con clientes y sus motos
     */
    public function index(Request $request)
    {
        $clientes = Cliente::with('motos')->orderBy('id_cliente', 'desc')->get();

        if ($request->wantsJson()) {
            return response()->json($clientes, 200);
        }

        return view('clientes.index', compact('clientes'));
    }

    /**
     * Búsqueda AJAX de clientes en tiempo real.
     */
    public function buscar(Request $request)
    {
        $termino = $request->input('q');

        $clientes = Cliente::where('nombre', 'LIKE', "%{$termino}%")
            ->orWhere('nit_ci', 'LIKE', "%{$termino}%")
            ->orWhere('telefono', 'LIKE', "%{$termino}%")
            ->orderByRaw("CASE
                WHEN nombre = ? THEN 0
                WHEN nombre LIKE ? THEN 1
                ELSE 2
            END, nombre", [$termino, "{$termino}%"])
            ->limit(10)
            ->get();

        return response()->json($clientes);
    }

    /**
     * Muestra el formulario para crear un cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guarda un nuevo cliente.
     * - Web: redirige al listado con mensaje de éxito
     * - AJAX/JSON: devuelve el cliente creado en JSON (201)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'   => 'required|string|max:100',
            'telefono' => 'required|string|max:20',
            'direccion'=> 'nullable|string|max:255',
            'nit_ci'   => 'required|string|max:20|unique:clientes,nit_ci',
        ]);

        $cliente = Cliente::create($validated);

        if ($request->wantsJson()) {
            return response()->json($cliente, 201);
        }

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    /**
     * Muestra un cliente específico.
     * - Web: devuelve la vista clientes/show.blade.php
     * - AJAX/JSON: devuelve JSON con el cliente y sus motos
     */
    public function show(Request $request, $id)
    {
        $cliente = Cliente::with('motos')->findOrFail($id);

        if ($request->wantsJson()) {
            return response()->json($cliente, 200);
        }

        return view('clientes.show', compact('cliente'));
    }

    /**
     * Muestra el formulario para editar un cliente.
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Actualiza un cliente existente.
     * - Web: redirige al listado con mensaje
     * - AJAX/JSON: devuelve el cliente actualizado
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $validated = $request->validate([
            'nombre'   => 'sometimes|required|string|max:100',
            'telefono' => 'sometimes|required|string|max:20',
            'direccion'=> 'nullable|string|max:255',
            'nit_ci'   => 'sometimes|required|string|max:20|unique:clientes,nit_ci,' . $id . ',id_cliente',
        ]);

        $cliente->update($validated);

        if ($request->wantsJson()) {
            return response()->json($cliente, 200);
        }

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente.
     * - Web: redirige al listado con mensaje
     * - AJAX/JSON: devuelve 204
     */
    public function destroy(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        if ($cliente->motos()->count() > 0) {
            $mensaje = 'No se puede eliminar un cliente con motocicletas registradas.';

            if ($request->wantsJson()) {
                return response()->json(['error' => $mensaje], 400);
            }

            return redirect()
                ->route('clientes.index')
                ->with('error', $mensaje);
        }

        $cliente->delete();

        if ($request->wantsJson()) {
            return response()->json(null, 204);
        }

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}