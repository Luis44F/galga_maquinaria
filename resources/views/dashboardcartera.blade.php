<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Dashboard Cartera</title>
    
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

        .stat-icon.danger {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
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

        .badge-danger {
            background: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .badge-info {
            background: rgba(14, 165, 233, 0.2);
            color: var(--primary);
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

        /* Anticipo Item */
        .anticipo-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid var(--card-border);
        }

        .anticipo-item:last-child {
            border-bottom: none;
        }

        .anticipo-info h4 {
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .anticipo-info p {
            font-size: 13px;
            color: var(--text-dim);
        }

        .anticipo-monto {
            font-weight: 700;
            color: var(--success);
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

        .status-urgente {
            background: var(--danger);
        }

        .status-proximo {
            background: var(--warning);
        }

        .status-normal {
            background: var(--success);
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .two-column-grid {
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
                    <i class="fas fa-chart-pie"></i>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-clock"></i>
                    Anticipos Pendientes
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-check-circle"></i>
                    Anticipos Confirmados
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-exclamation-triangle"></i>
                    Pagos Atrasados
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-calendar-alt"></i>
                    Próximos Pagos
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-hand-holding-usd"></i>
                    Conciliaciones
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-file-invoice"></i>
                    Reportes
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
                    <h1>Dashboard Cartera</h1>
                    <p>Gestión de anticipos, pagos y conciliaciones bancarias</p>
                </div>
                <div class="header-actions">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Buscar cliente, RUT, anticipo...">
                    </div>
                    <button class="btn-primary">
                        <i class="fas fa-plus"></i>
                        Registrar Anticipo
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
                        <span class="stat-label">Anticipos Pendientes</span>
                    </div>
                    <div class="stat-value">{{ $stats['anticipos_pendientes'] }}</div>
                    <div class="stat-trend text-warning">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $stats['anticipos_hoy'] }} para hoy
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon success">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span class="stat-label">Pagos Completados</span>
                    </div>
                    <div class="stat-value">{{ $stats['pagos_completados_mes'] }}</div>
                    <div class="stat-trend text-success">
                        <i class="fas fa-calendar"></i>
                        Este mes
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon primary">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <span class="stat-label">Monto Anticipos</span>
                    </div>
                    <div class="stat-value">${{ number_format($stats['monto_anticipos_mes'], 0, ',', '.') }}</div>
                    <div class="stat-trend text-info">
                        <i class="fas fa-chart-line"></i>
                        +15% vs mes ant
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <span class="stat-label">Clientes Morosos</span>
                    </div>
                    <div class="stat-value">{{ $stats['clientes_morosos'] }}</div>
                    <div class="stat-trend text-danger">
                        <i class="fas fa-clock"></i>
                        {{ $stats['facturas_vencidas'] }} facturas vencidas
                    </div>
                </div>
            </div>

            <!-- Two Column Layout - Anticipos Pendientes y Próximos Pagos -->
            <div class="two-column-grid">
                <!-- Anticipos Pendientes de Confirmación -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-clock" style="color: var(--warning);"></i>
                            Anticipos Pendientes de Confirmación
                        </div>
                        <span class="badge badge-warning">{{ count($anticipos_pendientes) }} pendientes</span>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Máquina</th>
                                    <th>Monto</th>
                                    <th>Método</th>
                                    <th>Vendedor</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($anticipos_pendientes as $anticipo)
                                <tr>
                                    <td>
                                        <strong>{{ $anticipo->cliente }}</strong><br>
                                        <small style="color: var(--text-dim);">{{ $anticipo->rut }}</small>
                                    </td>
                                    <td>{{ $anticipo->maquina }}</td>
                                    <td style="color: var(--success); font-weight: 600;">${{ number_format($anticipo->monto, 0, ',', '.') }}</td>
                                    <td>{{ $anticipo->metodo }}</td>
                                    <td>{{ $anticipo->vendedor }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-sm btn-success" title="Confirmar pago">
                                                <i class="fas fa-check"></i>
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
                    <div style="margin-top: 16px; text-align: center;">
                        <a href="#" style="color: var(--primary); text-decoration: none;">Ver todos los anticipos pendientes →</a>
                    </div>
                </div>

                <!-- Próximos Pagos de Clientes -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-calendar-alt" style="color: var(--primary);"></i>
                            Próximos Pagos
                        </div>
                        <span class="badge badge-info">{{ count($proximos_pagos) }} próximos</span>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Concepto</th>
                                    <th>Monto</th>
                                    <th>Vencimiento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proximos_pagos as $pago)
                                <tr>
                                    <td>
                                        <strong>{{ $pago->cliente }}</strong><br>
                                        <small style="color: var(--text-dim);">{{ $pago->rut }}</small>
                                    </td>
                                    <td>{{ $pago->concepto }}</td>
                                    <td style="font-weight: 600;">${{ number_format($pago->monto, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="status-indicator status-{{ $pago->estado }}"></span>
                                        {{ $pago->fecha_vencimiento->format('d/m/Y') }}
                                        <br>
                                        <small style="color: var(--text-dim);">{{ $pago->dias_restantes }} días</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagos Atrasados -->
            <div class="card" style="margin-bottom: 32px;">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-exclamation-triangle" style="color: var(--danger);"></i>
                        Pagos Atrasados
                    </div>
                    <span class="badge badge-danger">{{ count($pagos_atrasados) }} atrasados</span>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Contacto</th>
                                <th>Concepto</th>
                                <th>Monto</th>
                                <th>Días Atraso</th>
                                <th>Vendedor</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pagos_atrasados as $atrasado)
                            <tr>
                                <td>
                                    <strong>{{ $atrasado->cliente }}</strong><br>
                                    <small style="color: var(--text-dim);">{{ $atrasado->rut }}</small>
                                </td>
                                <td>
                                    {{ $atrasado->telefono }}<br>
                                    <small style="color: var(--text-dim);">Último contacto: {{ $atrasado->ultimo_contacto->diffForHumans() }}</small>
                                </td>
                                <td>{{ $atrasado->concepto }}</td>
                                <td style="color: var(--danger); font-weight: 600;">${{ number_format($atrasado->monto, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge badge-danger">{{ $atrasado->dias_atraso }} días</span>
                                </td>
                                <td>{{ $atrasado->vendedor }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-sm btn-warning">
                                            <i class="fas fa-phone"></i> Contactar
                                        </button>
                                        <button class="btn-sm">
                                            <i class="fas fa-history"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Dos columnas para Conciliaciones y Últimos Anticipos -->
            <div class="two-column-grid">
                <!-- Conciliaciones Bancarias Pendientes -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-hand-holding-usd" style="color: var(--info);"></i>
                            Conciliaciones Bancarias Pendientes
                        </div>
                        <span class="badge badge-info">{{ count($conciliaciones) }} pendientes</span>
                    </div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Banco</th>
                                    <th>Fecha</th>
                                    <th>Movimientos</th>
                                    <th>Monto</th>
                                    <th>Estado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($conciliaciones as $conci)
                                <tr>
                                    <td><strong>{{ $conci->banco }}</strong></td>
                                    <td>{{ $conci->fecha->format('d/m/Y') }}</td>
                                    <td>{{ $conci->movimientos }} mov.</td>
                                    <td>${{ number_format($conci->monto, 0, ',', '.') }}</td>
                                    <td>
                                        @if($conci->estado == 'en_proceso')
                                            <span class="badge badge-warning">En Proceso</span>
                                        @else
                                            <span class="badge badge-info">Pendiente</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn-sm">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Últimos Anticipos Confirmados -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-check-circle" style="color: var(--success);"></i>
                            Últimos Anticipos Confirmados
                        </div>
                    </div>
                    <div>
                        @foreach($ultimos_anticipos as $ultimo)
                        <div class="anticipo-item">
                            <div class="anticipo-info">
                                <h4>{{ $ultimo->cliente }}</h4>
                                <p>{{ $ultimo->metodo }} · {{ $ultimo->fecha->diffForHumans() }}</p>
                            </div>
                            <div>
                                <span class="anticipo-monto">${{ number_format($ultimo->monto, 0, ',', '.') }}</span>
                                <br>
                                <small style="color: var(--text-dim);">por {{ $ultimo->confirmado_por }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Resumen de Cobranza -->
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 32px;">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-chart-pie"></i>
                            Anticipos por Método de Pago
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Transferencia</span>
                                <span>65%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 65%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Cheque</span>
                                <span>20%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 20%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Efectivo</span>
                                <span>10%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 10%"></div>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>Otros</span>
                                <span>5%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: 5%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-clock"></i>
                            Anticipos por Rango de Monto
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>$0 - $10M</span>
                                <span>8</span>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>$10M - $50M</span>
                                <span>15</span>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>$50M - $100M</span>
                                <span>7</span>
                            </div>
                        </div>
                        <div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                                <span>$100M+</span>
                                <span>3</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="fas fa-bell"></i>
                            Alertas y Recordatorios
                        </div>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 16px;">
                        <div style="padding: 12px; background: rgba(245, 158, 11, 0.1); border-radius: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-exclamation-triangle" style="color: var(--warning);"></i>
                                <div>
                                    <strong>Conciliación pendiente</strong>
                                    <p style="font-size: 12px;">Banco Santander - hace 2 días</p>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 12px; background: rgba(239, 68, 68, 0.1); border-radius: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-exclamation-circle" style="color: var(--danger);"></i>
                                <div>
                                    <strong>Pago atrasado</strong>
                                    <p style="font-size: 12px;">Constructora del Sur - $65M</p>
                                </div>
                            </div>
                        </div>
                        <div style="padding: 12px; background: rgba(14, 165, 233, 0.1); border-radius: 12px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-calendar-check" style="color: var(--primary);"></i>
                                <div>
                                    <strong>Vencimiento mañana</strong>
                                    <p style="font-size: 12px;">Minera Cerro Colorado - $95M</p>
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