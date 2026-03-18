@php
    use App\Models\Maquina;
    $disponibles = Maquina::whereIn('estado', ['disponible', 'en_bodega'])->count();
    $enCamino = Maquina::whereIn('estado', ['en_transito', 'en_puerto'])->count();
    $reparacion = Maquina::where('estado', 'reparacion')->count();
    $fabricacion = Maquina::where('estado', 'fabricacion')->count();
    $pendienteDespacho = Maquina::where('estado', 'pendiente_despacho')->count();
    $cancelados = Maquina::where('estado', 'cancelado')->count();
    $vendidas = Maquina::where('estado', 'vendida')->count();
@endphp

<!-- Botón Volver -->
<div class="row mb-4">
    <div class="col-12">
        <a href="{{ route('dashboard.importaciones') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Volver al Dashboard
        </a>
    </div>
</div>

<div class="row">
    <!-- Disponibles -->
    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">
                            <i class="fas fa-check-circle me-1"></i>DISPONIBLE
                        </h6>
                        <h2 class="display-6 fw-bold mb-0">{{ $disponibles }}</h2>
                        <small class="text-white-50">Listas para venta</small>
                    </div>
                    <i class="fas fa-cog fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- En Camino -->
    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">
                            <i class="fas fa-ship me-1"></i>EN CAMINO
                        </h6>
                        <h2 class="display-6 fw-bold mb-0">{{ $enCamino }}</h2>
                        <small class="text-white-50">En tránsito / puerto</small>
                    </div>
                    <i class="fas fa-truck fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Reparación -->
    <div class="col-md-3">
        <div class="card bg-danger text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">
                            <i class="fas fa-tools me-1"></i>REPARACIÓN
                        </h6>
                        <h2 class="display-6 fw-bold mb-0">{{ $reparacion }}</h2>
                        <small class="text-white-50">En taller</small>
                    </div>
                    <i class="fas fa-wrench fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Fabricación -->
    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">
                            <i class="fas fa-industry me-1"></i>FABRICACIÓN
                        </h6>
                        <h2 class="display-6 fw-bold mb-0">{{ $fabricacion }}</h2>
                        <small class="text-white-50">En producción</small>
                    </div>
                    <i class="fas fa-cog fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendiente Despacho -->
    <div class="col-md-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">
                            <i class="fas fa-clock me-1"></i>PDTE. DESPACHO
                        </h6>
                        <h2 class="display-6 fw-bold mb-0">{{ $pendienteDespacho }}</h2>
                        <small class="text-white-50">Vendidas por despachar</small>
                    </div>
                    <i class="fas fa-truck-loading fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancelados -->
    <div class="col-md-3">
        <div class="card bg-secondary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">
                            <i class="fas fa-ban me-1"></i>CANCELADOS
                        </h6>
                        <h2 class="display-6 fw-bold mb-0">{{ $cancelados }}</h2>
                        <small class="text-white-50">Cancelados</small>
                    </div>
                    <i class="fas fa-times-circle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendidas -->
    <div class="col-md-3">
        <div class="card bg-secondary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-title text-white-50">
                            <i class="fas fa-chart-line me-1"></i>VENDIDAS
                        </h6>
                        <h2 class="display-6 fw-bold mb-0">{{ $vendidas }}</h2>
                        <small class="text-white-50">Histórico</small>
                    </div>
                    <i class="fas fa-dollar-sign fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>