<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Http\Request;

class MaquinariaDisponibleController extends Controller
{
    /**
     * Vista de prueba para maquinaria disponible
     */
    public function test()
    {
        return view('maquinaria-disponible-test');
    }

    /**
     * Obtener estadísticas de maquinaria
     */
    public function estadisticas()
    {
        try {
            $estadisticas = [
                'disponibles' => Maquina::where('estado', 'disponible')
                                        ->where('activo', true)
                                        ->count(),
                
                'en_camino' => Maquina::whereIn('estado', ['en_transito', 'en_puerto', 'fabricacion', 'en_bodega'])
                                      ->where('activo', true)
                                      ->count(),
                
                'reservadas' => Maquina::where('estado', 'pendiente_despacho')
                                       ->where('activo', true)
                                       ->count(),
                
                'vendidas' => Maquina::where('estado', 'vendida')
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
            
            $maquinas = $query->orderBy('created_at', 'desc')->get();
            
            // Agrupar por orden
            $grupos = [];
            foreach($maquinas as $maquina) {
                $ordenId = $maquina->ordenCompra ? $maquina->ordenCompra->id : 'sin_orden';
                $ordenNumero = $maquina->ordenCompra ? $maquina->ordenCompra->numero_orden : 'Sin Orden';
                
                if (!isset($grupos[$ordenId])) {
                    $grupos[$ordenId] = [
                        'orden_id' => $ordenId,
                        'orden_numero' => $ordenNumero,
                        'maquinas' => []
                    ];
                }
                $grupos[$ordenId]['maquinas'][] = $maquina;
            }
            
            if ($request->ajax() && !$request->has('marcas')) {
                // Construir HTML con agrupación
                $html = '';
                
                if (empty($grupos)) {
                    $html = '<tr><td colspan="8" class="text-center">No hay máquinas registradas</td></tr>';
                } else {
                    foreach ($grupos as $grupo) {
                        $grupoId = 'grupo_' . $grupo['orden_id'];
                        $totalMaquinas = count($grupo['maquinas']);
                        
                        // Checkbox para controlar el grupo (debe estar ANTES del header)
                        $html .= '<input type="checkbox" id="' . $grupoId . '" class="toggle-grupo" style="display: none;">';
                        
                        // HEADER del grupo
                        $html .= '<tr class="grupo-header" style="cursor: pointer; background: rgba(14, 165, 233, 0.05);">';
                        $html .= '<td colspan="8" style="padding: 12px 16px;">';
                        $html .= '<label for="' . $grupoId . '" style="cursor: pointer; display: flex; align-items: center; gap: 10px; width: 100%;">';
                        $html .= '<span class="icono" style="display: inline-block; transition: transform 0.2s; font-size: 14px;">▶</span>';
                        $html .= '<strong>Orden: ' . e($grupo['orden_numero']) . '</strong>';
                        $html .= '<span class="badge badge-info" style="background: rgba(14, 165, 233, 0.2); color: var(--primary);">' . $totalMaquinas . ' máquinas</span>';
                        $html .= '</label>';
                        $html .= '</td>';
                        $html .= '</tr>';
                        
                        // FILAS de máquinas del grupo (todas ocultas inicialmente)
                        foreach ($grupo['maquinas'] as $maquina) {
                            $modeloData = $maquina->modelo;
                            $ordenData = $maquina->ordenCompra;
                            
                            // Obtener nombre de la máquina
                            $nombreModelo = 'N/A';
                            if ($modeloData && !empty($modeloData->modelo)) {
                                $nombreModelo = $modeloData->modelo;
                            } elseif ($ordenData && !empty($ordenData->modelo_maquina)) {
                                $nombreModelo = $ordenData->modelo_maquina;
                            }
                            
                            // Obtener marca/modelo combinado
                            $marcaModelo = 'N/A';
                            if ($modeloData) {
                                $marca = $modeloData->marca ?? '';
                                $modelo = $modeloData->modelo ?? '';
                                if (!empty($marca) && !empty($modelo)) {
                                    $marcaModelo = $marca . ' ' . $modelo;
                                } elseif (!empty($marca)) {
                                    $marcaModelo = $marca;
                                } elseif (!empty($modelo)) {
                                    $marcaModelo = $modelo;
                                }
                            } elseif ($ordenData && !empty($ordenData->modelo_maquina)) {
                                $marcaModelo = $ordenData->modelo_maquina;
                            }
                            
                            if (trim($marcaModelo) == 'N/A' || trim($marcaModelo) == 'N/A N/A') {
                                $marcaModelo = 'N/A';
                            }
                            
                            // Determinar clase del badge según estado
                            $estadoClass = match($maquina->estado) {
                                'disponible' => 'success',
                                'vendida' => 'danger',
                                'en_transito' => 'warning',
                                'pendiente_despacho' => 'info',
                                default => 'secondary'
                            };
                            
                            $estadoIcono = match($maquina->estado) {
                                'disponible' => '📦',
                                'vendida' => '💰',
                                'en_transito' => '🚢',
                                'pendiente_despacho' => '⏳',
                                default => '📌'
                            };
                            
                            $estadoTexto = match($maquina->estado) {
                                'disponible' => 'Disponible',
                                'vendida' => 'Vendida',
                                'en_transito' => 'En Tránsito',
                                'pendiente_despacho' => 'Pendiente Despacho',
                                default => ucfirst(str_replace('_', ' ', $maquina->estado))
                            };
                            
                            $html .= '<tr class="grupo-fila" style="display: none;">';
                            $html .= '<td><strong>' . $maquina->id . '</strong><br><small>Orden: ' . e($grupo['orden_numero']) . '</small></td>';
                            $html .= '<td><strong>' . e($nombreModelo) . '</strong><br><small>Serie: ' . e($maquina->numero_serie ?? 'N/A') . '</small></td>';
                            $html .= '<td>' . e($marcaModelo) . '</td>';
                            $html .= '<td>' . ($maquina->año_fabricacion ?? 'N/A') . '</td>';
                            $html .= '<td>' . e($maquina->numero_serie ?? 'N/A') . '</td>';
                            $html .= '<td>$' . number_format($maquina->precio_venta ?? 0, 0, ',', '.') . '</td>';
                            $html .= '<td><span class="badge badge-' . $estadoClass . '">' . $estadoIcono . ' ' . $estadoTexto . '</span></td>';
                            $html .= '<td style="display: flex; gap: 6px; flex-wrap: wrap;">';
                            $html .= '<button class="btn-sm" onclick="verMaquina(' . $maquina->id . ')"><i class="fas fa-eye"></i></button> ';
                            $html .= '<button class="btn-sm" onclick="editarMaquina(' . $maquina->id . ')"><i class="fas fa-edit"></i></button> ';
                            $html .= '<button class="btn-sm" onclick="abrirModalEstado(' . $maquina->id . ', \'' . $maquina->estado . '\')"><i class="fas fa-exchange-alt"></i></button> ';
                            if ($maquina->estado !== 'vendida') {
                                $html .= '<button class="btn-sm" onclick="reservarMaquina(' . $maquina->id . ')"><i class="fas fa-clock"></i></button> ';
                                $html .= '<button class="btn-sm" onclick="venderMaquina(' . $maquina->id . ')"><i class="fas fa-dollar-sign"></i></button> ';
                            }
                            $html .= '<button class="btn-sm" onclick="eliminarMaquina(' . $maquina->id . ')"><i class="fas fa-trash"></i></button>';
                            $html .= '</td>';
                            $html .= '</tr>';
                        }
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'html' => $html
                ]);
            }
            
            if ($request->has('marcas')) {
                $marcas = \App\Models\MaquinaModelo::where('activo', true)
                    ->whereNotNull('marca')
                    ->where('marca', '!=', '')
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
            \Log::error('Error en maquinariaDisponible: ' . $e->getMessage());
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