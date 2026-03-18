<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\MaquinaModelo;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaquinaController extends Controller
{
    /**
     * Arreglo maestro de estados para mantener consistencia.
     */
    private function getEstados()
    {
        return [
            'disponible' => '📦 Disponible',
            'en_bodega' => '🏭 En Bodega',
            'en_transito' => '🚢 En Tránsito',
            'en_puerto' => '⚓ En Puerto',
            'reparacion' => '🔧 En Reparación',
            'fabricacion' => '🏗️ En Fabricación',
            'pendiente_despacho' => '⏳ Vendida (Pendiente Despacho)',
            'cancelado' => '❌ Cancelado',
            'vendida' => '💰 Vendida'
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Maquina::with(['modelo.categoria']);

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('categoria_id')) {
            $query->whereHas('modelo', function($q) use ($request) {
                $q->where('categoria_id', $request->categoria_id);
            });
        }

        if ($request->filled('busqueda')) {
            $query->where(function($q) use ($request) {
                $q->where('numero_serie', 'like', '%' . $request->busqueda . '%')
                  ->orWhereHas('modelo', function($sq) use ($request) {
                      $sq->where('modelo', 'like', '%' . $request->busqueda . '%')
                         ->orWhere('marca', 'like', '%' . $request->busqueda . '%');
                  });
            });
        }

        $maquinas = $query->orderBy('created_at', 'desc')->paginate(15);
        $categorias = Categoria::where('activo', true)->get();
        $estados = $this->getEstados();

        return view('importaciones.maquinas.lista', compact('maquinas', 'categorias', 'estados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modelos = MaquinaModelo::with('categoria')->where('activo', true)->get();
        $estados = $this->getEstados();
        
        return view('importaciones.maquinas.createmaquinas', compact('modelos', 'estados'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'modelo_id' => 'required|exists:maquinas_modelos,id',
            'numero_serie' => 'nullable|unique:maquinas,numero_serie',
            'año_fabricacion' => 'nullable|integer|min:1900|max:' . date('Y'),
            'estado' => 'required|in:' . implode(',', array_keys($this->getEstados())),
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta' => 'nullable|numeric|min:0',
            'fecha_ingreso' => 'nullable|date',
            'observaciones' => 'nullable|string'
        ]);

        $maquina = Maquina::create($request->only([
            'modelo_id', 'numero_serie', 'año_fabricacion', 'estado', 
            'precio_compra', 'precio_venta', 'fecha_ingreso', 'observaciones'
        ]));

        // Registrar el seguimiento de estado inicial
        $maquina->seguimientosEstado()->create([
            'estado_nuevo' => $request->estado,
            'fecha_cambio' => now(),
            'usuario_cambio' => Auth::id(),
            'observaciones' => 'Registro inicial de máquina'
        ]);

        return redirect()->route('maquinaria-disponible.test')
            ->with('success', 'Máquina registrada correctamente en el inventario');
    }

    /**
     * Display the specified resource.
     */
    public function show(Maquina $maquina)
    {
        $maquina->load(['modelo.categoria', 'seguimientosEstado.usuario']);
        return view('importaciones.maquinas.show', compact('maquina'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maquina $maquina)
    {
        $modelos = MaquinaModelo::with('categoria')->where('activo', true)->get();
        $estados = $this->getEstados();
        
        return view('importaciones.maquinas.edit', compact('maquina', 'modelos', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Maquina $maquina)
    {
        $request->validate([
            'modelo_id' => 'required|exists:maquinas_modelos,id',
            'numero_serie' => 'nullable|unique:maquinas,numero_serie,' . $maquina->id,
            'año_fabricacion' => 'nullable|integer|min:1900|max:' . date('Y'),
            'estado' => 'required|in:' . implode(',', array_keys($this->getEstados())),
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta' => 'nullable|numeric|min:0',
            'fecha_ingreso' => 'nullable|date',
            'observaciones' => 'nullable|string'
        ]);

        $oldEstado = $maquina->estado;
        $maquina->update($request->all());

        if ($oldEstado != $request->estado) {
            $maquina->seguimientosEstado()->create([
                'estado_anterior' => $oldEstado,
                'estado_nuevo' => $request->estado,
                'fecha_cambio' => now(),
                'usuario_cambio' => Auth::id(),
                'observaciones' => 'Actualización manual de estado'
            ]);
        }

        return redirect()->route('maquinaria-disponible.test')
            ->with('success', 'Máquina actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maquina $maquina)
    {
        $maquina->delete();
        return response()->json([
            'success' => true,
            'message' => 'Máquina eliminada correctamente'
        ]);
    }

    /**
     * Cambiar estado de una máquina (acción rápida)
     */
    public function cambiarEstado(Request $request, Maquina $maquina)
    {
        $request->validate([
            'estado' => 'required|in:' . implode(',', array_keys($this->getEstados())),
            'observaciones' => 'nullable|string'
        ]);

        $oldEstado = $maquina->estado;
        $maquina->estado = $request->estado;
        $maquina->save();

        $maquina->seguimientosEstado()->create([
            'estado_anterior' => $oldEstado,
            'estado_nuevo' => $request->estado,
            'fecha_cambio' => now(),
            'usuario_cambio' => Auth::id(),
            'observaciones' => $request->observaciones
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    }
}