<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Http\Request;

class MaquinariaDisponibleController extends Controller
{
    /**
     * Obtener estadísticas de maquinaria
     */
    public function estadisticas()
    {
        try {
            $estadisticas = [
                // Disponibles: estados que contienen "Disponible"
                'disponibles' => Maquina::where('estado', 'like', '%Disponible%')
                                        ->where('activo', true)
                                        ->count(),
                
                // En Camino: estados que contienen "Camino", "Bodega" o "Tránsito"
                'en_camino' => Maquina::where(function($q) {
                                    $q->where('estado', 'like', '%Camino%')
                                      ->orWhere('estado', 'like', '%Bodega%')
                                      ->orWhere('estado', 'like', '%Tránsito%');
                                })
                                ->where('activo', true)
                                ->count(),
                
                // Reservadas: estados que contienen "Reservada" o "Pendiente"
                'reservadas' => Maquina::where(function($q) {
                                    $q->where('estado', 'like', '%Reservada%')
                                      ->orWhere('estado', 'like', '%Pendiente%');
                                })
                                ->where('activo', true)
                                ->count(),
                
                // Vendidas: estados que contienen "Vendida"
                'vendidas' => Maquina::where('estado', 'like', '%Vendida%')
                                      ->where('activo', true)
                                      ->count(),
            ];
            
            return response()->json($estadisticas);
            
        } catch (\Exception $e) {
            \Log::error('Error en estadisticas maquinaria: ' . $e->getMessage());
            return response()->json([
                'disponibles' => 0,
                'en_camino' => 0,
                'reservadas' => 0,
                'vendidas' => 0
            ]);
        }
    }

    /**
     * Obtener lista de máquinas disponibles
     */
    public function index(Request $request)
    {
        try {
            $query = Maquina::with(['modelo', 'ordenCompra'])
                ->where('activo', true);
            
            // Aplicar filtros
            if ($request->filled('buscar')) {
                $query->where(function($q) use ($request) {
                    $q->where('numero_serie', 'like', '%' . $request->buscar . '%')
                      ->orWhereHas('modelo', function($q2) use ($request) {
                          $q2->where('marca', 'like', '%' . $request->buscar . '%')
                             ->orWhere('modelo', 'like', '%' . $request->buscar . '%');
                      });
                });
            }
            
            if ($request->filled('marca')) {
                $query->whereHas('modelo', function($q) use ($request) {
                    $q->where('marca', $request->marca);
                });
            }
            
            if ($request->filled('precio_min')) {
                $query->where('precio_venta', '>=', $request->precio_min);
            }
            
            if ($request->filled('precio_max')) {
                $query->where('precio_venta', '<=', $request->precio_max);
            }
            
            $maquinas = $query->orderBy('created_at', 'desc')->paginate(10);
            
            if ($request->ajax() && !$request->has('marcas')) {
                $html = view('importaciones.maquinaria-lista', compact('maquinas'))->render();
                return response()->json([
                    'success' => true,
                    'html' => $html
                ]);
            }
            
            if ($request->has('marcas')) {
                $marcas = \App\Models\MaquinaModelo::where('activo', true)
                    ->distinct()
                    ->pluck('marca')
                    ->filter()
                    ->values();
                
                return response()->json([
                    'success' => true,
                    'marcas' => $marcas
                ]);
            }
            
            return view('importaciones.maquinaria-lista', compact('maquinas'));
            
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al cargar máquinas');
        }
    }

    /**
     * Cambiar estado de una máquina
     */
    public function cambiarEstado($id, Request $request)
    {
        try {
            $maquina = Maquina::findOrFail($id);
            $maquina->estado = $request->estado;
            
            if ($request->estado == 'vendida') {
                $maquina->fecha_venta = now();
            }
            
            $maquina->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Estado actualizado correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reservar máquina
     */
    public function reservar($id)
    {
        try {
            $maquina = Maquina::findOrFail($id);
            
            if ($maquina->estado != 'disponible') {
                return response()->json([
                    'success' => false,
                    'message' => 'La máquina no está disponible para reserva'
                ], 400);
            }
            
            $maquina->estado = 'pendiente_despacho';
            $maquina->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Máquina reservada correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vender máquina
     */
    public function vender($id)
    {
        try {
            $maquina = Maquina::findOrFail($id);
            
            if ($maquina->estado == 'vendida') {
                return response()->json([
                    'success' => false,
                    'message' => 'La máquina ya está vendida'
                ], 400);
            }
            
            $maquina->estado = 'vendida';
            $maquina->fecha_venta = now();
            $maquina->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Máquina marcada como vendida'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}