<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Categoria;
use App\Models\MaquinaModelo;
use Illuminate\Http\Request;

class MaquinariaDisponibleController extends Controller
{
    /**
     * Mostrar maquinaria (TODOS los estados)
     */
    public function index(Request $request)
    {
        try {
            // 👇 ELIMINADO: Ya no filtramos por estados específicos
            // Mostramos todas las máquinas de la base de datos
            $query = Maquina::with(['modelo.categoria']);

            // Filtros de búsqueda
            if ($request->filled('buscar')) {
                $query->where(function($q) use ($request) {
                    $q->where('numero_serie', 'like', '%' . $request->buscar . '%')
                      ->orWhereHas('modelo', function($sq) use ($request) {
                          $sq->where('modelo', 'like', '%' . $request->buscar . '%')
                             ->orWhere('marca', 'like', '%' . $request->buscar . '%');
                      });
                });
            }

            if ($request->filled('categoria_id')) {
                $query->whereHas('modelo', function($q) use ($request) {
                    $q->where('categoria_id', $request->categoria_id);
                });
            }

            if ($request->filled('marca')) {
                $query->whereHas('modelo', function($q) use ($request) {
                    $q->where('marca', $request->marca);
                });
            }

            // Filtro de precios
            if ($request->filled('precio_min') && $request->filled('precio_max')) {
                $query->whereBetween('precio_venta', [$request->precio_min, $request->precio_max]);
            } elseif ($request->filled('precio_min')) {
                $query->where('precio_venta', '>=', $request->precio_min);
            } elseif ($request->filled('precio_max')) {
                $query->where('precio_venta', '<=', $request->precio_max);
            }

            $maquinas = $query->latest()->get();

            // Datos para selectores de filtros
            $categorias = Categoria::where('activo', true)->get();
            $marcas = MaquinaModelo::distinct()->pluck('marca')->filter();

            // ✅ ESTADÍSTICAS ACTUALIZADAS: Sincronizadas con los nuevos estados
            $stats = [
                'disponibles'        => Maquina::whereIn('estado', ['disponible', 'en_bodega'])->count(),
                'en_camino'         => Maquina::whereIn('estado', ['en_transito', 'en_puerto'])->count(),
                'reparacion'        => Maquina::where('estado', 'reparacion')->count(),
                'fabricacion'       => Maquina::where('estado', 'fabricacion')->count(),
                'pendiente_despacho'=> Maquina::where('estado', 'pendiente_despacho')->count(),
                'cancelado'         => Maquina::where('estado', 'cancelado')->count(),
                'vendidas'          => Maquina::where('estado', 'vendida')->count(),
            ];

            // Respuesta AJAX
            if ($request->ajax()) {
                if ($request->has('marcas')) {
                    return response()->json([
                        'marcas' => $marcas->values()->toArray()
                    ]);
                }
                
                $html = view('importaciones.maquinas.partials.maquinaria-tabla', compact('maquinas'))->render();
                $statsHtml = view('importaciones.maquinas.partials.maquinaria-stats', compact('stats'))->render();
                
                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'stats' => $statsHtml
                ]);
            }

            return view('importaciones.maquinas.maquinariadisponible', compact('maquinas', 'categorias', 'marcas', 'stats'));
            
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al cargar maquinaria: ' . $e->getMessage());
        }
    }

    /**
     * Cambiar estado (Actualizado con validación de nuevos estados)
     */
    public function cambiarEstado(Request $request, $id)
    {
        try {
            $request->validate([
                'estado' => 'required|in:disponible,en_bodega,en_transito,en_puerto,reparacion,fabricacion,pendiente_despacho,cancelado,vendida'
            ]);

            $maquina = Maquina::findOrFail($id);
            $oldEstado = $maquina->estado;
            
            $maquina->update(['estado' => $request->estado]);

            if (method_exists($maquina, 'seguimientosEstado')) {
                $maquina->seguimientosEstado()->create([
                    'estado_anterior' => $oldEstado,
                    'estado_nuevo'    => $request->estado,
                    'fecha_cambio'    => now(),
                    'observaciones'   => 'Cambio manual desde panel administrativo'
                ]);
            }

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

    // Los métodos show, reservar y vender se mantienen similares, 
    // pero asegúrate de que 'vender' use el estado 'vendida'.
}