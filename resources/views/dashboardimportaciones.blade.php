<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Dashboard Importaciones</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #0a0f1c;
            color: #e2e8f0;
            min-height: 100vh;
        }

        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #38bdf8;
            --secondary: #2563eb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark-bg: #0a0f1c;
            --card-bg: #111827;
            --card-border: #1f2937;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --sidebar-bg: #0f172a;
        }

        /* Layout */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--sidebar-bg);
            border-right: 1px solid rgba(14, 165, 233, 0.1);
            padding: 24px 16px;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 12px 24px 12px;
            border-bottom: 1px solid rgba(14, 165, 233, 0.2);
            margin-bottom: 24px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(45deg);
        }

        .logo-icon i {
            transform: rotate(-45deg);
            color: #0a0f1c;
            font-size: 24px;
        }

        .logo-text {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Sidebar User Section */
        .sidebar-user {
            padding: 16px 12px;
            background: rgba(14, 165, 233, 0.1);
            border-radius: 16px;
            margin-bottom: 24px;
            border: 1px solid rgba(14, 165, 233, 0.2);
        }

        .user-name {
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 4px;
            font-size: 16px;
        }

        .user-role {
            font-size: 13px;
            color: var(--primary);
            background: rgba(14, 165, 233, 0.2);
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            color: var(--text-dim);
            text-decoration: none;
            transition: all 0.3s;
        }

        .nav-item i {
            width: 20px;
            font-size: 18px;
        }

        .nav-item:hover, .nav-item.active {
            background: var(--primary);
            color: #0a0f1c;
        }

        .nav-item.active {
            font-weight: 600;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 24px 32px;
        }

        /* Header */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 8px;
        }

        .header-title p {
            color: var(--text-dim);
            font-size: 15px;
        }

        .header-actions {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .search-box {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            width: 300px;
        }

        .search-box i {
            color: var(--text-dim);
        }

        .search-box input {
            background: none;
            border: none;
            color: var(--text-light);
            font-family: 'Inter', sans-serif;
            width: 100%;
            outline: none;
        }

        .search-box input::placeholder {
            color: var(--text-dim);
        }

        .btn-primary {
            background: var(--primary);
            color: #0a0f1c;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.5);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 24px;
            transition: all 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            border-color: var(--primary);
            box-shadow: 0 20px 40px -10px rgba(14, 165, 233, 0.3);
        }

        .stat-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .stat-icon.warning {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .stat-icon.success {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .stat-icon.info {
            background: rgba(14, 165, 233, 0.2);
            color: var(--primary);
        }

        .stat-icon.primary {
            background: rgba(59, 130, 246, 0.2);
            color: var(--info);
        }

        .stat-icon.danger {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .stat-label {
            color: var(--text-dim);
            font-size: 14px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .stat-trend {
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .text-warning {
            color: var(--warning);
        }

        .text-success {
            color: var(--success);
        }

        .text-info {
            color: var(--info);
        }

        .text-danger {
            color: var(--danger);
        }

        /* Two Column Layout */
        .two-column-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr;
            gap: 20px;
            margin-bottom: 32px;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 24px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-title {
            font-weight: 600;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title i {
            color: var(--primary);
        }

        .badge {
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .badge-info {
            background: rgba(14, 165, 233, 0.2);
            color: var(--primary);
        }

        .badge-danger {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .badge-primary {
            background: rgba(59, 130, 246, 0.2);
            color: var(--info);
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px 16px;
            background: rgba(14, 165, 233, 0.05);
            color: var(--text-dim);
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-light);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(14, 165, 233, 0.05);
        }

        /* Progress Bar */
        .progress-bar {
            height: 6px;
            background: var(--dark-bg);
            border-radius: 3px;
            overflow: hidden;
            margin: 8px 0;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary);
            border-radius: 3px;
        }

        .progress-fill.warning {
            background: var(--warning);
        }

        .progress-fill.success {
            background: var(--success);
        }

        /* Status Indicators */
        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 6px;
        }

        .status-alta {
            background: var(--danger);
        }

        .status-media {
            background: var(--warning);
        }

        .status-baja {
            background: var(--success);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-sm {
            padding: 6px 12px;
            border-radius: 8px;
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-sm:hover {
            background: var(--primary);
            color: #0a0f1c;
            border-color: var(--primary);
        }

        .btn-success {
            background: var(--success);
            color: #0a0f1c;
            border: none;
        }

        .btn-success:hover {
            background: #0d9668;
        }

        .btn-warning {
            background: var(--warning);
            color: #0a0f1c;
            border: none;
        }

        .btn-warning:hover {
            background: #e68a00;
        }

        .btn-info {
            background: var(--info);
            color: #0a0f1c;
            border: none;
        }

        .btn-info:hover {
            background: #2563eb;
        }

        /* Shipment Cards */
        .shipment-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-top: 16px;
        }

        .shipment-card {
            background: rgba(14, 165, 233, 0.05);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 16px;
        }

        .shipment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .shipment-id {
            font-weight: 600;
            color: var(--primary);
        }

        .shipment-route {
            font-size: 13px;
            color: var(--text-dim);
            margin-bottom: 8px;
        }

        .shipment-dates {
            font-size: 12px;
            color: var(--text-dim);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .two-column-grid {
                grid-template-columns: 1fr;
            }
            
            .shipment-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .header-actions {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="logo-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <span class="logo-text">GALGA</span>
            </div>

            <!-- Sidebar User Section con datos del usuario real -->
            <div class="sidebar-user">
                <div class="user-name">{{ $usuario->name }}</div>
                <span class="user-role">
                    @switch($usuario->rol)
                        @case('admin')
                            Administrador
                            @break
                        @case('vendedor')
                            Vendedor
                            @break
                        @case('cartera')
                            Cartera
                            @break
                        @case('importaciones')
                            Importaciones
                            @break
                        @case('despachos')
                            Despachos
                            @break
                        @case('facturacion')
                            Facturación
                            @break
                        @default
                            {{ ucfirst($usuario->rol) }}
                    @endswitch
                </span>
            </div>

            <nav class="sidebar-nav">
                <a href="#" class="nav-item active">
                    <i class="fas fa-ship"></i>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-file-invoice"></i>
                    Órdenes de Compra
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-box"></i>
                    Contenedores
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-truck"></i>
                    En Tránsito
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-building"></i>
                    Proveedores
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-file-pdf"></i>
                    Documentos
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-chart-line"></i>
                    Estadísticas
                </a>
                <hr style="border-color: rgba(14,165,233,0.2); margin: 16px 0;">
                <a href="#" class="nav-item">
                    <i class="fas fa-cog"></i>
                    Configuración
                </a>
                <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <div class="content-header">
                <div class="header-title">
                    <h1>Dashboard Importaciones</h1>
                    <p>Gestión de compras internacionales y seguimiento de envíos</p>
                </div>
                <div class="header-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Buscar orden, contenedor, proveedor...">
                    </div>
                    <button class="btn-primary">
                        <i class="fas fa-plus"></i>
                        Nueva Orden
                    </button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="stat-label">Órdenes Pendientes</span>
                    </div>
                    <div class="stat-value">{{ $stats['ordenes_pendientes'] }}</div>
                    <div class="stat-trend text-warning">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $stats['ordenes_atrasadas'] }} atrasadas
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon info">
                            <i class="fas fa-ship"></i>
                        </div>
                        <span class="stat-label">En Tránsito</span>
                    </div>
                    <div class="stat-value">{{ $stats['en_transito'] }}</div>
                    <div class="stat-trend text-info">
                        <i class="fas fa-box"></i>
                        {{ $stats['contenedores_activos'] }} contenedores
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <span class="stat-label">Llegadas Mes</span>
                    </div>
                    <div class="stat-value">{{ $stats['llegadas_este_mes'] }}</div>
                    <div class="stat-trend text-success">
                        <i class="fas fa-clock"></i>
                        Próxima en 2 días
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <span class="stat-label">Compras Mes</span>
                    </div>
                    <div class="stat-value">${{ number_format($stats['monto_compras_mes'] / 1000000, 0) }}M</div>
                    <div class="stat-trend text-info">
                        <i class="fas fa-building"></i>
                        {{ $stats['proveedores_activos'] }} proveedores
                    </div>
                </div>
            </div>

            <!-- Two Column Layout - Órdenes Pendientes y Envíos en Tránsito -->
            <div class="two-column-grid">
                <!-- Órdenes de Compra Pendientes -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-file-invoice" style="color: var(--warning);"></i>
                            Órdenes de Compra Pendientes
                        </div>
                        <span class="badge badge-warning">{{ count($ordenes_pendientes) }} pendientes</span>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>N° Orden</th>
                                    <th>Proveedor</th>
                                    <th>Máquina</th>
                                    <th>Cant.</th>
                                    <th>Monto</th>
                                    <th>Fecha Est.</th>
                                    <th>Prioridad</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($ordenes_pendientes as $orden)
                                <tr>
                                    <td><strong>{{ $orden->id }}</strong></td>
                                    <td>
                                        {{ $orden->proveedor }}<br>
                                        <small style="color: var(--text-dim);">{{ $orden->pais }}</small>
                                    </td>
                                    <td>{{ $orden->maquina }}</td>
                                    <td>{{ $orden->cantidad }}</td>
                                    <td>${{ number_format($orden->monto / 1000000, 0) }}M</td>
                                    <td>
                                        {{ $orden->fecha_estimada->format('d/m') }}<br>
                                        <small style="color: var(--text-dim);">en {{ $orden->fecha_estimada->diffInDays(now()) }} días</small>
                                    </td>
                                    <td>
                                        <span class="status-indicator status-{{ $orden->prioridad }}"></span>
                                        {{ ucfirst($orden->prioridad) }}
                                    </td>
                                    <td>
                                        <button class="btn-sm" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div style="margin-top: 16px; text-align: center;">
                        <a href="#" style="color: var(--primary); text-decoration: none;">Ver todas las órdenes →</a>
                    </div>
                </div>

                <!-- Envíos en Tránsito -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-ship" style="color: var(--info);"></i>
                            Envíos en Tránsito
                        </div>
                        <span class="badge badge-info">{{ count($envios_transito) }} activos</span>
                    </div>
                    <div class="shipment-grid">
                        @foreach($envios_transito as $envio)
                        <div class="shipment-card">
                            <div class="shipment-header">
                                <span class="shipment-id">{{ $envio->contenedor }}</span>
                                <span class="badge 
                                    @if($envio->estado == 'cercano') badge-success
                                    @elseif($envio->estado == 'en_aduana_origen') badge-warning
                                    @else badge-info
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($envio->estado)) }}
                                </span>
                            </div>
                            <div style="font-weight: 600; margin-bottom: 4px;">{{ $envio->maquina }}</div>
                            <div class="shipment-route">
                                <i class="fas fa-map-marker-alt"></i> {{ $envio->puerto_salida }} 
                                <i class="fas fa-arrow-right"></i> 
                                <i class="fas fa-anchor"></i> {{ $envio->puerto_llegada }}
                            </div>
                            <div class="shipment-dates">
                                <div>Salida: {{ $envio->fecha_salida->format('d/m') }}</div>
                                <div>Llega: {{ $envio->fecha_llegada_estimada->format('d/m') }}</div>
                            </div>
                            <div class="progress-bar" style="margin: 8px 0;">
                                <div class="progress-fill" style="width: {{ $envio->progreso }}%"></div>
                            </div>
                            <div style="display: flex; justify-content: space-between; font-size: 11px;">
                                <span>Progreso: {{ $envio->progreso }}%</span>
                                <span class="badge 
                                    @if($envio->documentos == 'completos') badge-success
                                    @elseif($envio->documentos == 'pendientes') badge-warning
                                    @else badge-info
                                    @endif">
                                    Docs: {{ $envio->documentos }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Próximas Llegadas a Puerto -->
            <div class="card" style="margin-bottom: 32px;">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-calendar-alt" style="color: var(--success);"></i>
                        Próximas Llegadas a Puerto
                    </div>
                    <span class="badge badge-success">{{ count($proximas_llegadas) }} próximas</span>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Contenedor</th>
                                <th>Máquina</th>
                                <th>Puerto</th>
                                <th>Fecha Llegada</th>
                                <th>Estado</th>
                                <th>Días Restantes</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proximas_llegadas as $llegada)
                            <tr>
                                <td><strong>{{ $llegada->contenedor }}</strong></td>
                                <td>{{ $llegada->maquina }}</td>
                                <td>{{ $llegada->puerto }}</td>
                                <td>{{ $llegada->fecha->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge 
                                        @if($llegada->estado == 'en_inspeccion') badge-warning
                                        @elseif($llegada->estado == 'documentacion') badge-info
                                        @else badge-success
                                        @endif">
                                        {{ ucfirst($llegada->estado) }}
                                    </span>
                                </td>
                                <td>
                                    <strong>{{ $llegada->fecha->diffInDays(now()) }} días</strong>
                                </td>
                                <td>
                                    <button class="btn-sm">
                                        <i class="fas fa-clipboard-list"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Two Column Layout - Proveedores y Documentos -->
            <div class="two-column-grid">
                <!-- Proveedores Activos -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-building" style="color: var(--primary);"></i>
                            Proveedores Activos
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Proveedor</th>
                                    <th>País</th>
                                    <th>Órdenes</th>
                                    <th>Tiempo Prom.</th>
                                    <th>Cumplimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proveedores as $proveedor)
                                <tr>
                                    <td><strong>{{ $proveedor->nombre }}</strong></td>
                                    <td>{{ $proveedor->pais }}</td>
                                    <td>{{ $proveedor->ordenes_activas }}</td>
                                    <td>{{ $proveedor->tiempo_promedio }} días</td>
                                    <td>
                                        <span class="badge badge-success">{{ $proveedor->cumplimiento }}%</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Documentos Pendientes -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-file-pdf" style="color: var(--danger);"></i>
                            Documentos Pendientes
                        </div>
                        <span class="badge badge-danger">{{ count($documentos_pendientes) }} pendientes</span>
                    </div>
                    <div>
                        @foreach($documentos_pendientes as $doc)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border-bottom: 1px solid var(--card-border);">
                            <div>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <i class="fas fa-file-pdf" style="color: var(--danger);"></i>
                                    <div>
                                        <strong>{{ $doc->tipo }}</strong><br>
                                        <small style="color: var(--text-dim);">{{ $doc->contenedor }} · {{ $doc->proveedor }}</small>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align: right;">
                                <span class="badge 
                                    @if($doc->prioridad == 'urgente') badge-danger
                                    @elseif($doc->prioridad == 'alta') badge-warning
                                    @else badge-info
                                    @endif">
                                    {{ ucfirst($doc->prioridad) }}
                                </span>
                                <div style="font-size: 11px; color: var(--text-dim); margin-top: 4px;">
                                    Requerido: {{ $doc->fecha_requerida->format('d/m') }}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Resumen de Importaciones -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 32px;">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-chart-pie"></i>
                            Orígenes de Importación
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>EE.UU.</span>
                                <span>45%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 45%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Japón</span>
                                <span>30%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 30%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Europa</span>
                                <span>15%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 15%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>China</span>
                                <span>10%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 10%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-clock"></i>
                            Tiempos de Tránsito
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>EE.UU.</span>
                                <span>18-22 días</span>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Japón</span>
                                <span>25-30 días</span>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Europa</span>
                                <span>28-35 días</span>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>China</span>
                                <span>20-25 días</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-bell"></i>
                            Alertas de Importación
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div style="padding: 12px; background: rgba(239, 68, 68, 0.1); border-radius: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-exclamation-triangle" style="color: var(--danger);"></i>
                                <div>
                                    <strong>Documentos pendientes</strong>
                                    <p style="font-size: 12px;">Contenedor KOMU-123456</p>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 12px; background: rgba(245, 158, 11, 0.1); border-radius: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-clock" style="color: var(--warning);"></i>
                                <div>
                                    <strong>Llegada próxima</strong>
                                    <p style="font-size: 12px;">CATU-456790 en 2 días</p>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 12px; background: rgba(16, 185, 129, 0.1); border-radius: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-check-circle" style="color: var(--success);"></i>
                                <div>
                                    <strong>Orden completada</strong>
                                    <p style="font-size: 12px;">OC-2024-004 lista para despacho</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Tabs functionality (si se necesita)
        document.querySelectorAll('.tab-item').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Búsqueda en tiempo real
        const searchInput = document.querySelector('.search-box input');
        if (searchInput) {
            searchInput.addEventListener('input', function(e) {
                console.log('Buscando:', e.target.value);
                // Aquí iría la lógica de búsqueda
            });
        }
    </script>
</body>
</html>