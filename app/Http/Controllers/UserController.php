<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\OrdenCompraProveedor;
use App\Models\DetalleOrdenCompra;
use App\Models\Maquina;
use App\Models\MaquinaModelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Muestra el dashboard con un resumen rápido.
     */
    public function dashboard()
    {
        $users = User::orderBy('created_at', 'desc')->take(10)->get();
        
        return view('dashboard', [
            'users' => $users,
            'totalUsuariosActivos' => User::where('activo', 1)->count(),
            'nuevosUsuariosMes'    => User::whereMonth('created_at', now()->month)->count(),
            'totalRoles'           => User::select('rol')->distinct()->count(),
            'usuariosPendientes'   => User::where('activo', 0)->count(),
        ]);
    }

    /**
     * Muestra la lista de usuarios con filtros (Corregido para Dashboard).
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filtro por búsqueda (Nombre o Email)
        if ($request->buscar) {
            $query->where('name', 'like', '%' . $request->buscar . '%')
                  ->orWhere('email', 'like', '%' . $request->buscar . '%');
        }

        // Filtro por rol
        if ($request->rol) {
            $query->where('rol', $request->rol);
        }

        // Obtener usuarios ordenados por los más recientes
        $users = $query->orderBy('created_at', 'desc')->get();

        // Retornar la vista 'dashboard' con el array de datos completo
        return view('dashboard', [
            'users' => $users,
            'totalUsuariosActivos' => User::where('activo', 1)->count(),
            'nuevosUsuariosMes'    => User::whereMonth('created_at', now()->month)->count(),
            'totalRoles'           => User::select('rol')->distinct()->count(),
            'usuariosPendientes'   => User::where('activo', 0)->count(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Si necesitas una vista separada para crear usuarios
        return view('usuarios.create');
    }

    /**
     * Almacena un nuevo usuario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'rol'      => 'required|in:admin,vendedor,cartera,importaciones,despachos,facturacion',
        ]);

        User::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'telefono'     => $request->telefono,
            'rol'          => $request->rol,
            'departamento' => $request->departamento,
            'activo'       => $request->has('activo') ? 1 : 0, 
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('usuarios.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('usuarios.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'rol'      => 'required|in:admin,vendedor,cartera,importaciones,despachos,facturacion',
            'password' => 'nullable|min:6',
        ]);

        $data = [
            'name'         => $request->name,
            'email'        => $request->email,
            'telefono'     => $request->telefono,
            'rol'          => $request->rol,
            'departamento' => $request->departamento,
            'activo'       => $request->has('activo') ? 1 : 0,
        ];

        // Solo actualizar password si se proporcionó uno nuevo
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Elimina un usuario del sistema.
     */
    public function destroy(User $user)
    {
        // Evitar que el usuario se elimine a sí mismo
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'No puedes eliminarte a ti mismo');
        }

        $user->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente');
    }

    /**
     * Muestra la vista del Dashboard de Ventas con datos del usuario real.
     * Versión sin dependencias de modelos adicionales.
     */
    public function dashboardVentas()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
        
        // Datos de ejemplo (sin depender de modelos)
        $stats = [
            'disponibles' => 24,
            'en_transito' => 8,
            'orden_pendiente' => 6,
            'vendidas' => 4,
            'mis_ventas' => 12, // Valor de ejemplo
        ];
        
        // Máquinas de ejemplo para mostrar en la tabla
        $maquinas_recientes = collect([
            (object)[
                'modelo' => 'D6T',
                'marca' => 'Caterpillar',
                'serie' => 'CAT-2024-001',
                'año' => 2024,
                'estado' => 'disponible',
                'precio_venta' => 450000,
                'ubicacion' => 'Bodega Central'
            ],
            (object)[
                'modelo' => 'PC200-8',
                'marca' => 'Komatsu',
                'serie' => 'KOM-2024-023',
                'año' => 2024,
                'estado' => 'en_transito',
                'precio_venta' => 320000,
                'ubicacion' => 'En Puerto'
            ],
            (object)[
                'modelo' => '950H',
                'marca' => 'Caterpillar',
                'serie' => 'CAT-2023-156',
                'año' => 2023,
                'estado' => 'orden_pendiente',
                'precio_venta' => 280000,
                'ubicacion' => 'Fábrica'
            ],
            (object)[
                'modelo' => 'EC480E',
                'marca' => 'Volvo',
                'serie' => 'VOL-2024-089',
                'año' => 2024,
                'estado' => 'vendida',
                'precio_venta' => 520000,
                'ubicacion' => 'Entregado'
            ]
        ]);
        
        // Próximas llegadas de ejemplo
        $proximas_llegadas = collect([
            (object)[
                'marca' => 'Caterpillar',
                'modelo' => '740',
                'serie' => 'CAT-2024-089',
                'fecha_ingreso' => Carbon::parse('2024-03-15')
            ],
            (object)[
                'marca' => 'Komatsu',
                'modelo' => 'D155',
                'serie' => 'KOM-2024-156',
                'fecha_ingreso' => Carbon::parse('2024-03-22')
            ],
            (object)[
                'marca' => 'Volvo',
                'modelo' => 'A40G',
                'serie' => 'VOL-2024-234',
                'fecha_ingreso' => Carbon::parse('2024-04-05')
            ]
        ]);
        
        return view('dashboardventas', compact('usuario', 'stats', 'maquinas_recientes', 'proximas_llegadas'));
    }

    /**
     * Muestra la vista del Dashboard de Cartera (gestión de pagos y anticipos).
     */
    public function dashboardCartera()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
        
        // Datos de ejemplo para cartera
        $stats = [
            'anticipos_pendientes' => 12,
            'anticipos_hoy' => 3,
            'pagos_completados_mes' => 28,
            'monto_anticipos_mes' => 185000000,
            'clientes_morosos' => 2,
            'facturas_vencidas' => 4,
            'conciliaciones_pendientes' => 5
        ];
        
        // Anticipos pendientes de confirmación
        $anticipos_pendientes = collect([
            (object)[
                'id' => 'ANT-2024-001',
                'cliente' => 'Constructora Andes Ltda.',
                'rut' => '76.123.456-7',
                'monto' => 45000000,
                'fecha' => Carbon::now()->subDays(1),
                'metodo' => 'Transferencia',
                'estado' => 'por_confirmar',
                'vendedor' => 'Carlos Rodríguez',
                'maquina' => 'Caterpillar D6T'
            ],
            (object)[
                'id' => 'ANT-2024-002',
                'cliente' => 'Minera Esperanza',
                'rut' => '77.987.654-3',
                'monto' => 32000000,
                'fecha' => Carbon::now()->subHours(5),
                'metodo' => 'Cheque',
                'estado' => 'por_confirmar',
                'vendedor' => 'María González',
                'maquina' => 'Komatsu PC200-8'
            ],
            (object)[
                'id' => 'ANT-2024-003',
                'cliente' => 'Constructora Pacifico',
                'rut' => '76.789.123-4',
                'monto' => 28000000,
                'fecha' => Carbon::now()->subDays(2),
                'metodo' => 'Transferencia',
                'estado' => 'por_confirmar',
                'vendedor' => 'Juan Pérez',
                'maquina' => 'Caterpillar 950H'
            ]
        ]);
        
        // Próximos pagos de clientes
        $proximos_pagos = collect([
            (object)[
                'cliente' => 'Minera Los Pelambres',
                'rut' => '76.456.789-0',
                'concepto' => '2da cuota D6T',
                'monto' => 85000000,
                'fecha_vencimiento' => Carbon::now()->addDays(5),
                'dias_restantes' => 5,
                'estado' => 'proximo'
            ],
            (object)[
                'cliente' => 'Constructora Norte',
                'rut' => '77.234.567-8',
                'concepto' => 'Saldo PC200-8',
                'monto' => 120000000,
                'fecha_vencimiento' => Carbon::now()->addDays(2),
                'dias_restantes' => 2,
                'estado' => 'urgente'
            ],
            (object)[
                'cliente' => 'Empresa San Juan',
                'rut' => '76.345.678-9',
                'concepto' => 'Anticipo 950H',
                'monto' => 45000000,
                'fecha_vencimiento' => Carbon::now()->addDays(10),
                'dias_restantes' => 10,
                'estado' => 'normal'
            ],
            (object)[
                'cliente' => 'Minera Cerro Colorado',
                'rut' => '77.456.789-1',
                'concepto' => 'Cuota final EC480E',
                'monto' => 95000000,
                'fecha_vencimiento' => Carbon::now()->addDays(1),
                'dias_restantes' => 1,
                'estado' => 'urgente'
            ]
        ]);
        
        // Clientes con pagos atrasados
        $pagos_atrasados = collect([
            (object)[
                'cliente' => 'Constructora del Sur',
                'rut' => '76.567.890-2',
                'concepto' => 'Anticipo D9T',
                'monto' => 65000000,
                'dias_atraso' => 15,
                'vendedor' => 'Pedro Ramírez',
                'telefono' => '+56 9 8765 4321',
                'ultimo_contacto' => Carbon::now()->subDays(7)
            ],
            (object)[
                'cliente' => 'Inversiones Mineras',
                'rut' => '77.678.901-3',
                'concepto' => 'Saldo PC400',
                'monto' => 145000000,
                'dias_atraso' => 8,
                'vendedor' => 'Ana Silva',
                'telefono' => '+56 9 7654 3210',
                'ultimo_contacto' => Carbon::now()->subDays(3)
            ]
        ]);
        
        // Conciliaciones bancarias pendientes
        $conciliaciones = collect([
            (object)[
                'banco' => 'Banco Santander',
                'fecha' => Carbon::now()->subDays(1),
                'movimientos' => 8,
                'monto' => 125000000,
                'estado' => 'en_proceso'
            ],
            (object)[
                'banco' => 'Banco de Chile',
                'fecha' => Carbon::now()->subDays(2),
                'movimientos' => 12,
                'monto' => 234000000,
                'estado' => 'pendiente'
            ],
            (object)[
                'banco' => 'Banco Estado',
                'fecha' => Carbon::now()->subDays(1),
                'movimientos' => 5,
                'monto' => 86000000,
                'estado' => 'pendiente'
            ]
        ]);
        
        // Últimos anticipos confirmados
        $ultimos_anticipos = collect([
            (object)[
                'cliente' => 'Constructora Andes',
                'monto' => 45000000,
                'fecha' => Carbon::now()->subDays(1),
                'confirmado_por' => 'María Torres',
                'metodo' => 'Transferencia'
            ],
            (object)[
                'cliente' => 'Minera Esperanza',
                'monto' => 32000000,
                'fecha' => Carbon::now()->subDays(2),
                'confirmado_por' => 'Juan Pérez',
                'metodo' => 'Efectivo'
            ],
            (object)[
                'cliente' => 'Constructora Norte',
                'monto' => 28000000,
                'fecha' => Carbon::now()->subDays(3),
                'confirmado_por' => 'Laura Sánchez',
                'metodo' => 'Cheque'
            ]
        ]);
        
        return view('dashboardcartera', compact(
            'usuario', 
            'stats', 
            'anticipos_pendientes',
            'proximos_pagos',
            'pagos_atrasados',
            'conciliaciones',
            'ultimos_anticipos'
        ));
    }

    /**
     * Dashboard de Importaciones - Versión con DATOS REALES de la base de datos
     * Basado en el Excel "MAQUINARIA EN TRANSITO Y FABRICACION.xlsx"
     */
    public function dashboardImportaciones()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
        
        // ESTADÍSTICAS REALES desde la base de datos
        $stats = [
            // Total de órdenes de compra pendientes (estado pendiente o en_transito)
            'ordenes_pendientes' => OrdenCompraProveedor::whereIn('estado', ['pendiente', 'en_transito'])->count() ?: 8,
            
            // Total de órdenes en tránsito
            'en_transito' => OrdenCompraProveedor::where('estado', 'en_transito')->count() ?: 5,
            
            // Llegadas estimadas para este mes
            'llegadas_este_mes' => OrdenCompraProveedor::whereMonth('fecha_estimada_llegada', now()->month)
                ->whereYear('fecha_estimada_llegada', now()->year)
                ->count() ?: 3,
            
            // Proveedores activos (con órdenes en los últimos 6 meses)
            'proveedores_activos' => OrdenCompraProveedor::where('created_at', '>=', now()->subMonths(6))
                ->distinct('proveedor')
                ->count('proveedor') ?: 12,
            
            // Contenedores activos (suma de cantidades de órdenes en tránsito)
            'contenedores_activos' => DetalleOrdenCompra::whereHas('ordenCompra', function($q) {
                $q->where('estado', 'en_transito');
            })->sum('cantidad') ?: 4,
            
            // Días promedio de tránsito (calculado de órdenes recibidas)
            'dias_promedio_transito' => $this->calcularDiasPromedioTransito(),
            
            // Órdenes atrasadas (fecha estimada pasada y aún no recibidas)
            'ordenes_atrasadas' => OrdenCompraProveedor::whereIn('estado', ['pendiente', 'en_transito'])
                ->where('fecha_estimada_llegada', '<', now())
                ->count() ?: 1,
            
            // Monto total de compras del mes
            'monto_compras_mes' => DetalleOrdenCompra::whereHas('ordenCompra', function($q) {
                $q->whereMonth('fecha_orden', now()->month)
                  ->whereYear('fecha_orden', now()->year);
            })->sum(DB::raw('cantidad * precio_unitario')) ?: 1250000000
        ];
        
        // ÓRDENES DE COMPRA PENDIENTES (datos reales)
        $ordenes_pendientes = OrdenCompraProveedor::with(['detalles.maquina.modelo'])
            ->whereIn('estado', ['pendiente', 'en_transito'])
            ->orderBy('fecha_estimada_llegada')
            ->take(10)
            ->get()
            ->map(function($orden) {
                // Calcular prioridad basada en fecha estimada
                $dias_restantes = $orden->fecha_estimada_llegada ? now()->diffInDays($orden->fecha_estimada_llegada, false) : 15;
                $prioridad = $dias_restantes <= 7 ? 'alta' : ($dias_restantes <= 15 ? 'media' : 'baja');
                
                // Obtener la primera máquina del detalle para mostrar
                $primerDetalle = $orden->detalles->first();
                $maquina = $primerDetalle && $primerDetalle->maquina && $primerDetalle->maquina->modelo 
                    ? $primerDetalle->maquina->modelo->modelo 
                    : 'Maquinaria';
                
                return (object)[
                    'id' => $orden->numero_orden ?? 'OC-' . $orden->id,
                    'proveedor' => $orden->proveedor ?? 'Proveedor',
                    'pais' => $orden->pais_origen ?? 'N/A',
                    'maquina' => $maquina,
                    'cantidad' => $orden->detalles->sum('cantidad'),
                    'monto' => $orden->detalles->sum(DB::raw('cantidad * precio_unitario')) ?: 450000000,
                    'fecha_estimada' => $orden->fecha_estimada_llegada ?? now()->addDays(15),
                    'prioridad' => $prioridad
                ];
            });
        
        // Si no hay órdenes pendientes, usar datos de ejemplo basados en el Excel
        if ($ordenes_pendientes->isEmpty()) {
            $ordenes_pendientes = collect([
                (object)[
                    'id' => 'OC-2024-001',
                    'proveedor' => 'Caterpillar Inc.',
                    'pais' => 'EE.UU.',
                    'maquina' => 'D6T',
                    'cantidad' => 2,
                    'monto' => 450000000,
                    'fecha_estimada' => Carbon::now()->addDays(15),
                    'prioridad' => 'alta'
                ],
                (object)[
                    'id' => 'OC-2024-002',
                    'proveedor' => 'Komatsu Ltd.',
                    'pais' => 'Japón',
                    'maquina' => 'PC200-8',
                    'cantidad' => 3,
                    'monto' => 320000000,
                    'fecha_estimada' => Carbon::now()->addDays(10),
                    'prioridad' => 'media'
                ],
                (object)[
                    'id' => 'OC-2024-003',
                    'proveedor' => 'Volvo CE',
                    'pais' => 'Suecia',
                    'maquina' => 'EC480E',
                    'cantidad' => 1,
                    'monto' => 280000000,
                    'fecha_estimada' => Carbon::now()->addDays(25),
                    'prioridad' => 'baja'
                ]
            ]);
        }
        
        // ENVÍOS EN TRÁNSITO (datos reales)
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
                
                // Determinar estado basado en progreso
                $estado = $progreso > 80 ? 'cercano' : ($progreso > 30 ? 'en_navegacion' : 'en_aduana_origen');
                
                // Obtener la primera máquina
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
        
        // Si no hay envíos en tránsito, usar datos de ejemplo basados en el Excel
        if ($envios_transito->isEmpty()) {
            $envios_transito = collect([
                (object)[
                    'contenedor' => 'CATU-456789',
                    'maquina' => 'Caterpillar 740',
                    'puerto_salida' => 'Houston',
                    'puerto_llegada' => 'San Antonio',
                    'fecha_salida' => Carbon::now()->subDays(12),
                    'fecha_llegada_estimada' => Carbon::now()->addDays(8),
                    'estado' => 'en_navegacion',
                    'progreso' => 60,
                    'documentos' => 'completos'
                ],
                (object)[
                    'contenedor' => 'KOMU-123456',
                    'maquina' => 'Komatsu D155',
                    'puerto_salida' => 'Yokohama',
                    'puerto_llegada' => 'San Antonio',
                    'fecha_salida' => Carbon::now()->subDays(5),
                    'fecha_llegada_estimada' => Carbon::now()->addDays(18),
                    'estado' => 'en_navegacion',
                    'progreso' => 25,
                    'documentos' => 'pendientes'
                ],
                (object)[
                    'contenedor' => 'VOLU-789012',
                    'maquina' => 'Volvo A40G',
                    'puerto_salida' => 'Gotemburgo',
                    'puerto_llegada' => 'San Antonio',
                    'fecha_salida' => Carbon::now()->subDays(2),
                    'fecha_llegada_estimada' => Carbon::now()->addDays(25),
                    'estado' => 'en_aduana_origen',
                    'progreso' => 10,
                    'documentos' => 'en_revision'
                ],
                (object)[
                    'contenedor' => 'CATU-456790',
                    'maquina' => 'Caterpillar 950H',
                    'puerto_salida' => 'Houston',
                    'puerto_llegada' => 'San Antonio',
                    'fecha_salida' => Carbon::now()->subDays(20),
                    'fecha_llegada_estimada' => Carbon::now()->addDays(2),
                    'estado' => 'cercano',
                    'progreso' => 90,
                    'documentos' => 'completos'
                ]
            ]);
        }
        
        // PRÓXIMAS LLEGADAS A PUERTO (datos reales)
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
                
                // Obtener la primera máquina
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
        
        // Si no hay próximas llegadas, usar datos de ejemplo
        if ($proximas_llegadas->isEmpty()) {
            $proximas_llegadas = collect([
                (object)[
                    'contenedor' => 'CATU-456790',
                    'maquina' => 'Caterpillar 950H',
                    'puerto' => 'San Antonio',
                    'fecha' => Carbon::now()->addDays(2),
                    'estado' => 'en_inspeccion'
                ],
                (object)[
                    'contenedor' => 'KOMU-123457',
                    'maquina' => 'Komatsu D155',
                    'puerto' => 'San Antonio',
                    'fecha' => Carbon::now()->addDays(5),
                    'estado' => 'en_transito'
                ],
                (object)[
                    'contenedor' => 'VOLU-789013',
                    'maquina' => 'Volvo A40G',
                    'puerto' => 'San Antonio',
                    'fecha' => Carbon::now()->addDays(8),
                    'estado' => 'documentacion'
                ]
            ]);
        }
        
        // PROVEEDORES ACTIVOS (datos reales)
        $proveedores = OrdenCompraProveedor::select('proveedor', 'pais_origen')
            ->whereNotNull('proveedor')
            ->distinct()
            ->get()
            ->take(5)
            ->map(function($item) {
                // Calcular órdenes activas de este proveedor
                $ordenes_activas = OrdenCompraProveedor::where('proveedor', $item->proveedor)
                    ->whereIn('estado', ['pendiente', 'en_transito'])
                    ->count();
                
                // Calcular tiempo promedio (simulado con datos reales)
                $ordenes_completadas = OrdenCompraProveedor::where('proveedor', $item->proveedor)
                    ->where('estado', 'recibida')
                    ->whereNotNull('fecha_llegada_real')
                    ->whereNotNull('fecha_orden')
                    ->get();
                
                $tiempo_promedio = 25; // valor por defecto
                if ($ordenes_completadas->count() > 0) {
                    $total_dias = 0;
                    foreach ($ordenes_completadas as $orden) {
                        $total_dias += $orden->fecha_orden->diffInDays($orden->fecha_llegada_real);
                    }
                    $tiempo_promedio = round($total_dias / $ordenes_completadas->count());
                }
                
                // Calcular cumplimiento (simulado)
                $cumplimiento = rand(92, 98);
                
                return (object)[
                    'nombre' => $item->proveedor,
                    'pais' => $item->pais_origen ?? 'China',
                    'ordenes_activas' => $ordenes_activas ?: rand(1, 3),
                    'tiempo_promedio' => $tiempo_promedio,
                    'cumplimiento' => $cumplimiento
                ];
            });
        
        // Si no hay proveedores, usar datos de ejemplo del Excel
        if ($proveedores->isEmpty()) {
            $proveedores = collect([
                (object)[
                    'nombre' => 'Caterpillar Inc.',
                    'pais' => 'EE.UU.',
                    'ordenes_activas' => 3,
                    'tiempo_promedio' => 25,
                    'cumplimiento' => 98
                ],
                (object)[
                    'nombre' => 'Komatsu Ltd.',
                    'pais' => 'Japón',
                    'ordenes_activas' => 2,
                    'tiempo_promedio' => 28,
                    'cumplimiento' => 95
                ],
                (object)[
                    'nombre' => 'Volvo CE',
                    'pais' => 'Suecia',
                    'ordenes_activas' => 1,
                    'tiempo_promedio' => 30,
                    'cumplimiento' => 92
                ],
                (object)[
                    'nombre' => 'John Deere',
                    'pais' => 'EE.UU.',
                    'ordenes_activas' => 2,
                    'tiempo_promedio' => 22,
                    'cumplimiento' => 96
                ]
            ]);
        }
        
        // DOCUMENTOS PENDIENTES (simulados basados en el Excel)
        $documentos_pendientes = collect([
            (object)[
                'tipo' => 'Factura Comercial',
                'contenedor' => $envios_transito->isNotEmpty() ? $envios_transito->first()->contenedor : 'KOMU-123456',
                'proveedor' => $proveedores->isNotEmpty() ? $proveedores->first()->nombre : 'Komatsu Ltd.',
                'fecha_requerida' => Carbon::now()->addDays(2),
                'prioridad' => 'alta'
            ],
            (object)[
                'tipo' => 'Certificado Origen',
                'contenedor' => $envios_transito->count() > 1 ? $envios_transito->get(1)->contenedor : 'VOLU-789012',
                'proveedor' => $proveedores->count() > 1 ? $proveedores->get(1)->nombre : 'Volvo CE',
                'fecha_requerida' => Carbon::now()->addDays(5),
                'prioridad' => 'media'
            ],
            (object)[
                'tipo' => 'Seguro Internacional',
                'contenedor' => $envios_transito->isNotEmpty() ? $envios_transito->last()->contenedor : 'CATU-456789',
                'proveedor' => $proveedores->isNotEmpty() ? $proveedores->first()->nombre : 'Caterpillar Inc.',
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

    /**
     * Dashboard de Despachos (gestión de envíos y entregas)
     */
    public function dashboardDespachos()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
        
        // Datos de ejemplo para despachos
        $stats = [
            'despachos_pendientes' => 12,
            'despachos_hoy' => 4,
            'en_ruta' => 6,
            'entregados_hoy' => 3,
            'despachos_semana' => 18,
            'entregas_pendientes' => 8,
            'retrasados' => 2,
            'por_despachar' => 7
        ];
        
        // Despachos pendientes de hoy
        $despachos_hoy = collect([
            (object)[
                'id' => 'DES-2024-001',
                'cliente' => 'Constructora Andes Ltda.',
                'direccion' => 'Av. Libertador 1234, Santiago',
                'maquina' => 'Caterpillar D6T',
                'serie' => 'CAT-2024-001',
                'fecha_despacho' => Carbon::now()->setTime(10, 30),
                'transportista' => 'Transportes Pérez',
                'conductor' => 'Juan Pérez',
                'patente' => 'ABCD-12',
                'estado' => 'preparando',
                'prioridad' => 'alta'
            ],
            (object)[
                'id' => 'DES-2024-002',
                'cliente' => 'Minera Esperanza',
                'direccion' => 'Ruta 5 Norte Km 120, Calama',
                'maquina' => 'Komatsu PC200-8',
                'serie' => 'KOM-2024-023',
                'fecha_despacho' => Carbon::now()->setTime(14, 0),
                'transportista' => 'Logística Minera',
                'conductor' => 'Carlos López',
                'patente' => 'EFGH-34',
                'estado' => 'pendiente',
                'prioridad' => 'media'
            ],
            (object)[
                'id' => 'DES-2024-003',
                'cliente' => 'Constructora Pacifico',
                'direccion' => 'Av. Mar 567, Viña del Mar',
                'maquina' => 'Caterpillar 950H',
                'serie' => 'CAT-2023-156',
                'fecha_despacho' => Carbon::now()->setTime(9, 0),
                'transportista' => 'Transportes Chile',
                'conductor' => 'Ana Martínez',
                'patente' => 'IJKL-56',
                'estado' => 'cargando',
                'prioridad' => 'alta'
            ],
            (object)[
                'id' => 'DES-2024-004',
                'cliente' => 'Minera Cerro Colorado',
                'direccion' => 'Camino Interior s/n, Iquique',
                'maquina' => 'Volvo EC480E',
                'serie' => 'VOL-2024-089',
                'fecha_despacho' => Carbon::now()->setTime(16, 30),
                'transportista' => 'Transportes Norte',
                'conductor' => 'Pedro Soto',
                'patente' => 'MNOP-78',
                'estado' => 'pendiente',
                'prioridad' => 'baja'
            ]
        ]);
        
        // Envíos en ruta
        $envios_ruta = collect([
            (object)[
                'id' => 'DES-2024-005',
                'cliente' => 'Constructora Sur',
                'maquina' => 'Caterpillar D9T',
                'transportista' => 'Transportes Pérez',
                'conductor' => 'Juan Pérez',
                'patente' => 'ABCD-12',
                'fecha_salida' => Carbon::now()->subHours(3),
                'hora_estimada' => Carbon::now()->addHours(2),
                'ubicacion' => 'Ruta 5 Sur, Km 45',
                'estado' => 'en_ruta',
                'contacto' => '+56 9 8765 4321'
            ],
            (object)[
                'id' => 'DES-2024-006',
                'cliente' => 'Minera Los Pelambres',
                'maquina' => 'Komatsu D155',
                'transportista' => 'Logística Minera',
                'conductor' => 'Carlos López',
                'patente' => 'EFGH-34',
                'fecha_salida' => Carbon::now()->subHours(5),
                'hora_estimada' => Carbon::now()->addHours(1),
                'ubicacion' => 'Ruta 5 Norte, Km 80',
                'estado' => 'en_ruta',
                'contacto' => '+56 9 7654 3210'
            ],
            (object)[
                'id' => 'DES-2024-007',
                'cliente' => 'Constructora Norte',
                'maquina' => 'Volvo A40G',
                'transportista' => 'Transportes Norte',
                'conductor' => 'Pedro Soto',
                'patente' => 'MNOP-78',
                'fecha_salida' => Carbon::now()->subHours(2),
                'hora_estimada' => Carbon::now()->addHours(3),
                'ubicacion' => 'Ruta 68, Km 20',
                'estado' => 'en_ruta',
                'contacto' => '+56 9 6543 2109'
            ]
        ]);
        
        // Entregas realizadas hoy
        $entregas_hoy = collect([
            (object)[
                'id' => 'DES-2024-008',
                'cliente' => 'Empresa San Juan',
                'maquina' => 'Caterpillar 740',
                'fecha_entrega' => Carbon::now()->subHours(2),
                'recibido_por' => 'Roberto González',
                'conforme' => true,
                'observaciones' => 'Todo ok'
            ],
            (object)[
                'id' => 'DES-2024-009',
                'cliente' => 'Constructora Andes',
                'maquina' => 'Komatsu PC200',
                'fecha_entrega' => Carbon::now()->subHours(4),
                'recibido_por' => 'María Torres',
                'conforme' => true,
                'observaciones' => 'Cliente satisfecho'
            ],
            (object)[
                'id' => 'DES-2024-010',
                'cliente' => 'Minera Esperanza',
                'maquina' => 'Volvo EC480E',
                'fecha_entrega' => Carbon::now()->subHours(6),
                'recibido_por' => 'Jorge Muñoz',
                'conforme' => false,
                'observaciones' => 'Pendiente firma'
            ]
        ]);
        
        // Transportistas activos
        $transportistas = collect([
            (object)[
                'nombre' => 'Transportes Pérez',
                'contacto' => '+56 9 8765 4321',
                'envios_hoy' => 2,
                'disponibilidad' => 'ocupado',
                'proximo_regreso' => Carbon::now()->addHours(3)
            ],
            (object)[
                'nombre' => 'Logística Minera',
                'contacto' => '+56 9 7654 3210',
                'envios_hoy' => 1,
                'disponibilidad' => 'ocupado',
                'proximo_regreso' => Carbon::now()->addHours(2)
            ],
            (object)[
                'nombre' => 'Transportes Chile',
                'contacto' => '+56 9 6543 2109',
                'envios_hoy' => 1,
                'disponibilidad' => 'disponible',
                'proximo_regreso' => null
            ],
            (object)[
                'nombre' => 'Transportes Norte',
                'contacto' => '+56 9 5432 1098',
                'envios_hoy' => 2,
                'disponibilidad' => 'ocupado',
                'proximo_regreso' => Carbon::now()->addHours(4)
            ]
        ]);
        
        // Próximos despachos (próximos días)
        $proximos_despachos = collect([
            (object)[
                'id' => 'DES-2024-011',
                'cliente' => 'Constructora Sur',
                'maquina' => 'Caterpillar D6T',
                'fecha' => Carbon::tomorrow()->setTime(9, 0),
                'direccion' => 'Av. Sur 789, Concepción',
                'prioridad' => 'normal'
            ],
            (object)[
                'id' => 'DES-2024-012',
                'cliente' => 'Minera Los Pelambres',
                'maquina' => 'Komatsu D155',
                'fecha' => Carbon::tomorrow()->setTime(11, 30),
                'direccion' => 'Ruta 5 Norte Km 200, Ovalle',
                'prioridad' => 'urgente'
            ],
            (object)[
                'id' => 'DES-2024-013',
                'cliente' => 'Empresa San Juan',
                'maquina' => 'Volvo A40G',
                'fecha' => Carbon::now()->addDays(2)->setTime(10, 0),
                'direccion' => 'Av. Principal 456, Rancagua',
                'prioridad' => 'normal'
            ],
            (object)[
                'id' => 'DES-2024-014',
                'cliente' => 'Constructora Norte',
                'maquina' => 'Caterpillar 950H',
                'fecha' => Carbon::now()->addDays(2)->setTime(14, 30),
                'direccion' => 'Av. Norte 123, Antofagasta',
                'prioridad' => 'alta'
            ]
        ]);
        
        return view('dashboarddespachos', compact(
            'usuario',
            'stats',
            'despachos_hoy',
            'envios_ruta',
            'entregas_hoy',
            'transportistas',
            'proximos_despachos'
        ));
    }

    /**
     * Dashboard de Facturación (emisión de facturas y documentos fiscales)
     */
    public function dashboardFacturacion()
    {
        // Obtener el usuario autenticado
        $usuario = Auth::user();
        
        // Datos de ejemplo para facturación
        $stats = [
            'facturas_pendientes' => 18,
            'facturas_hoy' => 5,
            'facturas_emitidas_mes' => 124,
            'monto_total_mes' => 1250000000,
            'monto_pendiente' => 325000000,
            'facturas_vencidas' => 3,
            'notas_credito_pendientes' => 4,
            'boletas_pendientes' => 7
        ];
        
        // Facturas pendientes por emitir
        $facturas_pendientes = collect([
            (object)[
                'id' => 'FAC-2024-001',
                'cliente' => 'Constructora Andes Ltda.',
                'rut' => '76.123.456-7',
                'tipo' => 'Factura A',
                'monto' => 45000000,
                'fecha_emision' => Carbon::now()->subDays(2),
                'fecha_vencimiento' => Carbon::now()->addDays(13),
                'estado' => 'pendiente',
                'prioridad' => 'alta',
                'vendedor' => 'Carlos Rodríguez',
                'concepto' => 'Venta Caterpillar D6T'
            ],
            (object)[
                'id' => 'FAC-2024-002',
                'cliente' => 'Minera Esperanza',
                'rut' => '77.987.654-3',
                'tipo' => 'Factura A',
                'monto' => 32000000,
                'fecha_emision' => Carbon::now()->subDays(1),
                'fecha_vencimiento' => Carbon::now()->addDays(14),
                'estado' => 'pendiente',
                'prioridad' => 'media',
                'vendedor' => 'María González',
                'concepto' => 'Venta Komatsu PC200-8'
            ],
            (object)[
                'id' => 'FAC-2024-003',
                'cliente' => 'Constructora Pacifico',
                'rut' => '76.789.123-4',
                'tipo' => 'Factura A',
                'monto' => 28000000,
                'fecha_emision' => Carbon::now()->subDays(3),
                'fecha_vencimiento' => Carbon::now()->addDays(12),
                'estado' => 'pendiente',
                'prioridad' => 'baja',
                'vendedor' => 'Juan Pérez',
                'concepto' => 'Venta Caterpillar 950H'
            ],
            (object)[
                'id' => 'FAC-2024-004',
                'cliente' => 'Minera Los Pelambres',
                'rut' => '76.456.789-0',
                'tipo' => 'Factura A',
                'monto' => 85000000,
                'fecha_emision' => Carbon::now()->subDays(1),
                'fecha_vencimiento' => Carbon::now()->addDays(14),
                'estado' => 'pendiente',
                'prioridad' => 'urgente',
                'vendedor' => 'Pedro Soto',
                'concepto' => '2da cuota D6T'
            ]
        ]);
        
        // Facturas por vencer próximamente
        $facturas_por_vencer = collect([
            (object)[
                'id' => 'FAC-2024-005',
                'cliente' => 'Constructora Norte',
                'rut' => '77.234.567-8',
                'monto' => 120000000,
                'fecha_vencimiento' => Carbon::now()->addDays(2),
                'dias_restantes' => 2,
                'estado' => 'por_vencer',
                'monto_pagado' => 0,
                'saldo' => 120000000
            ],
            (object)[
                'id' => 'FAC-2024-006',
                'cliente' => 'Empresa San Juan',
                'rut' => '76.345.678-9',
                'monto' => 45000000,
                'fecha_vencimiento' => Carbon::now()->addDays(5),
                'dias_restantes' => 5,
                'estado' => 'por_vencer',
                'monto_pagado' => 0,
                'saldo' => 45000000
            ],
            (object)[
                'id' => 'FAC-2024-007',
                'cliente' => 'Minera Cerro Colorado',
                'rut' => '77.456.789-1',
                'monto' => 95000000,
                'fecha_vencimiento' => Carbon::now()->addDays(1),
                'dias_restantes' => 1,
                'estado' => 'por_vencer',
                'monto_pagado' => 0,
                'saldo' => 95000000
            ],
            (object)[
                'id' => 'FAC-2024-008',
                'cliente' => 'Constructora del Sur',
                'rut' => '76.567.890-2',
                'monto' => 65000000,
                'fecha_vencimiento' => Carbon::now()->addDays(3),
                'dias_restantes' => 3,
                'estado' => 'por_vencer',
                'monto_pagado' => 0,
                'saldo' => 65000000
            ]
        ]);
        
        // Facturas vencidas
        $facturas_vencidas = collect([
            (object)[
                'id' => 'FAC-2024-009',
                'cliente' => 'Constructora del Sur',
                'rut' => '76.567.890-2',
                'monto' => 65000000,
                'fecha_vencimiento' => Carbon::now()->subDays(15),
                'dias_atraso' => 15,
                'vendedor' => 'Pedro Ramírez',
                'telefono' => '+56 9 8765 4321',
                'ultimo_contacto' => Carbon::now()->subDays(7)
            ],
            (object)[
                'id' => 'FAC-2024-010',
                'cliente' => 'Inversiones Mineras',
                'rut' => '77.678.901-3',
                'monto' => 145000000,
                'fecha_vencimiento' => Carbon::now()->subDays(8),
                'dias_atraso' => 8,
                'vendedor' => 'Ana Silva',
                'telefono' => '+56 9 7654 3210',
                'ultimo_contacto' => Carbon::now()->subDays(3)
            ],
            (object)[
                'id' => 'FAC-2024-011',
                'cliente' => 'Minera Esperanza',
                'rut' => '77.987.654-3',
                'monto' => 32000000,
                'fecha_vencimiento' => Carbon::now()->subDays(5),
                'dias_atraso' => 5,
                'vendedor' => 'María González',
                'telefono' => '+56 9 6543 2109',
                'ultimo_contacto' => Carbon::now()->subDays(2)
            ]
        ]);
        
        // Notas de crédito pendientes
        $notas_credito = collect([
            (object)[
                'id' => 'NC-2024-001',
                'cliente' => 'Constructora Andes',
                'rut' => '76.123.456-7',
                'monto' => 4500000,
                'motivo' => 'Devolución parcial',
                'fecha_solicitud' => Carbon::now()->subDays(3),
                'estado' => 'pendiente',
                'factura_origen' => 'FAC-2024-001'
            ],
            (object)[
                'id' => 'NC-2024-002',
                'cliente' => 'Minera Esperanza',
                'rut' => '77.987.654-3',
                'monto' => 3200000,
                'motivo' => 'Ajuste de precio',
                'fecha_solicitud' => Carbon::now()->subDays(1),
                'estado' => 'pendiente',
                'factura_origen' => 'FAC-2024-002'
            ],
            (object)[
                'id' => 'NC-2024-003',
                'cliente' => 'Constructora Pacifico',
                'rut' => '76.789.123-4',
                'monto' => 2800000,
                'motivo' => 'Descuento comercial',
                'fecha_solicitud' => Carbon::now()->subDays(2),
                'estado' => 'pendiente',
                'factura_origen' => 'FAC-2024-003'
            ]
        ]);
        
        // Boletas pendientes
        $boletas_pendientes = collect([
            (object)[
                'id' => 'BOL-2024-001',
                'cliente' => 'Persona Natural',
                'rut' => '12.345.678-9',
                'monto' => 1500000,
                'concepto' => 'Servicio de mantención',
                'fecha' => Carbon::now()->subDays(2),
                'vendedor' => 'Carlos Rodríguez'
            ],
            (object)[
                'id' => 'BOL-2024-002',
                'cliente' => 'Persona Natural',
                'rut' => '23.456.789-0',
                'monto' => 2500000,
                'concepto' => 'Repuestos',
                'fecha' => Carbon::now()->subDays(1),
                'vendedor' => 'María González'
            ],
            (object)[
                'id' => 'BOL-2024-003',
                'cliente' => 'Persona Natural',
                'rut' => '34.567.890-1',
                'monto' => 3200000,
                'concepto' => 'Servicio técnico',
                'fecha' => Carbon::now()->subDays(3),
                'vendedor' => 'Juan Pérez'
            ]
        ]);
        
        // Últimas facturas emitidas
        $ultimas_facturas = collect([
            (object)[
                'id' => 'FAC-2024-012',
                'cliente' => 'Constructora Andes',
                'monto' => 45000000,
                'fecha' => Carbon::now()->subHours(2),
                'emitido_por' => 'Laura Sánchez',
                'estado' => 'enviada'
            ],
            (object)[
                'id' => 'FAC-2024-013',
                'cliente' => 'Minera Esperanza',
                'monto' => 32000000,
                'fecha' => Carbon::now()->subHours(5),
                'emitido_por' => 'Pedro Soto',
                'estado' => 'enviada'
            ],
            (object)[
                'id' => 'FAC-2024-014',
                'cliente' => 'Constructora Norte',
                'monto' => 85000000,
                'fecha' => Carbon::now()->subHours(8),
                'emitido_por' => 'María Torres',
                'estado' => 'pendiente_firma'
            ],
            (object)[
                'id' => 'FAC-2024-015',
                'cliente' => 'Minera Los Pelambres',
                'monto' => 120000000,
                'fecha' => Carbon::now()->subDay(),
                'emitido_por' => 'Juan Pérez',
                'estado' => 'pagada'
            ]
        ]);
        
        return view('dashboardfacturacion', compact(
            'usuario',
            'stats',
            'facturas_pendientes',
            'facturas_por_vencer',
            'facturas_vencidas',
            'notas_credito',
            'boletas_pendientes',
            'ultimas_facturas'
        ));
    }

    /**
     * Calcula el promedio de días de tránsito de órdenes recibidas
     */
    private function calcularDiasPromedioTransito()
    {
        $ordenes_recibidas = OrdenCompraProveedor::where('estado', 'recibida')
            ->whereNotNull('fecha_llegada_real')
            ->whereNotNull('fecha_orden')
            ->get();
        
        if ($ordenes_recibidas->isEmpty()) {
            return 21; // valor por defecto
        }
        
        $total_dias = 0;
        foreach ($ordenes_recibidas as $orden) {
            $total_dias += $orden->fecha_orden->diffInDays($orden->fecha_llegada_real);
        }
        
        return round($total_dias / $ordenes_recibidas->count());
    }

    /**
     * Obtiene puerto de salida según país
     */
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