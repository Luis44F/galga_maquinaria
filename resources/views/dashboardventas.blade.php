<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Dashboard Comercial</title>
    
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

        .stat-icon.success {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .stat-icon.warning {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .stat-icon.info {
            background: rgba(14, 165, 233, 0.2);
            color: var(--primary);
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
            font-size: 32px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .stat-trend {
            font-size: 13px;
            color: var(--success);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        /* Filters */
        .filters-section {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .filters-title {
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .filters-grid {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-label {
            font-size: 13px;
            color: var(--text-dim);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .filter-select, .filter-input {
            width: 100%;
            padding: 10px 16px;
            background: var(--dark-bg);
            border: 1px solid var(--card-border);
            border-radius: 10px;
            color: var(--text-light);
            font-family: 'Inter', sans-serif;
            outline: none;
        }

        .filter-select:focus, .filter-input:focus {
            border-color: var(--primary);
        }

        /* Tabs */
        .tabs-container {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            border-bottom: 1px solid var(--card-border);
            padding-bottom: 16px;
        }

        .tab-item {
            padding: 10px 24px;
            border-radius: 30px;
            background: transparent;
            color: var(--text-dim);
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
            border: 1px solid transparent;
        }

        .tab-item:hover {
            border-color: var(--primary);
            color: var(--primary);
        }

        .tab-item.active {
            background: var(--primary);
            color: #0a0f1c;
            border-color: var(--primary);
        }

        /* Table */
        .table-container {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            overflow: hidden;
        }

        .table-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--card-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-title {
            font-weight: 600;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-actions {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-icon:hover {
            background: var(--primary);
            color: #0a0f1c;
            border-color: var(--primary);
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 16px 24px;
            background: rgba(14, 165, 233, 0.05);
            color: var(--text-dim);
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        td {
            padding: 16px 24px;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-light);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(14, 165, 233, 0.05);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .badge-warning {
            background: rgba(245, 158, 11, 0.2);
            color: var(--warning);
        }

        .badge-info {
            background: rgba(14, 165, 233, 0.2);
            color: var(--primary);
        }

        .badge-secondary {
            background: rgba(148, 163, 184, 0.2);
            color: var(--text-dim);
        }

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
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-sm:hover {
            background: var(--primary);
            color: #0a0f1c;
            border-color: var(--primary);
        }

        /* Proximas Llegadas */
        .arrivals-section {
            margin-top: 32px;
        }

        .arrivals-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-top: 16px;
        }

        .arrival-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 20px;
            transition: all 0.3s;
        }

        .arrival-card:hover {
            border-color: var(--primary);
            transform: translateY(-2px);
        }

        .arrival-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .arrival-model {
            font-weight: 700;
            color: var(--text-light);
        }

        .arrival-date {
            font-size: 13px;
            color: var(--text-dim);
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .arrival-progress {
            margin-top: 16px;
        }

        .progress-bar {
            height: 6px;
            background: var(--dark-bg);
            border-radius: 3px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary);
            border-radius: 3px;
        }

        .progress-text {
            font-size: 12px;
            color: var(--text-dim);
            display: flex;
            justify-content: space-between;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 24px;
        }

        .page-item {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            cursor: pointer;
            transition: all 0.3s;
        }

        .page-item:hover, .page-item.active {
            background: var(--primary);
            color: #0a0f1c;
            border-color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .arrivals-grid {
                grid-template-columns: repeat(2, 1fr);
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
            
            .arrivals-grid {
                grid-template-columns: 1fr;
            }
            
            .filters-grid {
                flex-direction: column;
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
                            Vendedor {{ $usuario->departamento ? '· ' . $usuario->departamento : '' }}
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
                    <i class="fas fa-chart-pie"></i>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-truck"></i>
                    En Tránsito
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-box"></i>
                    Inventario
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-shopping-cart"></i>
                    Ventas
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-hourglass-half"></i>
                    Pendientes
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-file-invoice"></i>
                    Facturación
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-truck-loading"></i>
                    Despachos
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
                    <h1>Dashboard Comercial</h1>
                    <p>Bienvenido, aquí tienes el resumen de disponibilidad y ventas</p>
                </div>
                <div class="header-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Buscar máquina, modelo o serie...">
                    </div>
                    <button class="btn-primary">
                        <i class="fas fa-plus"></i>
                        Nueva Venta
                    </button>
                </div>
            </div>

            <!-- Stats Cards con datos dinámicos -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span class="stat-label">Disponibles</span>
                    </div>
                    <div class="stat-value">{{ $stats['disponibles'] }}</div>
                    <div class="stat-trend">
                        <i class="fas fa-box"></i>
                        En inventario
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon warning">
                            <i class="fas fa-truck"></i>
                        </div>
                        <span class="stat-label">En Tránsito</span>
                    </div>
                    <div class="stat-value">{{ $stats['en_transito'] }}</div>
                    <div class="stat-trend">
                        <i class="fas fa-clock"></i>
                        Por llegar
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon info">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <span class="stat-label">Orden Pendiente</span>
                    </div>
                    <div class="stat-value">{{ $stats['orden_pendiente'] }}</div>
                    <div class="stat-trend">
                        <i class="fas fa-calendar"></i>
                        Por fabricar/pedir
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <span class="stat-label">Mis Ventas</span>
                    </div>
                    <div class="stat-value">{{ $stats['mis_ventas'] }}</div>
                    <div class="stat-trend">
                        <i class="fas fa-star"></i>
                        Este mes
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="filters-section">
                <div class="filters-title">
                    <i class="fas fa-filter" style="color: var(--primary);"></i>
                    Filtros de Búsqueda
                </div>
                <div class="filters-grid">
                    <div class="filter-group">
                        <div class="filter-label">
                            <i class="fas fa-tag"></i>
                            Estado
                        </div>
                        <select class="filter-select">
                            <option>Todas las máquinas</option>
                            <option>Disponibles</option>
                            <option>En Tránsito</option>
                            <option>Orden Pendiente</option>
                            <option>Vendidas</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <div class="filter-label">
                            <i class="fas fa-industry"></i>
                            Marca
                        </div>
                        <select class="filter-select">
                            <option>Todas las marcas</option>
                            <option>Caterpillar</option>
                            <option>Komatsu</option>
                            <option>John Deere</option>
                            <option>Volvo</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <div class="filter-label">
                            <i class="fas fa-calendar"></i>
                            Año
                        </div>
                        <select class="filter-select">
                            <option>Todos los años</option>
                            <option>2024</option>
                            <option>2023</option>
                            <option>2022</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="tabs-container">
                <div class="tab-item active">Todas las Máquinas</div>
                <div class="tab-item">Disponibles</div>
                <div class="tab-item">En Tránsito</div>
                <div class="tab-item">Orden Pendiente</div>
                <div class="tab-item">Vendidas</div>
            </div>

            <!-- Table con datos dinámicos -->
            <div class="table-container">
                <div class="table-header">
                    <div class="table-title">
                        <i class="fas fa-list" style="color: var(--primary);"></i>
                        Inventario de Máquinas
                    </div>
                    <div class="table-actions">
                        <button class="btn-icon">
                            <i class="fas fa-download"></i>
                        </button>
                        <button class="btn-icon">
                            <i class="fas fa-print"></i>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Modelo</th>
                                <th>Marca</th>
                                <th>Serie</th>
                                <th>Año</th>
                                <th>Estado</th>
                                <th>Precio Venta</th>
                                <th>Ubicación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($maquinas_recientes as $maquina)
                            <tr>
                                <td>{{ $maquina->modelo }}</td>
                                <td>{{ $maquina->marca }}</td>
                                <td>{{ $maquina->serie }}</td>
                                <td>{{ $maquina->año }}</td>
                                <td>
                                    @switch($maquina->estado)
                                        @case('disponible')
                                            <span class="badge badge-success">Disponible</span>
                                            @break
                                        @case('en_transito')
                                            <span class="badge badge-warning">En Tránsito</span>
                                            @break
                                        @case('orden_pendiente')
                                            <span class="badge badge-info">Orden Pendiente</span>
                                            @break
                                        @case('vendida')
                                            <span class="badge badge-secondary">Vendida</span>
                                            @break
                                        @default
                                            <span class="badge badge-secondary">{{ $maquina->estado }}</span>
                                    @endswitch
                                </td>
                                <td>${{ number_format($maquina->precio_venta, 0, ',', '.') }}</td>
                                <td>{{ $maquina->ubicacion ?? 'No especificada' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-sm"><i class="fas fa-eye"></i></button>
                                        <button class="btn-sm"><i class="fas fa-shopping-cart"></i></button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" style="text-align: center; color: var(--text-dim);">
                                    No hay máquinas disponibles
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination">
                <div class="page-item active">1</div>
                <div class="page-item">2</div>
                <div class="page-item">3</div>
                <div class="page-item">4</div>
                <div class="page-item">5</div>
                <div class="page-item">...</div>
                <div class="page-item">10</div>
            </div>

            <!-- Próximas Llegadas Section con datos dinámicos -->
            <div class="arrivals-section">
                <div class="table-header" style="margin-bottom: 16px;">
                    <div class="table-title">
                        <i class="fas fa-ship" style="color: var(--primary);"></i>
                        Próximas Llegadas
                    </div>
                    <a href="#" style="color: var(--primary); text-decoration: none;">Ver todos</a>
                </div>
                <div class="arrivals-grid">
                    @forelse($proximas_llegadas as $llegada)
                    <div class="arrival-card">
                        <div class="arrival-header">
                            <span class="arrival-model">{{ $llegada->marca }} {{ $llegada->modelo }}</span>
                            <span class="arrival-date">
                                <i class="fas fa-calendar"></i>
                                {{ $llegada->fecha_ingreso ? $llegada->fecha_ingreso->format('d M') : 'Próximamente' }}
                            </span>
                        </div>
                        <div style="color: var(--text-dim); font-size: 14px; margin-bottom: 12px;">
                            Serie: {{ $llegada->serie }}
                        </div>
                        <div class="arrival-progress">
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 75%"></div>
                            </div>
                            <div class="progress-text">
                                <span>En tránsito</span>
                                <span>75% · {{ $llegada->fecha_ingreso ? now()->diffInDays($llegada->fecha_ingreso) : '15' }} días</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="arrival-card" style="grid-column: span 3; text-align: center;">
                        <div style="color: var(--text-dim); padding: 20px;">
                            <i class="fas fa-check-circle" style="font-size: 24px; color: var(--success); margin-bottom: 10px;"></i>
                            <p>No hay máquinas en tránsito</p>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>

    <script>
        // Tabs functionality
        document.querySelectorAll('.tab-item').forEach(tab => {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Simular búsqueda en tiempo real
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