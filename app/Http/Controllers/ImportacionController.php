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
use Carbon\Carbon;

class ImportacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $usuario = Auth::user();
        
        $query = OrdenCompraProveedor::with(['creador']);

        // Filtros
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

    /**
     * Show the form for creating a new resource.
     */
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'numero_orden' => 'required|unique:ordenes_compra_proveedor,numero_orden',
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_orden' => 'required|date',
            'fecha_estimada_llegada' => 'nullable|date|after_or_equal:fecha_orden',
            'estado' => 'required|in:pendiente,en_fabricacion,en_transito,en_puerto,recibida,cancelada',
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

    /**
     * ✅ Display the specified resource - CORREGIDO para usar Route Model Binding
     */
    public function show(OrdenCompraProveedor $orden, Request $request)
    {
        $usuario = Auth::user();
        
        // Cargar relaciones necesarias
        $orden->load(['creador', 'detalles', 'maquinas']);
        
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

    /**
     * Show the form for editing the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrdenCompraProveedor $orden)
    {
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha_orden' => 'required|date',
            'fecha_estimada_llegada' => 'nullable|date|after_or_equal:fecha_orden',
            'fecha_llegada_real' => 'nullable|date',
            'estado' => 'required|in:pendiente,en_fabricacion,en_transito,en_puerto,recibida,cancelada',
        ]);

        DB::beginTransaction();
        
        try {
            $proveedor = Proveedor::find($request->proveedor_id);
            
            $orden->update([
                'proveedor' => $proveedor->nombre,
                'pais_origen' => $proveedor->pais,
                'fecha_orden' => $request->fecha_orden,
                'fecha_estimada_llegada' => $request->fecha_estimada_llegada,
                'fecha_llegada_real' => $request->fecha_llegada_real,
                'estado' => $request->estado,
                'observaciones' => $request->observaciones,
            ]);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Orden actualizada correctamente',
                    'orden' => $orden
                ]);
            }

            return redirect()->route('importaciones.show', $orden)
                ->with('success', 'Orden actualizada correctamente');

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
     * Remove the specified resource from storage.
     */
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

    /**
     * Dashboard de importaciones
     */
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
            })->sum(DB::raw('cantidad * precio_unitario')) ?: 1250000000
        ];
        
        $ordenes_pendientes = OrdenCompraProveedor::with(['detalles.maquina.modelo'])
            ->whereIn('estado', ['pendiente', 'en_transito'])
            ->orderBy('fecha_estimada_llegada')
            ->take(5)
            ->get()
            ->map(function($orden) {
                $dias_restantes = $orden->fecha_estimada_llegada ? now()->diffInDays($orden->fecha_estimada_llegada, false) : 15;
                $prioridad = $dias_restantes <= 7 ? 'alta' : ($dias_restantes <= 15 ? 'media' : 'baja');
                
                $primerDetalle = $orden->detalles->first();
                $maquina = $primerDetalle && $primerDetalle->maquina && $primerDetalle->maquina->modelo 
                    ? $primerDetalle->maquina->modelo->modelo 
                    : 'Maquinaria';
                
                return (object)[
                    'id' => $orden->numero_orden,
                    'proveedor' => $orden->proveedor,
                    'pais' => $orden->pais_origen ?? 'N/A',
                    'maquina' => $maquina,
                    'cantidad' => $orden->detalles->sum('cantidad') ?: 1,
                    'monto' => $orden->detalles->sum(DB::raw('cantidad * precio_unitario')) ?: 0,
                    'fecha_estimada' => $orden->fecha_estimada_llegada ?? now(),
                    'prioridad' => $prioridad
                ];
            });
        
        $envios_transito = OrdenCompraProveedor::with(['detalles.maquina.modelo'])
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
                $maquina = $primerDetalle && $primerDetalle->maquina && $primerDetalle->maquina->modelo 
                    ? $primerDetalle->maquina->modelo->marca . ' ' . $primerDetalle->maquina->modelo->modelo
                    : 'Maquinaria';
                
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
        
        $proximas_llegadas = OrdenCompraProveedor::with(['detalles.maquina.modelo'])
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
                $maquina = $primerDetalle && $primerDetalle->maquina && $primerDetalle->maquina->modelo 
                    ? $primerDetalle->maquina->modelo->marca . ' ' . $primerDetalle->maquina->modelo->modelo
                    : 'Maquinaria';
                
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
        
        if ($envios_transito->isEmpty()) {
            $envios_transito = collect([]);
        }
        
        if ($proximas_llegadas->isEmpty()) {
            $proximas_llegadas = collect([]);
        }
        
        if ($proveedores->isEmpty()) {
            $proveedores = collect([]);
        }
        
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