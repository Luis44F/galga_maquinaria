<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\OrdenCompraProveedor;
use App\Models\Venta;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard principal (admin/gerencia)
     */
    public function index()
    {
        $usuario = Auth::user();

        // Estadísticas generales
        $stats = [
            'maquinas_disponibles' => Maquina::where('estado', 'disponible')->count(),
            'maquinas_en_transito' => Maquina::where('estado', 'en_transito')->count(),
            'ordenes_pendientes' => Maquina::where('estado', 'orden_pendiente')->count(),
            'ventas_mes' => Venta::whereMonth('fecha_venta', now()->month)->count(),
            'clientes_nuevos_mes' => Cliente::whereMonth('created_at', now()->month)->count(),
            'valor_inventario' => Maquina::whereIn('estado', ['disponible', 'en_bodega'])->sum('precio_compra'),
        ];

        // Últimas máquinas ingresadas
        $ultimas_maquinas = Maquina::with('modelo')
            ->latest()
            ->take(10)
            ->get();

        // Próximas llegadas
        $proximas_llegadas = OrdenCompraProveedor::with('creador')
            ->whereIn('estado', ['pendiente', 'en_transito'])
            ->whereNotNull('fecha_estimada_llegada')
            ->orderBy('fecha_estimada_llegada')
            ->take(5)
            ->get();

        // Máquinas por estado (para gráfico)
        $maquinas_por_estado = Maquina::select('estado', \DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();

        return view('dashboard.principal', compact(
            'usuario',
            'stats',
            'ultimas_maquinas',
            'proximas_llegadas',
            'maquinas_por_estado'
        ));
    }

    /**
     * Dashboard de Importaciones
     */
    public function importaciones()
    {
        $usuario = Auth::user();

        $stats = [
            'ordenes_pendientes' => OrdenCompraProveedor::where('estado', 'pendiente')->count(),
            'en_transito' => OrdenCompraProveedor::where('estado', 'en_transito')->count(),
            'llegadas_este_mes' => OrdenCompraProveedor::whereMonth('fecha_estimada_llegada', now()->month)->count(),
            'recibidas_mes' => OrdenCompraProveedor::whereMonth('fecha_llegada_real', now()->month)->count(),
        ];

        $ordenes_recientes = OrdenCompraProveedor::with('creador')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.importaciones', compact('usuario', 'stats', 'ordenes_recientes'));
    }

    /**
     * Dashboard de Ventas (vendedores)
     */
    public function ventas()
    {
        $usuario = Auth::user();
        $vendedorId = $usuario->id; // Asumiendo que el usuario es un vendedor

        $stats = [
            'mis_ventas_mes' => Venta::where('vendedor_id', $vendedorId)
                ->whereMonth('fecha_venta', now()->month)
                ->count(),
            'total_vendido_mes' => Venta::where('vendedor_id', $vendedorId)
                ->whereMonth('fecha_venta', now()->month)
                ->sum('precio_total'),
            'clientes_nuevos' => Cliente::whereMonth('created_at', now()->month)->count(),
            'disponibles' => Maquina::where('estado', 'disponible')->count(),
            'en_transito' => Maquina::where('estado', 'en_transito')->count(),
        ];

        $ultimas_ventas = Venta::with('cliente')
            ->where('vendedor_id', $vendedorId)
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.ventas', compact('usuario', 'stats', 'ultimas_ventas'));
    }
}