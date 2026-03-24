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
        /* ... (todo tu CSS existente, sin cambios) ... */
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

        /* Sidebar - Adaptable */
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

        .nav-item.active {
            font-weight: 600;
        }

        /* Botón menú móvil */
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
            box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);
        }

        /* Main Content */
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
            font-family: 'Inter', sans-serif;
            width: 100%;
            outline: none;
            min-width: 0;
        }

        .search-box input::placeholder {
            color: var(--text-dim);
        }

        .btn-primary, .btn-success, .btn-warning, .btn-danger, .btn-info, .btn-outline-secondary {
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
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.5);
        }

        .btn-success {
            background: var(--success);
            color: #0a0f1c;
        }

        .btn-success:hover {
            background: #0d9668;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: var(--warning);
            color: #0a0f1c;
        }

        .btn-warning:hover {
            background: #e68a00;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
        }

        .btn-info {
            background: var(--info);
            color: white;
        }

        .btn-info:hover {
            background: #2563eb;
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

        /* Stats Cards - Adaptables */
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
            flex-shrink: 0;
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
            font-size: clamp(24px, 5vw, 32px);
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .stat-trend {
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 4px;
            flex-wrap: wrap;
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

        /* Two Column Layout - Adaptable */
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

        /* Tables - Adaptables */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
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

        /* Shipment Cards - Adaptables */
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

        .shipment-route {
            font-size: 13px;
            color: var(--text-dim);
            margin-bottom: 8px;
            word-break: break-word;
        }

        .shipment-dates {
            font-size: 12px;
            color: var(--text-dim);
        }

        /* Alertas */
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

        .alert i {
            font-size: 18px;
            flex-shrink: 0;
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
            padding: clamp(20px, 5vw, 32px);
            max-width: 500px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
        }

        /* Formularios */
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
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
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
            transition: all 0.3s;
        }

        .maquinaria-stat-card:hover {
            transform: translateY(-2px);
            border-color: var(--primary);
        }

        .maquinaria-stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 12px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .maquinaria-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .maquinaria-stat-value {
            font-size: clamp(24px, 5vw, 28px);
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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .stats-grid,
            .maquinaria-stats-grid {
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
            
            .stats-grid,
            .maquinaria-stats-grid {
                grid-template-columns: 1fr;
            }
            
            .header-title h1 {
                font-size: 24px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .shipment-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .modal-content {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .main-content {
                padding: 16px;
            }
            
            .stat-card,
            .maquinaria-stat-card,
            .card {
                padding: 16px;
            }
            
            .btn-sm {
                padding: 8px 10px;
            }
            
            .filtros-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Botón menú móvil -->
    <button class="mobile-menu-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="app-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
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
                <a href="{{ route('dashboard.importaciones') }}" class="nav-item active">
                    <i class="fas fa-ship"></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item" onclick="mostrarListaOrdenes()">
                    <i class="fas fa-file-invoice"></i>
                    <span>Órdenes de Compra</span>
                </a>
                <a href="#" class="nav-item" onclick="mostrarMaquinariaDisponible()">
                    <i class="fas fa-cog"></i>
                    <span>MAQUINARIA DISPONIBLE</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-truck"></i>
                    <span>En Tránsito</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-building"></i>
                    <span>Proveedores</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-file-pdf"></i>
                    <span>Documentos</span>
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-chart-line"></i>
                    <span>Estadísticas</span>
                </a>
                <hr style="border-color: rgba(14,165,233,0.2); margin: 16px 0;">
                <a href="#" class="nav-item">
                    <i class="fas fa-cog"></i>
                    <span>Configuración</span>
                </a>
                <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Salir</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content" id="mainContent">
            <!-- Header -->
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

            <!-- Mensajes de éxito/error -->
            @if(session('success'))
                <div class="alert alert-success" id="successAlert">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" id="errorAlert">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Sección Dashboard (visible por defecto) -->
            <div id="dashboardSection">
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon warning">
                                <i class="fas fa-clock"></i>
                            </div>
                            <span class="stat-label">Órdenes Pendientes</span>
                        </div>
                        <div class="stat-value">{{ $stats['ordenes_pendientes'] ?? 0 }}</div>
                        <div class="stat-trend text-warning">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $stats['ordenes_atrasadas'] ?? 0 }} atrasadas
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon info">
                                <i class="fas fa-ship"></i>
                            </div>
                            <span class="stat-label">En Tránsito</span>
                        </div>
                        <div class="stat-value">{{ $stats['en_transito'] ?? 0 }}</div>
                        <div class="stat-trend text-info">
                            <i class="fas fa-box"></i>
                            {{ $stats['contenedores_activos'] ?? 0 }} contenedores
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon success">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <span class="stat-label">Llegadas Mes</span>
                        </div>
                        <div class="stat-value">{{ $stats['llegadas_este_mes'] ?? 0 }}</div>
                        <div class="stat-trend text-success">
                            <i class="fas fa-clock"></i>
                            @if(isset($proximas_llegadas) && $proximas_llegadas->isNotEmpty() && isset($proximas_llegadas->first()->fecha))
                                Próxima en {{ max(0, $proximas_llegadas->first()->fecha->diffInDays(now())) }} días
                            @else
                                Próxima en 2 días
                            @endif
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon primary">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <span class="stat-label">Compras Mes</span>
                        </div>
                        <div class="stat-value">${{ number_format(($stats['monto_compras_mes'] ?? 1250000000) / 1000000, 0) }}M</div>
                        <div class="stat-trend text-info">
                            <i class="fas fa-building"></i>
                            {{ $stats['proveedores_activos'] ?? 0 }} proveedores
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
                            <span class="badge badge-warning">{{ $ordenes_pendientes->count() ?? 0 }} pendientes</span>
                        </div>
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>N° Orden</th>
                                        <th>Proveedor</th>
                                        <th>Modelo</th>
                                        <th>Cant.</th>
                                        <th>Monto</th>
                                        <th>Fecha Est.</th>
                                        <th>Prioridad</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ordenes_pendientes ?? [] as $orden)
                                    <tr>
                                        <td><strong>{{ $orden->numero_orden ?? $orden->id }}</strong></td>
                                        <td>
                                            {{ $orden->proveedor }}<br>
                                            <small style="color: var(--text-dim);">{{ $orden->pais }}</small>
                                        </td>
                                        <td>
                                            @if($orden->modelo_maquina)
                                                <strong>{{ $orden->modelo_maquina }}</strong>
                                            @else
                                                <span style="color: var(--text-dim);">No especificado</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge" style="background: rgba(14, 165, 233, 0.2); color: var(--primary);">
                                                {{ $orden->cantidad_maquinas ?? 1 }}
                                            </span>
                                        </td>
                                        <td>${{ number_format(($orden->monto ?? 0) / 1000000, 0) }}M</td>
                                        <td>
                                            {{ $orden->fecha_estimada ? $orden->fecha_estimada->format('d/m') : 'N/A' }}<br>
                                            @if($orden->fecha_estimada)
                                            <small style="color: var(--text-dim);">en {{ max(0, $orden->fecha_estimada->diffInDays(now())) }} días</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-indicator status-{{ $orden->prioridad ?? 'media' }}"></span>
                                            {{ ucfirst($orden->prioridad ?? 'media') }}
                                        </td>
                                        <td>
                                            <button class="btn-sm" title="Ver detalles" onclick="verOrden({{ $orden->id }})">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 20px;">
                                            No hay órdenes pendientes
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div style="margin-top: 16px; text-align: center;">
                            <button onclick="mostrarListaOrdenes()" style="color: var(--primary); text-decoration: none; background: none; border: none; cursor: pointer;">
                                Ver todas las órdenes →
                            </button>
                        </div>
                    </div>

                    <!-- Envíos en Tránsito -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <i class="fas fa-ship" style="color: var(--info);"></i>
                                Envíos en Tránsito
                            </div>
                            <span class="badge badge-info">{{ $envios_transito->count() ?? 0 }} activos</span>
                        </div>
                        <div class="shipment-grid">
                            @forelse($envios_transito ?? [] as $envio)
                            <div class="shipment-card">
                                <div class="shipment-header">
                                    <span class="shipment-id">{{ $envio->contenedor }}</span>
                                    <span class="badge 
                                        @if(($envio->estado ?? '') == 'cercano') badge-success
                                        @elseif(($envio->estado ?? '') == 'en_aduana_origen') badge-warning
                                        @else badge-info
                                        @endif">
                                        {{ str_replace('_', ' ', ucfirst($envio->estado ?? 'en_navegacion')) }}
                                    </span>
                                </div>
                                <div style="font-weight: 600; margin-bottom: 4px;">{{ $envio->maquina }}</div>
                                <div class="shipment-route">
                                    <i class="fas fa-map-marker-alt"></i> {{ $envio->puerto_salida ?? 'Puerto origen' }} 
                                    <i class="fas fa-arrow-right"></i> 
                                    <i class="fas fa-anchor"></i> {{ $envio->puerto_llegada ?? 'San Antonio' }}
                                </div>
                                <div class="shipment-dates">
                                    <div>Salida: {{ isset($envio->fecha_salida) ? $envio->fecha_salida->format('d/m') : 'N/A' }}</div>
                                    <div>Llega: {{ isset($envio->fecha_llegada_estimada) ? $envio->fecha_llegada_estimada->format('d/m') : 'N/A' }}</div>
                                </div>
                                <div class="progress-bar" style="margin: 8px 0;">
                                    <div class="progress-fill" style="width: {{ $envio->progreso ?? 0 }}%"></div>
                                </div>
                                <div style="display: flex; justify-content: space-between; font-size: 11px;">
                                    <span>Progreso: {{ $envio->progreso ?? 0 }}%</span>
                                    <span class="badge 
                                        @if(($envio->documentos ?? '') == 'completos') badge-success
                                        @elseif(($envio->documentos ?? '') == 'pendientes') badge-warning
                                        @else badge-info
                                        @endif">
                                        Docs: {{ $envio->documentos ?? 'pendientes' }}
                                    </span>
                                </div>
                            </div>
                            @empty
                            <div class="shipment-card" style="grid-column: span 2; text-align: center;">
                                No hay envíos en tránsito
                            </div>
                            @endforelse
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
                        <span class="badge badge-success">{{ $proximas_llegadas->count() ?? 0 }} próximas</span>
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
                                @forelse($proximas_llegadas ?? [] as $llegada)
                                <tr>
                                    <td><strong>{{ $llegada->contenedor }}</strong></td>
                                    <td>{{ $llegada->maquina }}</td>
                                    <td>{{ $llegada->puerto ?? 'San Antonio' }}</td>
                                    <td>{{ isset($llegada->fecha) ? $llegada->fecha->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <span class="badge 
                                            @if(($llegada->estado ?? '') == 'en_inspeccion') badge-warning
                                            @elseif(($llegada->estado ?? '') == 'documentacion') badge-info
                                            @else badge-success
                                            @endif">
                                            {{ ucfirst($llegada->estado ?? 'en_transito') }}
                                        </span>
                                    </td>
                                    <td>
                                        @if(isset($llegada->fecha))
                                        <strong>{{ max(0, $llegada->fecha->diffInDays(now())) }} días</strong>
                                        @else
                                        <strong>N/A</strong>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $idFromContenedor = str_replace('CONT-', '', $llegada->contenedor);
                                        @endphp
                                        <button class="btn-sm" onclick="verOrden({{ $idFromContenedor }})">
                                            <i class="fas fa-clipboard-list"></i>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" style="text-align: center; padding: 20px;">
                                        No hay próximas llegadas
                                    </td>
                                </tr>
                                @endforelse
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
                                    @forelse($proveedores ?? [] as $proveedor)
                                    <tr>
                                        <td><strong>{{ $proveedor->nombre }}</strong></td>
                                        <td>{{ $proveedor->pais ?? 'N/A' }}</td>
                                        <td>{{ $proveedor->ordenes_activas ?? 0 }}</td>
                                        <td>{{ $proveedor->tiempo_promedio ?? 0 }} días</td>
                                        <td>
                                            <span class="badge badge-success">{{ $proveedor->cumplimiento ?? 0 }}%</span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 20px;">
                                            No hay proveedores
                                        </td>
                                    </tr>
                                    @endforelse
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
                            <span class="badge badge-danger">{{ $documentos_pendientes->count() ?? 0 }} pendientes</span>
                        </div>
                        <div>
                            @forelse($documentos_pendientes ?? [] as $doc)
                            <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; border-bottom: 1px solid var(--card-border); flex-wrap: wrap; gap: 10px;">
                                <div>
                                    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                                        <i class="fas fa-file-pdf" style="color: var(--danger);"></i>
                                        <div>
                                            <strong>{{ $doc->tipo }}</strong><br>
                                            <small style="color: var(--text-dim);">{{ $doc->contenedor }} · {{ $doc->proveedor }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div style="text-align: right;">
                                    <span class="badge 
                                        @if(($doc->prioridad ?? '') == 'urgente') badge-danger
                                        @elseif(($doc->prioridad ?? '') == 'alta') badge-warning
                                        @else badge-info
                                        @endif">
                                        {{ ucfirst($doc->prioridad ?? 'media') }}
                                    </span>
                                    <div style="font-size: 11px; color: var(--text-dim); margin-top: 4px;">
                                        Requerido: {{ isset($doc->fecha_requerida) ? $doc->fecha_requerida->format('d/m') : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div style="text-align: center; padding: 20px;">
                                No hay documentos pendientes
                            </div>
                            @endforelse
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
                            @php
                                $proveedoresData = $proveedores ?? collect([]);
                                $paises = $proveedoresData->groupBy('pais')->map->count();
                                $total = max($paises->sum(), 4);
                                $usa = round(($paises['EE.UU.'] ?? 2) / $total * 100);
                                $japon = round(($paises['Japón'] ?? 1) / $total * 100);
                                $europa = round(($paises['Suecia'] ?? 1) / $total * 100);
                                $china = round(($paises['China'] ?? 0) / $total * 100);
                            @endphp
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                    <span>EE.UU.</span>
                                    <span>{{ $usa }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $usa }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                    <span>Japón</span>
                                    <span>{{ $japon }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $japon }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                    <span>Europa</span>
                                    <span>{{ $europa }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $europa }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                    <span>China</span>
                                    <span>{{ $china }}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: {{ $china }}%"></div>
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
                            @php
                                $primerDoc = $documentos_pendientes->first() ?? null;
                                $primerEnvio = $envios_transito->first() ?? null;
                                $primerOrden = $ordenes_pendientes->first() ?? null;
                            @endphp
                            <div style="padding: 12px; background: rgba(239, 68, 68, 0.1); border-radius: 12px;">
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <i class="fas fa-exclamation-triangle" style="color: var(--danger);"></i>
                                    <div>
                                        <strong>Documentos pendientes</strong>
                                        <p style="font-size: 12px;">{{ $primerDoc->contenedor ?? 'Contenedor KOMU-123456' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 12px; background: rgba(245, 158, 11, 0.1); border-radius: 12px;">
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <i class="fas fa-clock" style="color: var(--warning);"></i>
                                    <div>
                                        <strong>Llegada próxima</strong>
                                        <p style="font-size: 12px;">
                                            {{ $primerEnvio->contenedor ?? 'CATU-456790' }} 
                                            @if(isset($primerEnvio->fecha_llegada_estimada))
                                                en {{ max(0, $primerEnvio->fecha_llegada_estimada->diffInDays(now())) }} días
                                            @else
                                                en 2 días
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div style="padding: 12px; background: rgba(16, 185, 129, 0.1); border-radius: 12px;">
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <i class="fas fa-check-circle" style="color: var(--success);"></i>
                                    <div>
                                        <strong>Orden completada</strong>
                                        <p style="font-size: 12px;">{{ $primerOrden->numero_orden ?? 'OC-2024-004' }} lista para despacho</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección Lista de Órdenes (oculta por defecto) -->
            <div id="listaOrdenesSection" style="display: none;"></div>

            <!-- Sección Formulario Crear/Editar (oculta por defecto) -->
            <div id="formularioSection" style="display: none;"></div>

            <!-- Sección Ver Orden (oculta por defecto) -->
            <div id="verOrdenSection" style="display: none;"></div>

            <!-- Sección Maquinaria Disponible -->
            <div id="maquinariaDisponibleSection" style="display: none;">
                <div class="d-flex justify-content-between align-items-center mb-4" style="flex-wrap: wrap; gap: 15px;">
                    <div>
                        <h2 style="color: var(--text-light); margin: 0;">
                            <i class="fas fa-cog" style="color: var(--primary);"></i> 
                            MAQUINARIA DISPONIBLE
                        </h2>
                        <p style="color: var(--text-dim);">Máquinas listas para venta en inventario</p>
                    </div>
                    <a href="{{ route('maquinas.create') }}" class="btn-success" style="padding: 10px 20px; text-decoration: none; white-space: nowrap;">
                        <i class="fas fa-plus"></i> Registrar Máquina
                    </a>
                </div>

                <!-- Stats Cards -->
                <div class="maquinaria-stats-grid mb-4" id="maquinariaStatsContainer">
                    <div class="maquinaria-stat-card">
                        <div class="maquinaria-stat-header">
                            <span class="maquinaria-stat-label">Disponibles</span>
                            <div class="maquinaria-stat-icon success"><i class="fas fa-check-circle"></i></div>
                        </div>
                        <div class="maquinaria-stat-value" id="stats-disponibles">0</div>
                    </div>
                    <div class="maquinaria-stat-card">
                        <div class="maquinaria-stat-header">
                            <span class="maquinaria-stat-label">En Camino</span>
                            <div class="maquinaria-stat-icon warning"><i class="fas fa-ship"></i></div>
                        </div>
                        <div class="maquinaria-stat-value" id="stats-camino">0</div>
                    </div>
                    <div class="maquinaria-stat-card">
                        <div class="maquinaria-stat-header">
                            <span class="maquinaria-stat-label">Reservadas</span>
                            <div class="maquinaria-stat-icon primary"><i class="fas fa-clock"></i></div>
                        </div>
                        <div class="maquinaria-stat-value" id="stats-reservadas">0</div>
                    </div>
                    <div class="maquinaria-stat-card">
                        <div class="maquinaria-stat-header">
                            <span class="maquinaria-stat-label">Vendidas</span>
                            <div class="maquinaria-stat-icon info"><i class="fas fa-chart-line"></i></div>
                        </div>
                        <div class="maquinaria-stat-value" id="stats-vendidas">0</div>
                    </div>
                </div>

                <!-- Filtros -->
                <div class="filtros-card">
                    <form id="maquinariaFiltrosForm">
                        <div class="filtros-grid">
                            <div>
                                <label class="form-label">Buscar</label>
                                <input type="text" class="form-control" id="buscarMaquina" placeholder="Modelo, marca, serie...">
                            </div>
                            <div>
                                <label class="form-label">Marca</label>
                                <select class="form-control" id="filtroMarca">
                                    <option value="">Todas</option>
                                </select>
                            </div>
                            <div>
                                <label class="form-label">Precio Mín.</label>
                                <input type="number" class="form-control" id="precioMin" placeholder="0">
                            </div>
                            <div>
                                <label class="form-label">Precio Máx.</label>
                                <input type="number" class="form-control" id="precioMax" placeholder="1000000">
                            </div>
                            <div style="display: flex; align-items: flex-end; gap: 8px; flex-wrap: wrap;">
                                <button type="submit" class="btn-primary">
                                    <i class="fas fa-search"></i> Filtrar
                                </button>
                                <button type="button" class="btn-outline-secondary" onclick="limpiarFiltrosMaquinaria()">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Tabla de Maquinaria -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Máquina</th>
                                        <th>Marca / Modelo</th>
                                        <th>Año</th>
                                        <th>Serie</th>
                                        <th>Precio Venta</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="maquinariaTableBody">
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 40px;">
                                            <i class="fas fa-cog fa-3x" style="color: var(--text-dim); margin-bottom: 16px;"></i>
                                            <p style="color: var(--text-dim);">Cargando máquinas...</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal para cambiar estado -->
    <div class="modal" id="estadoModal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Cambiar Estado</h2>
                <button class="modal-close" onclick="cerrarModal()">&times;</button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="maquinaId">
                <div class="form-group">
                    <label class="form-label">Nuevo Estado</label>
                    <select class="form-control" id="nuevoEstado">
                        <option value="disponible">📦 Disponible</option>
                        <option value="en_bodega">🏭 En Bodega</option>
                        <option value="en_transito">🚢 En Tránsito</option>
                        <option value="en_puerto">⚓ En Puerto</option>
                        <option value="reparacion">🔧 En Reparación</option>
                        <option value="fabricacion">🏗️ En Fabricación</option>
                        <option value="pendiente_despacho">⏳ Vendida (Pendiente Despacho)</option>
                        <option value="cancelado">❌ Cancelado</option>
                        <option value="vendida">💰 Vendida</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer" style="display: flex; gap: 12px; justify-content: flex-end; flex-wrap: wrap;">
                <button class="btn-outline-secondary" onclick="cerrarModal()">Cancelar</button>
                <button class="btn-primary" onclick="cambiarEstadoMaquina()">Guardar Cambios</button>
            </div>
        </div>
    </div>

    <script>
        // Token CSRF para peticiones AJAX
        const csrfToken = '{{ csrf_token() }}';
        
        // Función para toggle sidebar en móvil
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
        
        // Cerrar sidebar al hacer clic fuera en móvil
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const mobileBtn = document.querySelector('.mobile-menu-btn');
            
            if (window.innerWidth <= 768) {
                if (!sidebar.contains(event.target) && !mobileBtn.contains(event.target)) {
                    sidebar.classList.remove('active');
                }
            }
        });

        // Búsqueda en tiempo real
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    const searchTerm = this.value;
                    mostrarListaOrdenes(searchTerm);
                }
            });
        }

        // Auto-ocultar alertas después de 5 segundos
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            });
        }, 5000);

        // Funciones de navegación
        function mostrarDashboard() {
            document.getElementById('dashboardSection').style.display = 'block';
            document.getElementById('listaOrdenesSection').style.display = 'none';
            document.getElementById('formularioSection').style.display = 'none';
            document.getElementById('verOrdenSection').style.display = 'none';
            document.getElementById('maquinariaDisponibleSection').style.display = 'none';
            document.getElementById('pageTitle').innerText = 'Dashboard Importaciones';
            document.getElementById('pageDescription').innerText = 'Gestión de compras internacionales y seguimiento de envíos';
            
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            document.querySelector('.nav-item[href="{{ route('dashboard.importaciones') }}"]').classList.add('active');
            
            // Cerrar sidebar en móvil
            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.remove('active');
            }
        }

        function mostrarListaOrdenes(search = '') {
            document.getElementById('dashboardSection').style.display = 'none';
            document.getElementById('listaOrdenesSection').style.display = 'block';
            document.getElementById('formularioSection').style.display = 'none';
            document.getElementById('verOrdenSection').style.display = 'none';
            document.getElementById('maquinariaDisponibleSection').style.display = 'none';
            document.getElementById('pageTitle').innerText = 'Órdenes de Compra';
            document.getElementById('pageDescription').innerText = 'Gestión de órdenes de importación';
            
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            document.querySelectorAll('.nav-item')[1].classList.add('active');
            
            cargarListaOrdenes(search);
            
            // Cerrar sidebar en móvil
            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.remove('active');
            }
        }

        function mostrarMaquinariaDisponible() {
            document.getElementById('dashboardSection').style.display = 'none';
            document.getElementById('listaOrdenesSection').style.display = 'none';
            document.getElementById('formularioSection').style.display = 'none';
            document.getElementById('verOrdenSection').style.display = 'none';
            document.getElementById('maquinariaDisponibleSection').style.display = 'block';
            document.getElementById('pageTitle').innerText = 'Maquinaria Disponible';
            document.getElementById('pageDescription').innerText = 'Gestión de inventario y maquinaria lista para venta';
            
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            document.querySelectorAll('.nav-item')[2].classList.add('active');
            
            cargarMaquinariaDisponible();
            cargarEstadisticasMaquinaria();
            cargarOpcionesFiltros();
            
            // Cerrar sidebar en móvil
            if (window.innerWidth <= 768) {
                document.getElementById('sidebar').classList.remove('active');
            }
        }

        // ✅ FUNCIÓN CORREGIDA: Ver orden usando ID numérico
        function verOrden(id) {
            if (!id) {
                console.error('ID no válido');
                return;
            }
            window.location.href = '/importaciones/' + id;
        }

        // FUNCIÓN: Cargar estadísticas
        function cargarEstadisticasMaquinaria() {
            fetch('{{ route("importaciones.maquinaria-disponible.estadisticas") }}', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('stats-disponibles').textContent = data.disponibles || 0;
                document.getElementById('stats-camino').textContent = data.en_camino || 0;
                document.getElementById('stats-reservadas').textContent = data.reservadas || 0;
                document.getElementById('stats-vendidas').textContent = data.vendidas || 0;
            })
            .catch(() => {
                document.getElementById('stats-disponibles').textContent = '0';
                document.getElementById('stats-camino').textContent = '0';
                document.getElementById('stats-reservadas').textContent = '0';
                document.getElementById('stats-vendidas').textContent = '0';
            });
        }

        // FUNCIÓN: Cargar opciones para filtros
        function cargarOpcionesFiltros() {
            const marcasSelect = document.getElementById('filtroMarca');
            marcasSelect.innerHTML = '<option value="">Todas</option>';
            
            fetch('{{ route("importaciones.maquinaria-disponible") }}?marcas=1', {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.marcas && data.marcas.length > 0) {
                    data.marcas.forEach(marca => {
                        const option = document.createElement('option');
                        option.value = marca;
                        option.textContent = marca;
                        marcasSelect.appendChild(option);
                    });
                }
            })
            .catch(() => {
                const marcas = ['CAT', 'KOMATSU', 'JOHN DEERE', 'VOLVO'];
                marcas.forEach(marca => {
                    const option = document.createElement('option');
                    option.value = marca;
                    option.textContent = marca;
                    marcasSelect.appendChild(option);
                });
            });
        }

        // FUNCIÓN: Cargar datos de maquinaria disponible
        function cargarMaquinariaDisponible() {
            const tableBody = document.getElementById('maquinariaTableBody');
            tableBody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin fa-3x"></i><p style="margin-top: 16px;">Cargando máquinas...</p></td></tr>';
            
            let url = '{{ route("importaciones.maquinaria-disponible") }}';
            const params = new URLSearchParams();
            
            const buscar = document.getElementById('buscarMaquina')?.value;
            const marca = document.getElementById('filtroMarca')?.value;
            const precioMin = document.getElementById('precioMin')?.value;
            const precioMax = document.getElementById('precioMax')?.value;
            
            if (buscar) params.append('buscar', buscar);
            if (marca) params.append('marca', marca);
            if (precioMin) params.append('precio_min', precioMin);
            if (precioMax) params.append('precio_max', precioMax);
            
            if (params.toString()) {
                url += '?' + params.toString();
            }
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.html) {
                    tableBody.innerHTML = data.html;
                } else {
                    tableBody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px; color: var(--danger);">Error al cargar los datos</td></tr>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tableBody.innerHTML = '<tr><td colspan="8" style="text-align: center; padding: 40px; color: var(--danger);">Error al cargar los datos</td></tr>';
            });
        }

        function limpiarFiltrosMaquinaria() {
            document.getElementById('buscarMaquina').value = '';
            document.getElementById('filtroMarca').value = '';
            document.getElementById('precioMin').value = '';
            document.getElementById('precioMax').value = '';
            cargarMaquinariaDisponible();
        }

        document.getElementById('maquinariaFiltrosForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            cargarMaquinariaDisponible();
        });

        function abrirModalEstado(id, estadoActual) {
            document.getElementById('maquinaId').value = id;
            document.getElementById('nuevoEstado').value = estadoActual;
            document.getElementById('estadoModal').classList.add('active');
        }

        function cerrarModal() {
            document.getElementById('estadoModal').classList.remove('active');
        }

        function cambiarEstadoMaquina() {
            const id = document.getElementById('maquinaId').value;
            const estado = document.getElementById('nuevoEstado').value;
            
            fetch('{{ route("importaciones.maquinaria-disponible.cambiar-estado", ["id" => "ID_REEMPLAZAR"]) }}'.replace('ID_REEMPLAZAR', id), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ estado: estado })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cerrarModal();
                    cargarMaquinariaDisponible();
                    cargarEstadisticasMaquinaria();
                    mostrarAlerta('success', data.message);
                }
            });
        }

        function eliminarMaquina(id) {
            if (confirm('¿Estás seguro de eliminar esta máquina?\nEsta acción no se puede deshacer.')) {
                fetch(`/maquinas/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarAlerta('success', 'Máquina eliminada correctamente');
                        cargarMaquinariaDisponible();
                        cargarEstadisticasMaquinaria();
                    } else {
                        mostrarAlerta('error', 'Error al eliminar la máquina');
                    }
                })
                .catch(error => {
                    mostrarAlerta('error', 'Error de conexión');
                });
            }
        }

        function reservarMaquina(id) {
            if (confirm('¿Reservar esta máquina para un cliente?')) {
                fetch('{{ route("importaciones.maquinaria-disponible.reservar", ["id" => "ID_REEMPLAZAR"]) }}'.replace('ID_REEMPLAZAR', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarAlerta('success', 'Máquina reservada exitosamente');
                        cargarMaquinariaDisponible();
                        cargarEstadisticasMaquinaria();
                    }
                });
            }
        }

        function venderMaquina(id) {
            if (confirm('¿Confirmar venta de esta máquina?')) {
                fetch('{{ route("importaciones.maquinaria-disponible.vender", ["id" => "ID_REEMPLAZAR"]) }}'.replace('ID_REEMPLAZAR', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarAlerta('success', 'Máquina marcada como vendida');
                        cargarMaquinariaDisponible();
                        cargarEstadisticasMaquinaria();
                    }
                });
            }
        }

        function mostrarAlerta(tipo, mensaje) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${tipo}`;
            alertDiv.innerHTML = `<i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-circle'}"></i><span>${mensaje}</span>`;
            
            const mainContent = document.querySelector('.main-content');
            mainContent.insertBefore(alertDiv, mainContent.firstChild);
            
            setTimeout(() => {
                alertDiv.style.transition = 'opacity 0.5s';
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 500);
            }, 5000);
        }

        function mostrarFormularioCrear() {
            document.getElementById('dashboardSection').style.display = 'none';
            document.getElementById('listaOrdenesSection').style.display = 'none';
            document.getElementById('formularioSection').style.display = 'block';
            document.getElementById('verOrdenSection').style.display = 'none';
            document.getElementById('maquinariaDisponibleSection').style.display = 'none';
            document.getElementById('pageTitle').innerText = 'Nueva Orden de Compra';
            document.getElementById('pageDescription').innerText = 'Registra una nueva orden de importación';
            
            cargarFormularioCrear();
        }

        function mostrarFormularioEditar(id) {
            document.getElementById('dashboardSection').style.display = 'none';
            document.getElementById('listaOrdenesSection').style.display = 'none';
            document.getElementById('formularioSection').style.display = 'block';
            document.getElementById('verOrdenSection').style.display = 'none';
            document.getElementById('maquinariaDisponibleSection').style.display = 'none';
            document.getElementById('pageTitle').innerText = 'Editar Orden de Compra';
            document.getElementById('pageDescription').innerText = 'Modifica los datos de la orden';
            
            cargarFormularioEditar(id);
        }

        function cargarListaOrdenes(search = '') {
            const listaSection = document.getElementById('listaOrdenesSection');
            listaSection.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin" style="font-size: 32px;"></i><p style="margin-top: 16px;">Cargando órdenes...</p></div>';
            
            let url = '/importaciones';
            if (search) {
                url += '?search=' + encodeURIComponent(search);
            }
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.html) {
                    listaSection.innerHTML = data.html;
                } else {
                    listaSection.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--warning);">No hay órdenes para mostrar</div>';
                }
            })
            .catch(error => {
                listaSection.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--danger);">Error al cargar las órdenes</div>';
            });
        }

        function cargarFormularioCrear() {
            const formSection = document.getElementById('formularioSection');
            formSection.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin" style="font-size: 32px;"></i><p style="margin-top: 16px;">Cargando formulario...</p></div>';
            
            fetch('/importaciones/create', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.html) {
                    formSection.innerHTML = data.html;
                } else {
                    formSection.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--danger);">Error al cargar el formulario</div>';
                }
            })
            .catch(error => {
                formSection.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--danger);">Error al cargar el formulario</div>';
            });
        }

        function cargarFormularioEditar(id) {
            const formSection = document.getElementById('formularioSection');
            formSection.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin" style="font-size: 32px;"></i><p style="margin-top: 16px;">Cargando formulario...</p></div>';
            
            fetch(`/importaciones/${id}/edit`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.html) {
                    formSection.innerHTML = data.html;
                } else {
                    formSection.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--danger);">' + (data.message || 'Error al cargar el formulario') + '</div>';
                }
            })
            .catch(error => {
                formSection.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--danger);">Error al cargar el formulario</div>';
            });
        }

        function cargarDetalleOrden(id) {
            const verSection = document.getElementById('verOrdenSection');
            verSection.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin" style="font-size: 32px;"></i><p style="margin-top: 16px;">Cargando detalles...</p></div>';
            
            fetch(`/importaciones/${id}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.html) {
                    verSection.innerHTML = data.html;
                } else {
                    verSection.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--danger);">' + (data.message || 'Error al cargar los detalles') + '</div>';
                }
            })
            .catch(error => {
                verSection.innerHTML = '<div style="text-align: center; padding: 40px; color: var(--danger);">Error al cargar los detalles</div>';
            });
        }

        function eliminarOrden(id) {
            if (confirm('¿Estás seguro de eliminar esta orden?')) {
                fetch(`/importaciones/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        mostrarListaOrdenes();
                        mostrarAlerta('success', data.message);
                    } else {
                        mostrarAlerta('error', data.message);
                    }
                })
                .catch(error => {
                    mostrarAlerta('error', 'Error al eliminar la orden');
                });
            }
        }

        function volverAlDashboard() {
            mostrarDashboard();
        }

        window.onclick = function(event) {
            const modal = document.getElementById('estadoModal');
            if (event.target === modal) {
                cerrarModal();
            }
        }
    </script>
</body>
</html>