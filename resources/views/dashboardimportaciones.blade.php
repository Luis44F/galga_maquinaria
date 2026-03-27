<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>GALGA · Dashboard Importaciones</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <style>
        /* ========== ESTILOS COMPLETOS ========== */
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
            position: relative;
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
            transition: transform 0.3s ease;
            z-index: 1000;
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
            flex-shrink: 0;
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
            word-break: break-word;
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
            flex-shrink: 0;
        }

        .nav-item span {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .nav-item:hover, .nav-item.active {
            background: var(--primary);
            color: #0a0f1c;
        }

        .mobile-menu-btn {
            display: none;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1001;
            background: var(--primary);
            color: #0a0f1c;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 20px;
        }

        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 24px 32px;
            transition: margin-left 0.3s ease;
            width: calc(100% - 280px);
        }

        /* Header */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
            flex-wrap: wrap;
            gap: 20px;
        }

        .header-title h1 {
            font-size: clamp(24px, 5vw, 28px);
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
            flex-wrap: wrap;
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
            max-width: 100%;
        }

        .search-box i {
            color: var(--text-dim);
            flex-shrink: 0;
        }

        .search-box input {
            background: none;
            border: none;
            color: var(--text-light);
            width: 100%;
            outline: none;
        }

        .btn-primary, .btn-success, .btn-outline-secondary {
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            border: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--primary);
            color: #0a0f1c;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-success {
            background: var(--success);
            color: #0a0f1c;
        }

        .btn-success:hover {
            background: #0d9668;
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
        }

        .btn-outline-secondary:hover {
            background: var(--card-border);
            color: var(--text-light);
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
            flex-shrink: 0;
        }

        .stat-icon.warning {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .stat-icon.info {
            background: rgba(14, 165, 233, 0.2);
            color: var(--primary);
        }

        .stat-icon.success {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .stat-icon.primary {
            background: rgba(59, 130, 246, 0.2);
            color: var(--info);
        }

        .stat-label {
            color: var(--text-dim);
            font-size: 14px;
        }

        .stat-value {
            font-size: clamp(24px, 5vw, 32px);
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 4px;
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
            overflow: hidden;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .card-title {
            font-weight: 600;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 8px;
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

        /* Tables */
        .table-responsive {
            overflow-x: auto;
            margin: 0 -24px;
            padding: 0 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }

        th {
            text-align: left;
            padding: 12px 16px;
            background: rgba(14, 165, 233, 0.05);
            color: var(--text-dim);
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
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

        /* Buttons */
        .btn-sm {
            padding: 6px 12px;
            border-radius: 8px;
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-sm:hover {
            background: var(--primary);
            color: #0a0f1c;
            border-color: var(--primary);
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
            flex-wrap: wrap;
            gap: 8px;
        }

        .shipment-id {
            font-weight: 600;
            color: var(--primary);
            word-break: break-word;
        }

        /* Alerts */
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            align-items: center;
            justify-content: center;
            z-index: 2000;
            padding: 20px;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 24px;
            max-width: 500px;
            width: 100%;
        }

        /* Forms */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            color: var(--text-dim);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: var(--dark-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            color: var(--text-light);
            font-size: 14px;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }

        /* Maquinaria Cards */
        .maquinaria-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 24px;
        }

        .maquinaria-stat-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 20px;
        }

        .maquinaria-stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .maquinaria-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .maquinaria-stat-value {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-light);
        }

        .filtros-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .filtros-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 16px;
        }

        /* Toggle de grupos */
        .toggle-grupo {
            display: none;
        }

        .grupo-fila {
            display: none;
        }

        .grupo-header {
            cursor: pointer;
            transition: background 0.2s;
        }

        .grupo-header:hover {
            background: rgba(14, 165, 233, 0.1) !important;
        }

        .icono {
            display: inline-block;
            transition: transform 0.2s ease;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid, .maquinaria-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .two-column-grid {
                grid-template-columns: 1fr;
            }
            .shipment-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .main-content {
                padding: 20px;
            }
            .content-header {
                flex-direction: column;
                align-items: stretch;
            }
            .header-actions {
                justify-content: stretch;
            }
            .search-box {
                width: 100%;
            }
            .btn-primary, .btn-success {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .mobile-menu-btn {
                display: block;
            }
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.active {
                transform: translateX(0);
            }
            .main-content {
                margin-left: 0;
                width: 100%;
                padding-top: 80px;
            }
            .stats-grid, .maquinaria-stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 16px;
            }
            .stat-card, .maquinaria-stat-card, .card {
                padding: 16px;
            }
            .filtros-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <button class="mobile-menu-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="app-wrapper">
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <div class="logo-icon"><i class="fas fa-cog"></i></div>
                <span class="logo-text">GALGA</span>
            </div>

            <div class="sidebar-user">
                <div class="user-name">{{ $usuario->name }}</div>
                <span class="user-role">
                    @switch($usuario->rol)
                        @case('admin') Administrador @break
                        @case('vendedor') Vendedor @break
                        @case('cartera') Cartera @break
                        @case('importaciones') Importaciones @break
                        @case('despachos') Despachos @break
                        @case('facturacion') Facturación @break
                        @default {{ ucfirst($usuario->rol) }}
                    @endswitch
                </span>
            </div>

            <nav class="sidebar-nav">
                <a href="#" class="nav-item active" onclick="mostrarDashboard(); return false;">
                    <i class="fas fa-ship"></i> <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item" onclick="mostrarListaOrdenes(); return false;">
                    <i class="fas fa-file-invoice"></i> <span>Órdenes de Compra</span>
                </a>
                <a href="#" class="nav-item" onclick="mostrarMaquinariaDisponible(); return false;">
                    <i class="fas fa-cog"></i> <span>MAQUINARIA DISPONIBLE</span>
                </a>
                <a href="#" class="nav-item" onclick="mostrarProveedores(); return false;">
                    <i class="fas fa-building"></i> <span>Proveedores</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-file-pdf"></i> <span>Documentos</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-chart-line"></i> <span>Estadísticas</span>
                </a>
                <hr style="border-color: rgba(14,165,233,0.2); margin: 16px 0;">
                <a href="#" class="nav-item">
                    <i class="fas fa-cog"></i> <span>Configuración</span>
                </a>
                <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> <span>Salir</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
            </nav>
        </aside>

        <main class="main-content" id="mainContent">
            <div class="content-header">
                <div class="header-title">
                    <h1 id="pageTitle">Dashboard Importaciones</h1>
                    <p id="pageDescription">Gestión de compras internacionales y seguimiento de envíos</p>
                </div>
                <div class="header-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Buscar orden, máquina, proveedor..." id="searchInput">
                    </div>
                    <button class="btn-primary" onclick="mostrarFormularioCrear()">
                        <i class="fas fa-plus"></i> Nueva Orden
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success"><i class="fas fa-check-circle"></i><span>{{ session('success') }}</span></div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i><span>{{ session('error') }}</span></div>
            @endif

            <!-- Dashboard Section -->
            <div id="dashboardSection">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning"><i class="fas fa-clock"></i></div>
                            <span class="stat-label">Órdenes Pendientes</span>
                        </div>
                        <div class="stat-value">{{ $stats['ordenes_pendientes'] ?? 0 }}</div>
                        <div class="stat-trend"><i class="fas fa-exclamation-circle"></i> {{ $stats['ordenes_atrasadas'] ?? 0 }} atrasadas</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info"><i class="fas fa-ship"></i></div>
                            <span class="stat-label">En Tránsito</span>
                        </div>
                        <div class="stat-value">{{ $stats['en_transito'] ?? 0 }}</div>
                        <div class="stat-trend"><i class="fas fa-box"></i> {{ $stats['contenedores_activos'] ?? 0 }} contenedores</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success"><i class="fas fa-calendar-check"></i></div>
                            <span class="stat-label">Llegadas Mes</span>
                        </div>
                        <div class="stat-value">{{ $stats['llegadas_este_mes'] ?? 0 }}</div>
                        <div class="stat-trend"><i class="fas fa-clock"></i> Próxima en {{ $proximas_llegadas->first()->fecha->diffInDays(now()) ?? 2 }} días</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary"><i class="fas fa-dollar-sign"></i></div>
                            <span class="stat-label">Compras Mes</span>
                        </div>
                        <div class="stat-value">${{ number_format(($stats['monto_compras_mes'] ?? 1250000000) / 1000000, 0) }}M</div>
                        <div class="stat-trend"><i class="fas fa-building"></i> {{ $stats['proveedores_activos'] ?? 0 }} proveedores</div>
                    </div>
                </div>

                <div class="two-column-grid">
                    <!-- Órdenes Pendientes -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"><i class="fas fa-file-invoice"></i> Órdenes de Compra Pendientes</div>
                            <span class="badge badge-warning">{{ $ordenes_pendientes->count() ?? 0 }} pendientes</span>
                        </div>
                        <div class="table-responsive">
                             <table>
                                <thead>
                                    <tr><th>N° Orden</th><th>Proveedor</th><th>Modelo</th><th>Cant.</th><th>Monto</th><th>Fecha Est.</th><th>Prioridad</th><th></th></tr>
                                </thead>
                                <tbody>
                                    @forelse($ordenes_pendientes ?? [] as $orden)
                                    <tr>
                                        <td><strong>{{ $orden->numero_orden ?? $orden->id }}</strong><br><small>{{ $orden->pais }}</small></td>
                                        <td>{{ $orden->proveedor }}</td>
                                        <td>@if($orden->modelo_maquina)<strong>{{ $orden->modelo_maquina }}</strong>@else<span class="text-muted">No especificado</span>@endif</td>
                                        <td><span class="badge" style="background:rgba(14,165,233,0.2);color:var(--primary);">{{ $orden->cantidad_maquinas ?? 1 }}</span></td>
                                        <td>${{ number_format(($orden->monto ?? 0) / 1000000, 0) }}M</td>
                                        <td>{{ $orden->fecha_estimada ? $orden->fecha_estimada->format('d/m') : 'N/A' }}<br><small>en {{ max(0, $orden->fecha_estimada->diffInDays(now())) }} días</small></td>
                                        <td><span class="status-indicator status-{{ $orden->prioridad ?? 'media' }}"></span> {{ ucfirst($orden->prioridad ?? 'media') }}</td>
                                        <td><button class="btn-sm" onclick="verOrden({{ $orden->id }})"><i class="fas fa-eye"></i></button></td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="8" class="text-center">No hay órdenes pendientes</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3"><button onclick="mostrarListaOrdenes()" style="color:var(--primary);background:none;border:none;cursor:pointer;">Ver todas las órdenes →</button></div>
                    </div>

                    <!-- Envíos en Tránsito -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"><i class="fas fa-ship"></i> Envíos en Tránsito</div>
                            <span class="badge badge-info">{{ $envios_transito->count() ?? 0 }} activos</span>
                        </div>
                        <div class="shipment-grid">
                            @forelse($envios_transito ?? [] as $envio)
                            <div class="shipment-card">
                                <div class="shipment-header">
                                    <span class="shipment-id">{{ $envio->contenedor }}</span>
                                    <span class="badge badge-info">{{ str_replace('_', ' ', ucfirst($envio->estado ?? 'en_navegacion')) }}</span>
                                </div>
                                <div><strong>{{ $envio->maquina }}</strong></div>
                                <div class="shipment-route"><i class="fas fa-map-marker-alt"></i> {{ $envio->puerto_salida }} → {{ $envio->puerto_llegada }}</div>
                                <div class="progress-bar"><div class="progress-fill" style="width: {{ $envio->progreso }}%"></div></div>
                                <div><span>Progreso: {{ $envio->progreso }}%</span> <span>Docs: {{ $envio->documentos }}</span></div>
                            </div>
                            @empty
                            <div class="shipment-card text-center">No hay envíos en tránsito</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Próximas Llegadas -->
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="card-title"><i class="fas fa-calendar-alt"></i> Próximas Llegadas a Puerto</div>
                        <span class="badge badge-success">{{ $proximas_llegadas->count() ?? 0 }} próximas</span>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr><th>Contenedor</th><th>Máquina</th><th>Puerto</th><th>Fecha Llegada</th><th>Estado</th><th>Días</th><th></th></tr>
                            </thead>
                            <tbody>
                                @forelse($proximas_llegadas ?? [] as $llegada)
                                <tr>
                                    <td><strong>{{ $llegada->contenedor }}</strong></td>
                                    <td>{{ $llegada->maquina }}</td>
                                    <td>{{ $llegada->puerto ?? 'San Antonio' }}</td>
                                    <td>{{ $llegada->fecha->format('d/m/Y') }}</td>
                                    <td><span class="badge badge-success">{{ ucfirst($llegada->estado) }}</span></td>
                                    <td><strong>{{ max(0, $llegada->fecha->diffInDays(now())) }} días</strong></td>
                                    <td><button class="btn-sm" onclick="verOrden({{ str_replace('CONT-', '', $llegada->contenedor) }})"><i class="fas fa-clipboard-list"></i></button></td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center">No hay próximas llegadas</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Proveedores y Documentos -->
                <div class="two-column-grid">
                    <div class="card">
                        <div class="card-header"><div class="card-title"><i class="fas fa-building"></i> Proveedores Activos</div></div>
                        <div class="table-responsive">
                            <table>
                                <thead><tr><th>Proveedor</th><th>País</th><th>Órdenes</th><th>Tiempo Prom.</th><th>Cumplimiento</th></tr></thead>
                                <tbody>
                                    @forelse($proveedores ?? [] as $proveedor)
                                    <tr><td><strong>{{ $proveedor->nombre }}</strong></td><td>{{ $proveedor->pais ?? 'N/A' }}</td><td>{{ $proveedor->ordenes_activas ?? 0 }}</td><td>{{ $proveedor->tiempo_promedio ?? 0 }} días</td><td><span class="badge badge-success">{{ $proveedor->cumplimiento ?? 0 }}%</span></td></tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center">No hay proveedores</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header"><div class="card-title"><i class="fas fa-file-pdf"></i> Documentos Pendientes</div><span class="badge badge-danger">{{ $documentos_pendientes->count() ?? 0 }} pendientes</span></div>
                        <div>
                            @forelse($documentos_pendientes ?? [] as $doc)
                            <div style="display:flex;justify-content:space-between;padding:12px;border-bottom:1px solid var(--card-border);">
                                <div><i class="fas fa-file-pdf" style="color:var(--danger);"></i> <strong>{{ $doc->tipo }}</strong><br><small>{{ $doc->contenedor }} · {{ $doc->proveedor }}</small></div>
                                <div><span class="badge badge-warning">{{ ucfirst($doc->prioridad) }}</span><br><small>Requerido: {{ $doc->fecha_requerida->format('d/m') }}</small></div>
                            </div>
                            @empty
                            <div class="text-center p-4">No hay documentos pendientes</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Secciones ocultas -->
            <div id="listaOrdenesSection" style="display: none;"></div>
            <div id="formularioSection" style="display: none;"></div>
            <div id="verOrdenSection" style="display: none;"></div>

            <!-- Maquinaria Disponible -->
            <div id="maquinariaDisponibleSection" style="display: none;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:15px;">
                    <div><h2><i class="fas fa-cog"></i> MAQUINARIA DISPONIBLE</h2><p>Máquinas listas para venta en inventario</p></div>
                    <a href="{{ route('maquinas.create') }}" class="btn-success"><i class="fas fa-plus"></i> Registrar Máquina</a>
                </div>

                <div class="maquinaria-stats-grid">
                    <div class="maquinaria-stat-card"><div class="maquinaria-stat-header"><span>Disponibles</span><div class="maquinaria-stat-icon success"><i class="fas fa-check-circle"></i></div></div><div class="maquinaria-stat-value" id="stats-disponibles">0</div></div>
                    <div class="maquinaria-stat-card"><div class="maquinaria-stat-header"><span>En Camino</span><div class="maquinaria-stat-icon warning"><i class="fas fa-ship"></i></div></div><div class="maquinaria-stat-value" id="stats-camino">0</div></div>
                    <div class="maquinaria-stat-card"><div class="maquinaria-stat-header"><span>Reservadas</span><div class="maquinaria-stat-icon primary"><i class="fas fa-clock"></i></div></div><div class="maquinaria-stat-value" id="stats-reservadas">0</div></div>
                    <div class="maquinaria-stat-card"><div class="maquinaria-stat-header"><span>Vendidas</span><div class="maquinaria-stat-icon info"><i class="fas fa-chart-line"></i></div></div><div class="maquinaria-stat-value" id="stats-vendidas">0</div></div>
                </div>

                <div class="filtros-card">
                    <form id="maquinariaFiltrosForm" onsubmit="event.preventDefault(); cargarMaquinariaDisponible();">
                        <div class="filtros-grid">
                            <div><label class="form-label">Buscar</label><input type="text" class="form-control" id="buscarMaquina" placeholder="Modelo, marca, serie..."></div>
                            <div><label class="form-label">Marca</label><select class="form-control" id="filtroMarca"><option value="">Todas</option></select></div>
                            <div><label class="form-label">Precio Mín.</label><input type="number" class="form-control" id="precioMin" placeholder="0"></div>
                            <div><label class="form-label">Precio Máx.</label><input type="number" class="form-control" id="precioMax" placeholder="1000000"></div>
                            <div><button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filtrar</button><button type="button" class="btn-outline-secondary" onclick="limpiarFiltrosMaquinaria()"><i class="fas fa-undo"></i></button></div>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <th>ID</th><th>Máquina</th><th>Marca/Modelo</th><th>Año</th><th>Serie</th><th>Precio</th><th>Estado</th><th>Acciones</th>
                            </thead>
                            <tbody id="maquinariaTableBody">
                                <td colspan="8" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Proveedores -->
            <div id="proveedoresSection" style="display: none;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;flex-wrap:wrap;gap:15px;">
                    <div><h2><i class="fas fa-building"></i> PROVEEDORES</h2><p>Gestión de proveedores de maquinaria</p></div>
                    <a href="{{ route('proveedores.create') }}" class="btn-success"><i class="fas fa-plus"></i> Nuevo Proveedor</a>
                </div>

                <div class="filtros-card">
                    <form id="proveedoresFiltrosForm" onsubmit="event.preventDefault(); cargarListaProveedores();">
                        <div class="filtros-grid">
                            <div><label class="form-label">Buscar</label><input type="text" class="form-control" id="buscarProveedor" placeholder="Nombre, código, NIT, país..."></div>
                            <div><label class="form-label">Tipo</label><select class="form-control" id="filtroTipo"><option value="">Todos</option><option value="nacional">Nacional</option><option value="internacional">Internacional</option></select></div>
                            <div><label class="form-label">Estado</label><select class="form-control" id="filtroEstado"><option value="">Todos</option><option value="1">Activos</option><option value="0">Inactivos</option></select></div>
                            <div><button type="submit" class="btn-primary"><i class="fas fa-search"></i> Filtrar</button><button type="button" class="btn-outline-secondary" onclick="limpiarFiltrosProveedores()"><i class="fas fa-undo"></i></button></div>
                        </div>
                    </form>
                </div>

                <div class="card">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <th>Código</th><th>Nombre</th><th>NIT</th><th>País</th><th>Tipo</th><th>Contacto</th><th>Estado</th><th>Acciones</th>
                            </thead>
                            <tbody id="proveedoresTableBody">
                                <td colspan="8" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</td>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal -->
    <div class="modal" id="estadoModal">
        <div class="modal-content">
            <h2>Cambiar Estado</h2>
            <input type="hidden" id="maquinaId">
            <div class="form-group"><label class="form-label">Nuevo Estado</label><select class="form-control" id="nuevoEstado">
                <option value="disponible">📦 Disponible</option><option value="en_bodega">🏭 En Bodega</option><option value="en_transito">🚢 En Tránsito</option>
                <option value="en_puerto">⚓ En Puerto</option><option value="reparacion">🔧 En Reparación</option><option value="fabricacion">🏗️ En Fabricación</option>
                <option value="pendiente_despacho">⏳ Pendiente Despacho</option><option value="cancelado">❌ Cancelado</option><option value="vendida">💰 Vendida</option>
            </select></div>
            <div style="display:flex;gap:12px;justify-content:flex-end;"><button class="btn-outline-secondary" onclick="cerrarModal()">Cancelar</button><button class="btn-primary" onclick="cambiarEstadoMaquina()">Guardar</button></div>
        </div>
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';
        
        function toggleSidebar() { document.getElementById('sidebar').classList.toggle('active'); }
        
        document.addEventListener('click', function(e) {
            if(window.innerWidth <= 768) {
                const sidebar = document.getElementById('sidebar');
                const btn = document.querySelector('.mobile-menu-btn');
                if(!sidebar.contains(e.target) && !btn.contains(e.target)) sidebar.classList.remove('active');
            }
        });

        function verOrden(id) { if(id) window.location.href = '/importaciones/' + id; }

        function mostrarDashboard() {
            document.getElementById('dashboardSection').style.display = 'block';
            document.getElementById('listaOrdenesSection').style.display = 'none';
            document.getElementById('formularioSection').style.display = 'none';
            document.getElementById('verOrdenSection').style.display = 'none';
            document.getElementById('maquinariaDisponibleSection').style.display = 'none';
            document.getElementById('proveedoresSection').style.display = 'none';
            document.getElementById('pageTitle').innerText = 'Dashboard Importaciones';
            document.querySelectorAll('.nav-item').forEach(i=>i.classList.remove('active'));
            document.querySelectorAll('.nav-item')[0].classList.add('active');
            if(window.innerWidth<=768) document.getElementById('sidebar').classList.remove('active');
        }

        function mostrarListaOrdenes() {
            document.getElementById('dashboardSection').style.display = 'none';
            document.getElementById('listaOrdenesSection').style.display = 'block';
            document.getElementById('formularioSection').style.display = 'none';
            document.getElementById('verOrdenSection').style.display = 'none';
            document.getElementById('maquinariaDisponibleSection').style.display = 'none';
            document.getElementById('proveedoresSection').style.display = 'none';
            document.getElementById('pageTitle').innerText = 'Órdenes de Compra';
            document.querySelectorAll('.nav-item').forEach(i=>i.classList.remove('active'));
            document.querySelectorAll('.nav-item')[1].classList.add('active');
            cargarListaOrdenes();
            if(window.innerWidth<=768) document.getElementById('sidebar').classList.remove('active');
        }

        function mostrarMaquinariaDisponible() {
            document.getElementById('dashboardSection').style.display = 'none';
            document.getElementById('listaOrdenesSection').style.display = 'none';
            document.getElementById('formularioSection').style.display = 'none';
            document.getElementById('verOrdenSection').style.display = 'none';
            document.getElementById('maquinariaDisponibleSection').style.display = 'block';
            document.getElementById('proveedoresSection').style.display = 'none';
            document.getElementById('pageTitle').innerText = 'Maquinaria Disponible';
            document.querySelectorAll('.nav-item').forEach(i=>i.classList.remove('active'));
            document.querySelectorAll('.nav-item')[2].classList.add('active');
            cargarMaquinariaDisponible();
            cargarEstadisticasMaquinaria();
            cargarOpcionesFiltros();
            if(window.innerWidth<=768) document.getElementById('sidebar').classList.remove('active');
        }

        function mostrarProveedores() {
            document.getElementById('dashboardSection').style.display = 'none';
            document.getElementById('listaOrdenesSection').style.display = 'none';
            document.getElementById('formularioSection').style.display = 'none';
            document.getElementById('verOrdenSection').style.display = 'none';
            document.getElementById('maquinariaDisponibleSection').style.display = 'none';
            document.getElementById('proveedoresSection').style.display = 'block';
            document.getElementById('pageTitle').innerText = 'Proveedores';
            document.querySelectorAll('.nav-item').forEach(i=>i.classList.remove('active'));
            document.querySelectorAll('.nav-item')[3].classList.add('active');
            cargarListaProveedores();
            if(window.innerWidth<=768) document.getElementById('sidebar').classList.remove('active');
        }

        // ==================== FUNCIONES MAQUINARIA ====================
        
        function cargarEstadisticasMaquinaria() {
            fetch('/maquinaria-disponible/estadisticas',{headers:{'X-Requested-With':'XMLHttpRequest'}})
            .then(r=>r.json()).then(d=>{
                document.getElementById('stats-disponibles').textContent=d.disponibles||0;
                document.getElementById('stats-camino').textContent=d.en_camino||0;
                document.getElementById('stats-reservadas').textContent=d.reservadas||0;
                document.getElementById('stats-vendidas').textContent=d.vendidas||0;
            }).catch(()=>{
                document.getElementById('stats-disponibles').textContent='0';
                document.getElementById('stats-camino').textContent='0';
                document.getElementById('stats-reservadas').textContent='0';
                document.getElementById('stats-vendidas').textContent='0';
            });
        }

        function cargarOpcionesFiltros() {
            const marcasSelect=document.getElementById('filtroMarca');
            if(!marcasSelect) return;
            marcasSelect.innerHTML='<option value="">Todas</option>';
            fetch('/maquinaria-disponible?marcas=1',{headers:{'X-Requested-With':'XMLHttpRequest'}})
            .then(r=>r.json()).then(d=>{if(d.marcas) d.marcas.forEach(m=>{let o=document.createElement('option');o.value=m;o.textContent=m;marcasSelect.appendChild(o);});});
        }

        function cargarMaquinariaDisponible() {
            const tb=document.getElementById('maquinariaTableBody');
            if(!tb) return;
            tb.innerHTML='<tr><td colspan="8" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>';
            let url='/maquinaria-disponible';
            const p=new URLSearchParams();
            const buscar=document.getElementById('buscarMaquina')?.value;
            const marca=document.getElementById('filtroMarca')?.value;
            if(buscar) p.append('buscar',buscar);
            if(marca && marca!=='') p.append('marca',marca);
            if(p.toString()) url+='?'+p.toString();
            fetch(url,{headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}})
            .then(r=>r.json()).then(d=>{
                if(d.success&&d.html) {
                    tb.innerHTML=d.html;
                    setTimeout(() => inicializarToggles(), 100);
                } else tb.innerHTML='<tr><td colspan="8" class="text-center">Error</td></tr>';
            });
        }

        function limpiarFiltrosMaquinaria() {
            document.getElementById('buscarMaquina').value='';
            document.getElementById('filtroMarca').value='';
            document.getElementById('precioMin').value='';
            document.getElementById('precioMax').value='';
            cargarMaquinariaDisponible();
        }

        function cambiarEstadoMaquina(){
            const id=document.getElementById('maquinaId').value;
            const estado=document.getElementById('nuevoEstado').value;
            fetch(`/maquinaria-disponible/${id}/cambiar-estado`,{
                method:'POST',
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':csrfToken},
                body:JSON.stringify({estado:estado})
            })
            .then(r=>r.json()).then(d=>{
                if(d.success){
                    cerrarModal();
                    cargarMaquinariaDisponible();
                    cargarEstadisticasMaquinaria();
                    alert(d.message);
                } else alert(d.message);
            });
        }

        function eliminarMaquina(id){
            if(confirm('¿Eliminar?')){
                fetch(`/maquinas/${id}`,{method:'DELETE',headers:{'X-CSRF-TOKEN':csrfToken}})
                .then(()=>{
                    cargarMaquinariaDisponible();
                    cargarEstadisticasMaquinaria();
                });
            }
        }

        function reservarMaquina(id){
            if(confirm('¿Reservar?')){
                fetch(`/maquinaria-disponible/${id}/reservar`,{
                    method:'POST',
                    headers:{'X-CSRF-TOKEN':csrfToken}
                })
                .then(r=>r.json()).then(d=>{
                    if(d.success){
                        cargarMaquinariaDisponible();
                        cargarEstadisticasMaquinaria();
                        alert(d.message);
                    } else alert(d.message);
                });
            }
        }

        function venderMaquina(id){
            if(confirm('¿Vender?')){
                fetch(`/maquinaria-disponible/${id}/vender`,{
                    method:'POST',
                    headers:{'X-CSRF-TOKEN':csrfToken}
                })
                .then(r=>r.json()).then(d=>{
                    if(d.success){
                        cargarMaquinariaDisponible();
                        cargarEstadisticasMaquinaria();
                        alert(d.message);
                    } else alert(d.message);
                });
            }
        }

        function verMaquina(id){
            window.location.href = `/maquinas/${id}`;
        }

        function editarMaquina(id){
            window.location.href = `/maquinas/${id}/edit`;
        }

        function inicializarToggles() {
            const headers = document.querySelectorAll('.grupo-header');
            headers.forEach(header => {
                const checkbox = header.previousElementSibling;
                if(checkbox && checkbox.classList.contains('toggle-grupo')) {
                    header.addEventListener('click', function(e) {
                        if(e.target.tagName !== 'LABEL' && !e.target.closest('label')) {
                            checkbox.checked = !checkbox.checked;
                            let nextElement = header.nextElementSibling;
                            let filasGrupo = [];
                            while(nextElement && !nextElement.classList.contains('grupo-header')) {
                                if(nextElement.classList.contains('grupo-fila')) filasGrupo.push(nextElement);
                                nextElement = nextElement.nextElementSibling;
                            }
                            filasGrupo.forEach(fila => fila.style.display = checkbox.checked ? 'table-row' : 'none');
                            const icono = header.querySelector('.icono');
                            if(icono) icono.style.transform = checkbox.checked ? 'rotate(90deg)' : 'rotate(0deg)';
                        }
                    });
                    const label = header.querySelector('label');
                    if(label) {
                        label.addEventListener('click', function(e) {
                            e.stopPropagation();
                            checkbox.checked = !checkbox.checked;
                            let nextElement = header.nextElementSibling;
                            let filasGrupo = [];
                            while(nextElement && !nextElement.classList.contains('grupo-header')) {
                                if(nextElement.classList.contains('grupo-fila')) filasGrupo.push(nextElement);
                                nextElement = nextElement.nextElementSibling;
                            }
                            filasGrupo.forEach(fila => fila.style.display = checkbox.checked ? 'table-row' : 'none');
                            const icono = header.querySelector('.icono');
                            if(icono) icono.style.transform = checkbox.checked ? 'rotate(90deg)' : 'rotate(0deg)';
                        });
                    }
                }
            });
        }

        // ==================== FUNCIONES PROVEEDORES ====================
        
        function cargarListaProveedores() {
            const tb=document.getElementById('proveedoresTableBody');
            if(!tb) return;
            tb.innerHTML='<tr><td colspan="8" class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</td></tr>';
            let url='{{ route("proveedores.index") }}';
            const p=new URLSearchParams();
            const buscar=document.getElementById('buscarProveedor')?.value;
            const tipo=document.getElementById('filtroTipo')?.value;
            const estado=document.getElementById('filtroEstado')?.value;
            if(buscar) p.append('buscar',buscar);
            if(tipo && tipo!=='') p.append('tipo',tipo);
            if(estado!=='') p.append('activo',estado);
            if(p.toString()) url+='?'+p.toString();
            fetch(url,{headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}})
            .then(r=>r.json()).then(d=>{if(d.success&&d.html) tb.innerHTML=d.html; else tb.innerHTML='<tr><td colspan="8" class="text-center">Error</td></tr>';});
        }

        function limpiarFiltrosProveedores() {
            document.getElementById('buscarProveedor').value='';
            document.getElementById('filtroTipo').value='';
            document.getElementById('filtroEstado').value='';
            cargarListaProveedores();
        }

        function toggleActivoProveedor(id, activo) {
            if(confirm('¿Cambiar estado del proveedor?')) {
                fetch(`/proveedores/${id}/toggle-activo`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ activo: activo === 1 ? 0 : 1 })
                })
                .then(r => r.json())
                .then(d => {
                    if(d.success) {
                        cargarListaProveedores();
                        alert(d.message);
                    } else {
                        alert('Error al cambiar estado');
                    }
                })
                .catch(() => alert('Error en la petición'));
            }
        }

        // ==================== FUNCIONES ÓRDENES ====================
        
        function cargarListaOrdenes() {
            const ls=document.getElementById('listaOrdenesSection');
            ls.innerHTML='<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>';
            fetch('/importaciones',{headers:{'X-Requested-With':'XMLHttpRequest','Accept':'application/json'}})
            .then(r=>r.json()).then(d=>{if(d.success&&d.html) ls.innerHTML=d.html; else ls.innerHTML='<div class="text-center">No hay órdenes</div>';});
        }

        function mostrarFormularioCrear() {
            document.getElementById('dashboardSection').style.display='none';
            document.getElementById('listaOrdenesSection').style.display='none';
            document.getElementById('formularioSection').style.display='block';
            document.getElementById('verOrdenSection').style.display='none';
            document.getElementById('maquinariaDisponibleSection').style.display='none';
            document.getElementById('proveedoresSection').style.display='none';
            document.getElementById('pageTitle').innerText='Nueva Orden';
            const fs=document.getElementById('formularioSection');
            fs.innerHTML='<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>';
            fetch('/importaciones/create',{headers:{'X-Requested-With':'XMLHttpRequest'}}).then(r=>r.json()).then(d=>{if(d.success&&d.html) fs.innerHTML=d.html;});
        }

        function cerrarModal() { document.getElementById('estadoModal').classList.remove('active'); }
        function abrirModalEstado(id,estado){document.getElementById('maquinaId').value=id;document.getElementById('nuevoEstado').value=estado;document.getElementById('estadoModal').classList.add('active');}
        
        window.onclick=function(e){if(e.target===document.getElementById('estadoModal'))cerrarModal();}
    </script>
</body>
</html>