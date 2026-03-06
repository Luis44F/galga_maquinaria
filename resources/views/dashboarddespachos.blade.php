<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Dashboard Despachos</title>
    
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

        /* Status Indicators */
        .status-indicator {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 6px;
        }

        .status-alta, .status-urgente {
            background: var(--danger);
        }

        .status-media, .status-normal {
            background: var(--warning);
        }

        .status-baja {
            background: var(--success);
        }

        .status-preparando {
            background: var(--info);
        }

        .status-cargando {
            background: var(--warning);
        }

        .status-pendiente {
            background: var(--text-dim);
        }

        .status-en_ruta {
            background: var(--primary);
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

        /* Route Cards */
        .route-card {
            background: rgba(14, 165, 233, 0.05);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 12px;
        }

        .route-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .route-id {
            font-weight: 600;
            color: var(--primary);
        }

        .route-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin: 12px 0;
            font-size: 13px;
        }

        .route-progress {
            margin-top: 12px;
        }

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

        /* Transportista Cards */
        .transportista-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
        }

        .transportista-card {
            background: rgba(14, 165, 233, 0.05);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 16px;
        }

        .transportista-nombre {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .transportista-contacto {
            font-size: 12px;
            color: var(--text-dim);
            margin-bottom: 8px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .two-column-grid {
                grid-template-columns: 1fr;
            }
            
            .transportista-grid {
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
                    <i class="fas fa-truck"></i>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-clock"></i>
                    Despachos Hoy
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-route"></i>
                    En Ruta
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-check-circle"></i>
                    Entregados
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-calendar-alt"></i>
                    Programados
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-truck-moving"></i>
                    Transportistas
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-map-marked-alt"></i>
                    Rutas
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
                    <h1>Dashboard Despachos</h1>
                    <p>Gestión de envíos, rutas y entregas a clientes</p>
                </div>
                <div class="header-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Buscar despacho, cliente, transportista...">
                    </div>
                    <button class="btn-primary">
                        <i class="fas fa-plus"></i>
                        Nuevo Despacho
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
                        <span class="stat-label">Despachos Pendientes</span>
                    </div>
                    <div class="stat-value">{{ $stats['despachos_pendientes'] }}</div>
                    <div class="stat-trend text-warning">
                        <i class="fas fa-calendar-day"></i>
                        {{ $stats['despachos_hoy'] }} para hoy
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon info">
                            <i class="fas fa-route"></i>
                        </div>
                        <span class="stat-label">En Ruta</span>
                    </div>
                    <div class="stat-value">{{ $stats['en_ruta'] }}</div>
                    <div class="stat-trend text-info">
                        <i class="fas fa-clock"></i>
                        {{ $stats['entregas_pendientes'] }} por entregar
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span class="stat-label">Entregados Hoy</span>
                    </div>
                    <div class="stat-value">{{ $stats['entregados_hoy'] }}</div>
                    <div class="stat-trend text-success">
                        <i class="fas fa-chart-line"></i>
                        {{ $stats['despachos_semana'] }} esta semana
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <span class="stat-label">Retrasados</span>
                    </div>
                    <div class="stat-value">{{ $stats['retrasados'] }}</div>
                    <div class="stat-trend text-danger">
                        <i class="fas fa-clock"></i>
                        Requieren atención
                    </div>
                </div>
            </div>

            <!-- Two Column Layout - Despachos Hoy y Envíos en Ruta -->
            <div class="two-column-grid">
                <!-- Despachos de Hoy -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-calendar-day" style="color: var(--warning);"></i>
                            Despachos Programados para Hoy
                        </div>
                        <span class="badge badge-warning">{{ count($despachos_hoy) }} despachos</span>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>N° Despacho</th>
                                    <th>Cliente</th>
                                    <th>Máquina</th>
                                    <th>Hora</th>
                                    <th>Transportista</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($despachos_hoy as $despacho)
                                <tr>
                                    <td><strong>{{ $despacho->id }}</strong></td>
                                    <td>
                                        {{ $despacho->cliente }}<br>
                                        <small style="color: var(--text-dim);">{{ $despacho->patente }}</small>
                                    </td>
                                    <td>{{ $despacho->maquina }}</td>
                                    <td>{{ $despacho->fecha_despacho->format('H:i') }}</td>
                                    <td>{{ $despacho->transportista }}</td>
                                    <td>
                                        <span class="status-indicator status-{{ $despacho->estado }}"></span>
                                        {{ ucfirst($despacho->estado) }}
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-sm" title="Iniciar despacho">
                                                <i class="fas fa-play"></i>
                                            </button>
                                            <button class="btn-sm" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Envíos en Ruta -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-route" style="color: var(--info);"></i>
                            Envíos en Ruta
                        </div>
                        <span class="badge badge-info">{{ count($envios_ruta) }} activos</span>
                    </div>
                    <div>
                        @foreach($envios_ruta as $ruta)
                        <div class="route-card">
                            <div class="route-header">
                                <span class="route-id">{{ $ruta->id }}</span>
                                <span class="badge badge-info">En Ruta</span>
                            </div>
                            <div><strong>{{ $ruta->cliente }}</strong></div>
                            <div style="font-size: 13px; color: var(--text-dim); margin: 4px 0;">
                                {{ $ruta->maquina }}
                            </div>
                            <div class="route-info">
                                <div>
                                    <i class="fas fa-user"></i> {{ $ruta->conductor }}<br>
                                    <i class="fas fa-truck"></i> {{ $ruta->patente }}
                                </div>
                                <div>
                                    <i class="fas fa-map-marker-alt"></i> {{ $ruta->ubicacion }}<br>
                                    <i class="fas fa-phone"></i> {{ $ruta->contacto }}
                                </div>
                            </div>
                            <div class="route-progress">
                                <div style="display: flex; justify-content: space-between; font-size: 12px;">
                                    <span>Salida: {{ $ruta->fecha_salida->format('H:i') }}</span>
                                    <span>Est. llegada: {{ $ruta->hora_estimada->format('H:i') }}</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: 65%"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Entregas Realizadas Hoy -->
            <div class="card" style="margin-bottom: 32px;">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-check-circle" style="color: var(--success);"></i>
                        Entregas Realizadas Hoy
                    </div>
                    <span class="badge badge-success">{{ count($entregas_hoy) }} entregas</span>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>N° Despacho</th>
                                <th>Cliente</th>
                                <th>Máquina</th>
                                <th>Hora Entrega</th>
                                <th>Recibido por</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($entregas_hoy as $entrega)
                            <tr>
                                <td><strong>{{ $entrega->id }}</strong></td>
                                <td>{{ $entrega->cliente }}</td>
                                <td>{{ $entrega->maquina }}</td>
                                <td>{{ $entrega->fecha_entrega->format('H:i') }}</td>
                                <td>{{ $entrega->recibido_por }}</td>
                                <td>
                                    @if($entrega->conforme)
                                        <span class="badge badge-success">Conforme</span>
                                    @else
                                        <span class="badge badge-warning">Pendiente</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn-sm">
                                        <i class="fas fa-file-pdf"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Two Column Layout - Transportistas y Próximos Despachos -->
            <div class="two-column-grid">
                <!-- Transportistas Activos -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-truck-moving" style="color: var(--primary);"></i>
                            Transportistas Activos
                        </div>
                    </div>
                    <div class="transportista-grid">
                        @foreach($transportistas as $trans)
                        <div class="transportista-card">
                            <div class="transportista-nombre">{{ $trans->nombre }}</div>
                            <div class="transportista-contacto">
                                <i class="fas fa-phone"></i> {{ $trans->contacto }}
                            </div>
                            <div style="display: flex; justify-content: space-between; align-items: center;">
                                <span class="badge 
                                    @if($trans->disponibilidad == 'disponible') badge-success
                                    @else badge-warning
                                    @endif">
                                    {{ ucfirst($trans->disponibilidad) }}
                                </span>
                                <span style="font-size: 12px;">{{ $trans->envios_hoy }} envíos hoy</span>
                            </div>
                            @if($trans->proximo_regreso)
                            <div style="font-size: 11px; color: var(--text-dim); margin-top: 8px;">
                                <i class="fas fa-clock"></i> Regreso: {{ $trans->proximo_regreso->format('H:i') }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Próximos Despachos -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-calendar-alt" style="color: var(--info);"></i>
                            Próximos Despachos
                        </div>
                        <span class="badge badge-info">{{ count($proximos_despachos) }} programados</span>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Cliente</th>
                                    <th>Máquina</th>
                                    <th>Dirección</th>
                                    <th>Prioridad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proximos_despachos as $prox)
                                <tr>
                                    <td>{{ $prox->fecha->format('d/m H:i') }}</td>
                                    <td>{{ $prox->cliente }}</td>
                                    <td>{{ $prox->maquina }}</td>
                                    <td><small>{{ $prox->direccion }}</small></td>
                                    <td>
                                        <span class="badge 
                                            @if($prox->prioridad == 'urgente') badge-danger
                                            @elseif($prox->prioridad == 'alta') badge-warning
                                            @else badge-info
                                            @endif">
                                            {{ ucfirst($prox->prioridad) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Resumen de Despachos -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 32px;">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-chart-pie"></i>
                            Despachos por Región
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Región Metropolitana</span>
                                <span>45%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 45%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Valparaíso</span>
                                <span>20%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 20%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Antofagasta</span>
                                <span>15%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 15%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Otras regiones</span>
                                <span>20%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 20%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-clock"></i>
                            Horarios Preferidos
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Mañana (8-12)</span>
                                <span>40%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 40%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Tarde (12-18)</span>
                                <span>45%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 45%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Noche (18-22)</span>
                                <span>15%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 15%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-bell"></i>
                            Alertas de Despacho
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div style="padding: 12px; background: rgba(239, 68, 68, 0.1); border-radius: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-exclamation-triangle" style="color: var(--danger);"></i>
                                <div>
                                    <strong>Despacho retrasado</strong>
                                    <p style="font-size: 12px;">DES-2024-002 - Minera Esperanza</p>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 12px; background: rgba(245, 158, 11, 0.1); border-radius: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-truck" style="color: var(--warning);"></i>
                                <div>
                                    <strong>Próximo a salir</strong>
                                    <p style="font-size: 12px;">DES-2024-001 en 30 minutos</p>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 12px; background: rgba(16, 185, 129, 0.1); border-radius: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-check-circle" style="color: var(--success);"></i>
                                <div>
                                    <strong>Entrega confirmada</strong>
                                    <p style="font-size: 12px;">DES-2024-008 - Constructora Sur</p>
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