<?php

namespace App\Http\Controllers;

use App\Models\OrdenCompraProveedor;
use App\Models\DetalleOrdenCompra;
use App\Models\Maquina;
use App\Models\MaquinaModelo;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ImportacionController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::user();
        
        $query = OrdenCompraProveedor::with(['creador']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('proveedor')) {
            $query->where('proveedor', 'like', '%' . $request->proveedor . '%');
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('numero_orden', 'like', '%' . $request->search . '%')
                  ->orWhere('proveedor', 'like', '%' . $request->search . '%');
            });
        }

        $ordenes = $query->orderBy('created_at', 'desc')->paginate(10);

        $estados = [
            'pendiente' => '📋 Pendiente',
            'en_fabricacion' => '🏗️ En Fabricación',
            'en_transito' => '🚢 En Tránsito',
            'en_puerto' => '⚓ En Puerto',
            'recibida' => '📦 Recibida',
            'cancelada' => '❌ Cancelada'
        ];

        if ($request->ajax()) {
            try {
                $html = view('importaciones.lista', compact('ordenes', 'estados'))->render();
                
                if (empty(trim($html))) {
                    throw new \Exception('La vista lista.blade.php está vacía');
                }
                
                return response()->json([
                    'success' => true,
                    'html' => $html,
                    'paginator' => [
                        'current_page' => $ordenes->currentPage(),
                        'last_page' => $ordenes->lastPage(),
                        'total' => $ordenes->total(),
                        'per_page' => $ordenes->perPage()
                    ]
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar la lista: ' . $e->getMessage(),
                    'html' => '<div style="text-align: center; padding: 40px; color: var(--danger); background: var(--card-bg); border-radius: 12px; margin: 20px;">
                        <i class="fas fa-exclamation-triangle" style="font-size: 48px; margin-bottom: 16px;"></i>
                        <p>Error al cargar las órdenes: ' . $e->getMessage() . '</p>
                        <button class="btn-primary" onclick="location.reload()" style="margin-top: 16px;">Reintentar</button>
                    </div>'
                ], 500);
            }
        }

        return view('importaciones.index', compact('usuario', 'ordenes', 'estados'));
    }

    public function create(Request $request)
    {
        $usuario = Auth::user();
        $proveedores = Proveedor::where('activo', true)->get();
        $modelos = MaquinaModelo::where('activo', true)->get();
        
        if ($request->ajax()) {
            try {
                $html = view('importaciones.create', compact('usuario', 'proveedores', 'modelos'))->render();
                return response()->json([
                    'success' => true,
                    'html' => $html
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar el formulario: ' . $e->getMessage()
                ], 500);
            }
        }
        
        return view('importaciones.create', compact('usuario', 'proveedores', 'modelos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_orden' => 'required|unique:ordenes_compra_proveedor,numero_orden',
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_orden' => 'required|date',
            'fecha_estimada_llegada' => 'nullable|date|after_or_equal:fecha_orden',
            'estado' => 'required|in:pendiente,en_fabricacion,en_transito,en_puerto,recibida,cancelada',
            'modelo_maquina' => 'nullable|string|max:255',
            'cantidad_maquinas' => 'nullable|integer|min:1|max:999',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        
        try {
            $proveedor = Proveedor::find($request->proveedor_id);
            
            $orden = OrdenCompraProveedor::create([
                'numero_orden' => $request->numero_orden,
                'proveedor' => $proveedor->nombre,
                'pais_origen' => $proveedor->pais,
                'fecha_orden' => $request->fecha_orden,
                'fecha_estimada_llegada' => $request->fecha_estimada_llegada,
                'fecha_llegada_real' => $request->fecha_llegada_real,
                'estado' => $request->estado,
                'modelo_maquina' => $request->modelo_maquina,
                'cantidad_maquinas' => $request->cantidad_maquinas,
                'observaciones' => $request->observaciones,
                'created_by' => Auth::id()
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Orden de importación creada correctamente',
                    'orden' => $orden
                ]);
            }

            return redirect()->route('importaciones.index')
                ->with('success', 'Orden de importación creada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la orden: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al crear la orden: ' . $e->getMessage())->withInput();
        }
    }

    public function show(OrdenCompraProveedor $orden, Request $request)
    {
        $usuario = Auth::user();
        $orden->load(['creador', 'detalles.modelo', 'maquinas.modelo', 'maquinas.ordenCompra']);
        
        if ($request->ajax()) {
            try {
                $html = view('importaciones.show', compact('usuario', 'orden'))->render();
                return response()->json([
                    'success' => true,
                    'html' => $html
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar los detalles: ' . $e->getMessage()
                ], 500);
            }
        }
        
        return view('importaciones.show', compact('usuario', 'orden'));
    }

    public function edit(OrdenCompraProveedor $orden, Request $request)
    {
        $usuario = Auth::user();
        $proveedores = Proveedor::where('activo', true)->get();
        $modelos = MaquinaModelo::where('activo', true)->get();
        
        if ($request->ajax()) {
            try {
                $html = view('importaciones.edit', compact('usuario', 'orden', 'proveedores', 'modelos'))->render();
                return response()->json([
                    'success' => true,
                    'html' => $html
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al cargar el formulario: ' . $e->getMessage()
                ], 500);
            }
        }
        
        return view('importaciones.edit', compact('usuario', 'orden', 'proveedores', 'modelos'));
    }

    public function update(Request $request, OrdenCompraProveedor $orden)
    {
        $request->validate([
            'numero_orden' => 'required|unique:ordenes_compra_proveedor,numero_orden,' . $orden->id,
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_orden' => 'required|date',
            'fecha_estimada_llegada' => 'nullable|date|after_or_equal:fecha_orden',
            'fecha_llegada_real' => 'nullable|date',
            'estado' => 'required|in:pendiente,en_fabricacion,en_transito,en_puerto,recibida,cancelada',
            'modelo_maquina' => 'nullable|string|max:255',
            'cantidad_maquinas' => 'nullable|integer|min:1|max:999',
            'observaciones' => 'nullable|string',
        ]);

        DB::beginTransaction();
        
        try {
            $proveedor = Proveedor::find($request->proveedor_id);
            
            $estadoAnterior = $orden->estado;
            
            $orden->update([
                'numero_orden' => $request->numero_orden,
                'proveedor' => $proveedor->nombre,
                'pais_origen' => $proveedor->pais,
                'fecha_orden' => $request->fecha_orden,
                'fecha_estimada_llegada' => $request->fecha_estimada_llegada,
                'fecha_llegada_real' => $request->fecha_llegada_real,
                'estado' => $request->estado,
                'modelo_maquina' => $request->modelo_maquina,
                'cantidad_maquinas' => $request->cantidad_maquinas,
                'observaciones' => $request->observaciones,
            ]);

            // Auto-crear máquinas cuando se marca como RECIBIDA
            if ($request->estado === 'recibida' && $estadoAnterior !== 'recibida' && $orden->maquinas()->count() === 0) {
                $this->crearMaquinasAutomaticamente($orden);
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Orden actualizada correctamente' . 
                        ($request->estado === 'recibida' && $estadoAnterior !== 'recibida' ? ' y máquinas creadas' : ''),
                    'orden' => $orden
                ]);
            }

            return redirect()->route('importaciones.show', $orden)
                ->with('success', 'Orden actualizada correctamente' . 
                    ($request->estado === 'recibida' && $estadoAnterior !== 'recibida' ? ' y máquinas creadas' : ''));

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Crear máquinas automáticamente cuando la orden se marca como RECIBIDA
     */
    private function crearMaquinasAutomaticamente(OrdenCompraProveedor $orden)
    {
        $cantidadTotal = $orden->cantidad_maquinas ?? 1;
        $modeloNombre = $orden->modelo_maquina ?? 'Maquinaria General';
        $marcaNombre = $orden->proveedor ?? 'Genérica';
        
        // Buscar o crear un modelo en maquinas_modelos
        $modelo = MaquinaModelo::firstOrCreate(
            ['modelo' => $modeloNombre],
            [
                'marca' => $marcaNombre,
                'tipo_maquina' => 'Maquinaria',
                'especificaciones' => 'Modelo creado automáticamente desde orden de compra',
                'activo' => true
            ]
        );

        for ($i = 0; $i < $cantidadTotal; $i++) {
            $numeroSerie = $this->generarNumeroSerie($modeloNombre, $orden->id, $i);
            
            Maquina::create([
                'modelo_id' => $modelo->id,
                'numero_serie' => $numeroSerie,
                'año_fabricacion' => now()->year,
                'estado' => 'disponible',
                'ubicacion_actual' => 'Bodega Central',
                'precio_compra' => 0,
                'precio_venta' => 0,
                'fecha_ingreso' => now(),
                'activo' => true,
                'orden_compra_proveedor_id' => $orden->id,
                'observaciones' => "Generada automáticamente desde orden {$orden->numero_orden}"
            ]);
        }
        
        Log::info("Máquinas creadas automáticamente para orden: {$orden->numero_orden}", [
            'cantidad' => $cantidadTotal,
            'modelo_id' => $modelo->id,
            'modelo_nombre' => $modeloNombre,
            'orden_id' => $orden->id
        ]);
    }

    /**
     * Crear máquinas manualmente desde el botón en el detalle de la orden
     */
    public function crearMaquinas(OrdenCompraProveedor $orden, Request $request)
    {
        try {
            DB::beginTransaction();

            if ($orden->maquinas()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta orden ya tiene máquinas asociadas'
                ], 400);
            }

            $cantidadTotal = $orden->cantidad_maquinas ?? 1;
            $modeloNombre = $orden->modelo_maquina ?? 'Maquinaria General';
            $marcaNombre = $orden->proveedor ?? 'Genérica';

            // Buscar o crear un modelo en maquinas_modelos
            $modelo = MaquinaModelo::firstOrCreate(
                ['modelo' => $modeloNombre],
                [
                    'marca' => $marcaNombre,
                    'tipo_maquina' => 'Maquinaria',
                    'especificaciones' => 'Modelo creado desde orden de compra',
                    'activo' => true
                ]
            );

            for ($i = 0; $i < $cantidadTotal; $i++) {
                $numeroSerie = $this->generarNumeroSerie($modeloNombre, $orden->id, $i);
                
                Maquina::create([
                    'modelo_id' => $modelo->id,
                    'numero_serie' => $numeroSerie,
                    'año_fabricacion' => now()->year,
                    'estado' => 'disponible',
                    'ubicacion_actual' => 'Bodega Central',
                    'precio_compra' => 0,
                    'precio_venta' => 0,
                    'fecha_ingreso' => now(),
                    'activo' => true,
                    'orden_compra_proveedor_id' => $orden->id,
                    'observaciones' => "Generada manualmente desde orden {$orden->numero_orden}"
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Se crearon {$cantidadTotal} máquina(s) correctamente",
                'count' => $cantidadTotal
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(OrdenCompraProveedor $orden, Request $request)
    {
        try {
            $orden->delete();
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Orden eliminada correctamente'
                ]);
            }
            
            return redirect()->route('importaciones.index')
                ->with('success', 'Orden eliminada correctamente');
                
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al eliminar: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

    private function generarNumeroSerie($modelo, $ordenId, $indice = 0)
    {
        $prefijo = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $modelo), 0, 3));
        if (empty($prefijo)) {
            $prefijo = 'MAQ';
        }
        $fecha = now()->format('ymd');
        $numero = str_pad($ordenId, 4, '0', STR_PAD_LEFT) . str_pad($indice, 2, '0', STR_PAD_LEFT);
        return "{$prefijo}-{$fecha}-{$numero}";
    }

    public function dashboard()
    {
        $usuario = Auth::user();
        
        $stats = [
            'ordenes_pendientes' => OrdenCompraProveedor::whereIn('estado', ['pendiente', 'en_transito'])->count(),
            'en_transito' => OrdenCompraProveedor::where('estado', 'en_transito')->count(),
            'llegadas_este_mes' => OrdenCompraProveedor::whereMonth('fecha_estimada_llegada', now()->month)
                ->whereYear('fecha_estimada_llegada', now()->year)
                ->count(),
            'proveedores_activos' => Proveedor::where('activo', true)->count(),
            'contenedores_activos' => DetalleOrdenCompra::whereHas('ordenCompra', function($q) {
                $q->where('estado', 'en_transito');
            })->sum('cantidad'),
            'ordenes_atrasadas' => OrdenCompraProveedor::whereIn('estado', ['pendiente', 'en_transito'])
                ->where('fecha_estimada_llegada', '<', now())
                ->count(),
            'monto_compras_mes' => DetalleOrdenCompra::whereHas('ordenCompra', function($q) {
                $q->whereMonth('fecha_orden', now()->month)
                  ->whereYear('fecha_orden', now()->year);
            })->sum(DB::raw('cantidad * precio_unitario')) ?: 0
        ];
        
        $ordenes_pendientes = OrdenCompraProveedor::with(['detalles.modelo'])
            ->whereIn('estado', ['pendiente', 'en_transito'])
            ->orderBy('fecha_estimada_llegada')
            ->take(5)
            ->get()
            ->map(function($orden) {
                $dias_restantes = $orden->fecha_estimada_llegada ? now()->diffInDays($orden->fecha_estimada_llegada, false) : 15;
                $prioridad = $dias_restantes <= 7 ? 'alta' : ($dias_restantes <= 15 ? 'media' : 'baja');
                
                $primerDetalle = $orden->detalles->first();
                $maquina = $primerDetalle && $primerDetalle->modelo 
                    ? $primerDetalle->modelo->modelo 
                    : ($orden->modelo_maquina ?? 'Maquinaria');
                
                return (object)[
                    'id' => $orden->id,
                    'numero_orden' => $orden->numero_orden,
                    'proveedor' => $orden->proveedor,
                    'pais' => $orden->pais_origen ?? 'N/A',
                    'maquina' => $maquina,
                    'cantidad' => $orden->detalles->sum('cantidad') ?: ($orden->cantidad_maquinas ?: 1),
                    'monto' => $orden->detalles->sum(DB::raw('cantidad * precio_unitario')) ?: 0,
                    'fecha_estimada' => $orden->fecha_estimada_llegada ?? now(),
                    'prioridad' => $prioridad,
                    'modelo_maquina' => $orden->modelo_maquina,
                    'cantidad_maquinas' => $orden->cantidad_maquinas ?? 1,
                ];
            });
        
        $envios_transito = OrdenCompraProveedor::with(['detalles.modelo'])
            ->where('estado', 'en_transito')
            ->whereNotNull('fecha_estimada_llegada')
            ->take(4)
            ->get()
            ->map(function($orden) {
                $fecha_salida = $orden->fecha_orden ?? Carbon::now()->subDays(15);
                $fecha_llegada = $orden->fecha_estimada_llegada ?? Carbon::now()->addDays(15);
                $dias_totales = $fecha_salida->diffInDays($fecha_llegada) ?: 30;
                $dias_transcurridos = $fecha_salida->diffInDays(now());
                $progreso = $dias_totales > 0 ? min(100, round(($dias_transcurridos / $dias_totales) * 100)) : 50;
                
                $estado = $progreso > 80 ? 'cercano' : ($progreso > 30 ? 'en_navegacion' : 'en_aduana_origen');
                
                $primerDetalle = $orden->detalles->first();
                $maquina = $primerDetalle && $primerDetalle->modelo 
                    ? $primerDetalle->modelo->marca . ' ' . $primerDetalle->modelo->modelo
                    : ($orden->modelo_maquina ?? 'Maquinaria');
                
                return (object)[
                    'contenedor' => 'CONT-' . str_pad($orden->id, 6, '0', STR_PAD_LEFT),
                    'maquina' => $maquina,
                    'puerto_salida' => $this->getPuertoFromPais($orden->pais_origen),
                    'puerto_llegada' => 'San Antonio',
                    'fecha_salida' => $fecha_salida,
                    'fecha_llegada_estimada' => $fecha_llegada,
                    'estado' => $estado,
                    'progreso' => $progreso,
                    'documentos' => $progreso > 70 ? 'completos' : 'pendientes'
                ];
            });
        
        $proximas_llegadas = OrdenCompraProveedor::with(['detalles.modelo'])
            ->where('estado', 'en_transito')
            ->whereNotNull('fecha_estimada_llegada')
            ->where('fecha_estimada_llegada', '>=', now())
            ->orderBy('fecha_estimada_llegada')
            ->take(5)
            ->get()
            ->map(function($orden) {
                $dias_restantes = now()->diffInDays($orden->fecha_estimada_llegada);
                $estado = $dias_restantes <= 2 ? 'en_inspeccion' : 
                          ($dias_restantes <= 5 ? 'en_transito' : 'documentacion');
                
                $primerDetalle = $orden->detalles->first();
                $maquina = $primerDetalle && $primerDetalle->modelo 
                    ? $primerDetalle->modelo->marca . ' ' . $primerDetalle->modelo->modelo
                    : ($orden->modelo_maquina ?? 'Maquinaria');
                
                return (object)[
                    'contenedor' => 'CONT-' . str_pad($orden->id, 6, '0', STR_PAD_LEFT),
                    'maquina' => $maquina,
                    'puerto' => 'San Antonio',
                    'fecha' => $orden->fecha_estimada_llegada,
                    'estado' => $estado
                ];
            });
        
        $proveedores = Proveedor::where('activo', true)
            ->take(5)
            ->get()
            ->map(function($proveedor) {
                $ordenes_activas = OrdenCompraProveedor::where('proveedor', $proveedor->nombre)
                    ->whereIn('estado', ['pendiente', 'en_transito'])
                    ->count();
                
                return (object)[
                    'nombre' => $proveedor->nombre,
                    'pais' => $proveedor->pais ?? 'N/A',
                    'ordenes_activas' => $ordenes_activas,
                    'tiempo_promedio' => rand(22, 30),
                    'cumplimiento' => rand(92, 98)
                ];
            });
        
        $documentos_pendientes = collect([
            (object)[
                'tipo' => 'Factura Comercial',
                'contenedor' => $envios_transito->isNotEmpty() ? $envios_transito->first()->contenedor : 'CONT-123456',
                'proveedor' => $proveedores->isNotEmpty() ? $proveedores->first()->nombre : 'Proveedor',
                'fecha_requerida' => Carbon::now()->addDays(2),
                'prioridad' => 'alta'
            ],
            (object)[
                'tipo' => 'Certificado Origen',
                'contenedor' => $envios_transito->count() > 1 ? $envios_transito->get(1)->contenedor : 'CONT-789012',
                'proveedor' => $proveedores->count() > 1 ? $proveedores->get(1)->nombre : 'Proveedor',
                'fecha_requerida' => Carbon::now()->addDays(5),
                'prioridad' => 'media'
            ],
            (object)[
                'tipo' => 'Seguro Internacional',
                'contenedor' => $envios_transito->isNotEmpty() ? $envios_transito->last()->contenedor : 'CONT-456789',
                'proveedor' => $proveedores->isNotEmpty() ? $proveedores->first()->nombre : 'Proveedor',
                'fecha_requerida' => Carbon::now()->addDays(1),
                'prioridad' => 'urgente'
            ]
        ]);
        
        return view('dashboardimportaciones', compact(
            'usuario',
            'stats',
            'ordenes_pendientes',
            'envios_transito',
            'proximas_llegadas',
            'proveedores',
            'documentos_pendientes'
        ));
    }

    // ==================== MÉTODOS PARA MAQUINARIA DISPONIBLE ====================

    /**
     * Obtener máquinas disponibles para el dashboard
     */
    public function maquinariaDisponible(Request $request)
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
            
            $maquinas = $query->orderBy('created_at', 'desc')->paginate(15);
            
            // Si la solicitud es AJAX y no es para marcas
            if ($request->ajax() && !$request->has('marcas')) {
                // Construir el HTML manualmente
                $html = '';
                
                if ($maquinas->isEmpty()) {
                    $html = '<tr><td colspan="8" class="text-center">No hay máquinas registradas</td></tr>';
                } else {
                    foreach ($maquinas as $maquina) {
                        $modeloData = $maquina->modelo;
                        $ordenData = $maquina->ordenCompra;
                        
                        // Obtener nombre de la máquina y marca
                        $nombreMaquina = $modeloData ? ($modeloData->modelo ?: 'Sin modelo') : 'Sin modelo';
                        $marcaMaquina = $modeloData ? ($modeloData->marca ?: 'N/A') : 'N/A';
                        $modeloCompleto = $marcaMaquina . ' ' . $nombreMaquina;
                        
                        // Obtener datos de la orden
                        $numeroOrden = $ordenData ? ($ordenData->numero_orden ?? 'N/A') : 'N/A';
                        $cantidadOrden = $ordenData ? ($ordenData->cantidad_maquinas ?? 1) : 1;
                        
                        // Determinar clase del badge según estado
                        $estadoClass = match($maquina->estado) {
                            'disponible' => 'badge-success',
                            'vendida' => 'badge-danger',
                            'en_transito' => 'badge-warning',
                            'pendiente_despacho' => 'badge-info',
                            default => 'badge-secondary'
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
                        
                        $html .= '<tr>';
                        $html .= '<td><strong>' . $maquina->id . '</strong><br><small>Orden: ' . e($numeroOrden) . '<br>(' . $cantidadOrden . ' máquinas)</small></td>';
                        $html .= '<td><strong>' . e($nombreMaquina) . '</strong><br><small>Serie: ' . e($maquina->numero_serie ?? 'N/A') . '</small></td>';
                        $html .= '<td>' . e($modeloCompleto) . '</td>';
                        $html .= '<td>' . ($maquina->año_fabricacion ?? 'N/A') . '</td>';
                        $html .= '<td>' . e($maquina->numero_serie ?? 'N/A') . '</td>';
                        $html .= '<td>$' . number_format($maquina->precio_venta ?? 0, 0, ',', '.') . '</td>';
                        $html .= '<td><span class="badge ' . $estadoClass . '">' . $estadoIcono . ' ' . $estadoTexto . '</span></td>';
                        $html .= '<td>';
                        $html .= '<button class="btn-sm" onclick="verMaquina(' . $maquina->id . ')"><i class="fas fa-eye"></i></button> ';
                        if ($maquina->estado !== 'vendida') {
                            $html .= '<button class="btn-sm" onclick="reservarMaquina(' . $maquina->id . ')"><i class="fas fa-bookmark"></i></button> ';
                            $html .= '<button class="btn-sm" onclick="venderMaquina(' . $maquina->id . ')"><i class="fas fa-dollar-sign"></i></button> ';
                        }
                        $html .= '<button class="btn-sm" onclick="abrirModalEstado(' . $maquina->id . ', \'' . $maquina->estado . '\')"><i class="fas fa-exchange-alt"></i></button> ';
                        $html .= '<button class="btn-sm" onclick="eliminarMaquina(' . $maquina->id . ')"><i class="fas fa-trash"></i></button>';
                        $html .= '</td>';
                        $html .= '</tr>';
                    }
                }
                
                return response()->json([
                    'success' => true,
                    'html' => $html
                ]);
            }
            
            // Si la solicitud es para obtener marcas
            if ($request->has('marcas')) {
                $marcas = MaquinaModelo::where('activo', true)
                    ->whereNotNull('marca')
                    ->distinct()
                    ->pluck('marca')
                    ->filter()
                    ->values();
                
                return response()->json([
                    'success' => true,
                    'marcas' => $marcas
                ]);
            }
            
            // Para solicitudes normales, devolver vista completa
            return view('importaciones.maquinaria-lista', compact('maquinas'));
            
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ], 500);
            }
            return back()->with('error', 'Error al cargar máquinas: ' . $e->getMessage());
        }
    }

    /**
     * Obtener estadísticas de maquinaria
     */
    public function maquinariaEstadisticas()
    {
        try {
            $estadisticas = [
                'disponibles' => Maquina::where('estado', 'disponible')->where('activo', true)->count(),
                'en_camino' => Maquina::whereIn('estado', ['en_transito', 'en_puerto', 'fabricacion', 'en_bodega'])->count(),
                'reservadas' => Maquina::where('estado', 'pendiente_despacho')->count(),
                'vendidas' => Maquina::where('estado', 'vendida')->count(),
            ];
            
            return response()->json($estadisticas);
            
        } catch (\Exception $e) {
            return response()->json([
                'disponibles' => 0,
                'en_camino' => 0,
                'reservadas' => 0,
                'vendidas' => 0
            ]);
        }
    }

    /**
     * Cambiar estado de una máquina
     */
    public function cambiarEstadoMaquina($id, Request $request)
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
    public function reservarMaquina($id, Request $request)
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
    public function venderMaquina($id, Request $request)
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

    private function getPuertoFromPais($pais)
    {
        $puertos = [
            'EE.UU.' => 'Houston',
            'USA' => 'Houston',
            'Estados Unidos' => 'Houston',
            'Japón' => 'Yokohama',
            'Japon' => 'Yokohama',
            'Suecia' => 'Gotemburgo',
            'China' => 'Shanghai',
            'Alemania' => 'Hamburgo',
            'Italia' => 'Génova',
            'Brasil' => 'Santos'
        ];
        
        return $puertos[$pais] ?? 'Puerto de origen';
    }
}