<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Administrador</title>
    
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
            --dark-bg: #0a0f1c;
            --card-bg: #111827;
            --card-border: #1f2937;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --sidebar-width: 280px;
        }

        /* Layout */
        .dashboard {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: rgba(17, 24, 39, 0.95);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(14, 165, 233, 0.2);
            padding: 2rem 1.5rem;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(14, 165, 233, 0.2);
        }

        .sidebar-logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transform: rotate(45deg);
        }

        .sidebar-logo-icon i {
            transform: rotate(-45deg);
            color: #0a0f1c;
            font-size: 24px;
        }

        .sidebar-logo-text {
            font-size: 24px;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* User Profile */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem;
            background: rgba(14, 165, 233, 0.1);
            border-radius: 12px;
            margin-bottom: 2rem;
            border: 1px solid rgba(14, 165, 233, 0.2);
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            background: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0a0f1c;
            font-size: 20px;
            font-weight: 600;
        }

        .user-info h4 {
            color: var(--text-light);
            font-size: 14px;
            margin-bottom: 4px;
        }

        .user-info p {
            color: var(--primary);
            font-size: 12px;
            font-weight: 500;
        }

        .user-badge {
            display: inline-block;
            padding: 2px 8px;
            background: rgba(14, 165, 233, 0.2);
            border: 1px solid var(--primary);
            border-radius: 20px;
            color: var(--primary);
            font-size: 10px;
            font-weight: 600;
            margin-top: 4px;
        }

        /* Navigation */
        .nav-menu {
            list-style: none;
            margin-bottom: 2rem;
        }

        .nav-item {
            margin-bottom: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-dim);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s;
            font-weight: 500;
        }

        .nav-link i {
            width: 20px;
            font-size: 18px;
        }

        .nav-link:hover {
            background: rgba(14, 165, 233, 0.1);
            color: var(--primary);
        }

        .nav-link.active {
            background: var(--primary);
            color: #0a0f1c;
        }

        .nav-link.active i {
            color: #0a0f1c;
        }

        .nav-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.3), transparent);
            margin: 1.5rem 0;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 2rem;
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding: 1rem 1.5rem;
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            border: 1px solid rgba(14, 165, 233, 0.2);
        }

        .page-title h1 {
            font-size: 24px;
            color: var(--text-light);
        }

        .page-title p {
            color: var(--text-dim);
            font-size: 14px;
            margin-top: 4px;
        }

        .top-bar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-badge {
            position: relative;
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.2);
            padding: 0.5rem 1rem;
            border-radius: 30px;
            color: var(--text-dim);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notification-badge i {
            color: var(--primary);
        }

        .logout-btn {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fecaca;
            padding: 0.5rem 1.25rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: var(--danger);
            color: #fee2e2;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s;
        }

        .stat-card:hover {
            border-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.2);
        }

        .stat-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: rgba(14, 165, 233, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-icon i {
            font-size: 24px;
            color: var(--primary);
        }

        .stat-badge {
            padding: 4px 8px;
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 20px;
            color: var(--success);
            font-size: 12px;
            font-weight: 600;
        }

        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .stat-label {
            color: var(--text-dim);
            font-size: 14px;
        }

        /* Admin Sections */
        .admin-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-header h3 {
            font-size: 18px;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-header h3 i {
            color: var(--primary);
        }

        .card-header a {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }

        .card-header a:hover {
            text-decoration: underline;
        }

        /* Create Profile Form */
        .create-profile-form {
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-dim);
            margin-bottom: 6px;
        }

        .form-group label i {
            color: var(--primary);
            margin-right: 6px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            background: var(--input-bg, #1e293b);
            border: 2px solid transparent;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: var(--text-light);
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background: #2d3a4f;
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .role-selector {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-top: 0.5rem;
        }

        .role-option {
            position: relative;
        }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .role-option label {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 1rem;
            background: rgba(0, 0, 0, 0.2);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            margin: 0;
        }

        .role-option input[type="radio"]:checked + label {
            border-color: var(--primary);
            background: rgba(14, 165, 233, 0.1);
        }

        .role-option label i {
            font-size: 24px;
            color: var(--primary);
        }

        .role-option label span {
            font-size: 12px;
            font-weight: 500;
        }

        .btn-primary {
            background: var(--primary);
            color: #0a0f1c;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.5);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-outline:hover {
            background: var(--primary);
            color: #0a0f1c;
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fecaca;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-danger:hover {
            background: rgba(239, 68, 68, 0.2);
            border-color: var(--danger);
        }

        /* Users Table */
        .table-responsive {
            overflow-x: auto;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
        }

        .users-table th {
            text-align: left;
            padding: 1rem;
            color: var(--text-dim);
            font-weight: 500;
            font-size: 12px;
            border-bottom: 1px solid var(--card-border);
        }

        .users-table td {
            padding: 1rem;
            color: var(--text-light);
            font-size: 13px;
            border-bottom: 1px solid var(--card-border);
        }

        .users-table tr:last-child td {
            border-bottom: none;
        }

        .user-cell {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar-small {
            width: 32px;
            height: 32px;
            background: rgba(14, 165, 233, 0.1);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            font-weight: 600;
            font-size: 12px;
        }

        .role-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .role-admin {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fecaca;
        }

        .role-vendedor {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--success);
        }

        .role-cartera {
            background: rgba(245, 158, 11, 0.1);
            border: 1px solid rgba(245, 158, 11, 0.3);
            color: var(--warning);
        }

        .role-importaciones {
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.3);
            color: var(--primary);
        }

        .role-despachos {
            background: rgba(139, 92, 246, 0.1);
            border: 1px solid rgba(139, 92, 246, 0.3);
            color: #a78bfa;
        }

        .role-facturacion {
            background: rgba(236, 72, 153, 0.1);
            border: 1px solid rgba(236, 72, 153, 0.3);
            color: #f472b6;
        }

        .status-badge {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 6px;
        }

        .status-active {
            background: var(--success);
            box-shadow: 0 0 10px var(--success);
        }

        .status-inactive {
            background: var(--text-dim);
        }

        .action-buttons {
            display: flex;
            gap: 6px;
        }

        /* Activity List */
        .activity-list {
            list-style: none;
        }

        .activity-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 1rem 0;
            border-bottom: 1px solid var(--card-border);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 36px;
            height: 36px;
            background: rgba(14, 165, 233, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .activity-icon i {
            color: var(--primary);
            font-size: 16px;
        }

        .activity-details {
            flex: 1;
        }

        .activity-details p {
            font-size: 13px;
            color: var(--text-light);
            margin-bottom: 4px;
        }

        .activity-details small {
            font-size: 11px;
            color: var(--text-dim);
        }

        .activity-time {
            font-size: 11px;
            color: var(--text-dim);
        }

        /* Success Message */
        .success-message {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            color: #a7f3d0;
            font-size: 14px;
            animation: slideIn 0.3s ease-out;
        }

        .success-message i {
            color: var(--success);
            font-size: 18px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .admin-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 1000;
            }
            
            .sidebar.active {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .top-bar {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
            
            .form-row {
                grid-template-columns: 1fr;
            }
            
            .role-selector {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <span class="sidebar-logo-text">GALGA</span>
            </div>

            <!-- User Profile (DATOS REALES) -->
            <div class="user-profile">
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 2) }}</div>
                <div class="user-info">
                    <h4>{{ Auth::user()->name }}</h4>
                    <p>{{ ucfirst(Auth::user()->rol) }}</p>
                    @if(Auth::user()->rol == 'admin')
                        <span class="user-badge">Super Admin</span>
                    @endif
                </div>
            </div>

            <!-- Navigation - SOLO GESTIÓN DE USUARIOS -->
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('usuarios.index') }}" class="nav-link active">
                        <i class="fas fa-users-cog"></i>
                        <span>Gestión de Usuarios</span>
                    </a>
                </li>
                
                <div class="nav-divider"></div>
                
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Reportes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Configuración</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
                <div class="page-title">
                    <h1>Gestión de Usuarios</h1>
                    <p>{{ $totalUsuariosActivos ?? 0 }} usuarios activos en el sistema</p>
                </div>
                <div class="top-bar-actions">
                    <div class="notification-badge">
                        <i class="fas fa-bell"></i>
                        <span>{{ $notificacionesNoLeidas ?? 0 }} notificaciones</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Cerrar Sesión</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Stats Cards (DATOS REALES) -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <span class="stat-badge">+{{ $nuevosUsuariosMes ?? 0 }}</span>
                    </div>
                    <div class="stat-number">{{ $totalUsuariosActivos ?? 0 }}</div>
                    <div class="stat-label">Usuarios Activos</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <span class="stat-badge">{{ $nuevosUsuariosMes ?? 0 }}</span>
                    </div>
                    <div class="stat-number">{{ $nuevosUsuariosMes ?? 0 }}</div>
                    <div class="stat-label">Nuevos este mes</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <span class="stat-badge">{{ $totalRoles ?? 0 }}</span>
                    </div>
                    <div class="stat-number">{{ $totalRoles ?? 0 }}</div>
                    <div class="stat-label">Perfiles diferentes</div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="stat-badge">{{ $usuariosPendientes ?? 0 }}</span>
                    </div>
                    <div class="stat-number">{{ $usuariosPendientes ?? 0 }}</div>
                    <div class="stat-label">Pendientes de activación</div>
                </div>
            </div>

            <!-- Admin Grid -->
            <div class="admin-grid">
                <!-- Crear Nuevo Perfil -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-user-plus"></i> Crear Nuevo Perfil</h3>
                    </div>
                    
                    <!-- Mensaje de éxito desde sesión -->
                    @if(session('success'))
                        <div class="success-message">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    <!-- Mensajes de error -->
                    @if($errors->any())
                        <div style="background: rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); border-radius:12px; padding:1rem; margin-bottom:1.5rem; color:#fecaca;">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('usuarios.store') }}" class="create-profile-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Nombre *</label>
                                <input type="text" name="name" class="form-control" placeholder="Nombre completo" value="{{ old('name') }}" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-envelope"></i> Email *</label>
                                <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com" value="{{ old('email') }}" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> Teléfono</label>
                                <input type="text" name="telefono" class="form-control" placeholder="+52 555 555 5555" value="{{ old('telefono') }}">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-lock"></i> Contraseña *</label>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-briefcase"></i> Rol / Perfil *</label>
                            <div class="role-selector">
                                <div class="role-option">
                                    <input type="radio" name="rol" id="rol_vendedor" value="vendedor" {{ old('rol') == 'vendedor' ? 'checked' : '' }} checked>
                                    <label for="rol_vendedor">
                                        <i class="fas fa-user-tie"></i>
                                        <span>Vendedor</span>
                                    </label>
                                </div>
                                <div class="role-option">
                                    <input type="radio" name="rol" id="rol_cartera" value="cartera" {{ old('rol') == 'cartera' ? 'checked' : '' }}>
                                    <label for="rol_cartera">
                                        <i class="fas fa-coins"></i>
                                        <span>Cartera</span>
                                    </label>
                                </div>
                                <div class="role-option">
                                    <input type="radio" name="rol" id="rol_importaciones" value="importaciones" {{ old('rol') == 'importaciones' ? 'checked' : '' }}>
                                    <label for="rol_importaciones">
                                        <i class="fas fa-ship"></i>
                                        <span>Importaciones</span>
                                    </label>
                                </div>
                                <div class="role-option">
                                    <input type="radio" name="rol" id="rol_despachos" value="despachos" {{ old('rol') == 'despachos' ? 'checked' : '' }}>
                                    <label for="rol_despachos">
                                        <i class="fas fa-truck"></i>
                                        <span>Despachos</span>
                                    </label>
                                </div>
                                <div class="role-option">
                                    <input type="radio" name="rol" id="rol_facturacion" value="facturacion" {{ old('rol') == 'facturacion' ? 'checked' : '' }}>
                                    <label for="rol_facturacion">
                                        <i class="fas fa-file-invoice"></i>
                                        <span>Facturación</span>
                                    </label>
                                </div>
                                <div class="role-option">
                                    <input type="radio" name="rol" id="rol_admin" value="admin" {{ old('rol') == 'admin' ? 'checked' : '' }}>
                                    <label for="rol_admin">
                                        <i class="fas fa-user-shield"></i>
                                        <span>Administrador</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label><i class="fas fa-building"></i> Departamento/Sucursal</label>
                            <select name="departamento" class="form-control">
                                <option value="Casa Central" {{ old('departamento') == 'Casa Central' ? 'selected' : '' }}>Casa Central</option>
                                <option value="Sucursal Norte" {{ old('departamento') == 'Sucursal Norte' ? 'selected' : '' }}>Sucursal Norte</option>
                                <option value="Sucursal Sur" {{ old('departamento') == 'Sucursal Sur' ? 'selected' : '' }}>Sucursal Sur</option>
                                <option value="Sucursal Este" {{ old('departamento') == 'Sucursal Este' ? 'selected' : '' }}>Sucursal Este</option>
                                <option value="Sucursal Oeste" {{ old('departamento') == 'Sucursal Oeste' ? 'selected' : '' }}>Sucursal Oeste</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label style="display: flex; align-items: center; gap: 8px;">
                                <input type="checkbox" name="activo" value="1" {{ old('activo', true) ? 'checked' : '' }} style="accent-color: var(--primary);">
                                <span>Usuario activo (puede acceder al sistema)</span>
                            </label>
                        </div>

                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save"></i>
                            Crear Perfil
                        </button>
                    </form>
                </div>

                <!-- Actividad Reciente -->
                <div class="card">
                    <div class="card-header">
                        <h3><i class="fas fa-history"></i> Actividad Reciente</h3>
                        <a href="#">Ver todas</a>
                    </div>
                    <ul class="activity-list">
                        @forelse($actividadesRecientes ?? [] as $actividad)
                        <li class="activity-item">
                            <div class="activity-icon">
                                <i class="{{ $actividad->icono ?? 'fas fa-circle' }}"></i>
                            </div>
                            <div class="activity-details">
                                <p>{{ $actividad->descripcion ?? 'Actividad registrada' }}</p>
                                <small>{{ $actividad->usuario ?? 'Sistema' }}</small>
                            </div>
                            <div class="activity-time">{{ $actividad->tiempo ?? 'Reciente' }}</div>
                        </li>
                        @empty
                        <li class="activity-item">
                            <div class="activity-details">
                                <p>No hay actividades recientes</p>
                            </div>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Lista de Usuarios -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fas fa-list"></i> Usuarios del Sistema</h3>
                    <div style="display: flex; gap: 1rem;">
                        <form method="GET" action="{{ route('usuarios.index') }}" style="display: flex; gap: 1rem;">
                            <input type="text" name="buscar" placeholder="Buscar usuario..." class="form-control" style="width: 250px;" value="{{ request('buscar') }}">
                            <select name="rol" class="form-control" style="width: 150px;" onchange="this.form.submit()">
                                <option value="">Todos los roles</option>
                                <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="vendedor" {{ request('rol') == 'vendedor' ? 'selected' : '' }}>Vendedor</option>
                                <option value="cartera" {{ request('rol') == 'cartera' ? 'selected' : '' }}>Cartera</option>
                                <option value="importaciones" {{ request('rol') == 'importaciones' ? 'selected' : '' }}>Importaciones</option>
                                <option value="despachos" {{ request('rol') == 'despachos' ? 'selected' : '' }}>Despachos</option>
                                <option value="facturacion" {{ request('rol') == 'facturacion' ? 'selected' : '' }}>Facturación</option>
                            </select>
                        </form>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="users-table">
                        <thead>
                            汽
                                <th>Usuario</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Departamento</th>
                                <th>Estado</th>
                                <th>Último acceso</th>
                                <th>Acciones</th>
                            </thead>
                        <tbody>
                            @forelse($users ?? [] as $user)
                            汽
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar-small">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                                        <div>
                                            <strong>{{ $user->name }}</strong>
                                            <div style="font-size: 11px; color: var(--text-dim);">
                                                {{ ucfirst($user->rol) }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @php
                                        $rolClass = match($user->rol) {
                                            'admin' => 'role-admin',
                                            'vendedor' => 'role-vendedor',
                                            'cartera' => 'role-cartera',
                                            'importaciones' => 'role-importaciones',
                                            'despachos' => 'role-despachos',
                                            'facturacion' => 'role-facturacion',
                                            default => ''
                                        };
                                    @endphp
                                    <span class="role-badge {{ $rolClass }}">
                                        {{ ucfirst($user->rol) }}
                                    </span>
                                </td>
                                <td>{{ $user->departamento ?? 'No asignado' }}</td>
                                <td>
                                    <span class="status-badge {{ $user->activo ? 'status-active' : 'status-inactive' }}"></span>
                                    {{ $user->activo ? 'Activo' : 'Inactivo' }}
                                </td>
                                <td>{{ $user->ultimo_acceso ? \Carbon\Carbon::parse($user->ultimo_acceso)->diffForHumans() : '—' }}</td>
                                <td>
                                    <form method="POST" action="{{ route('usuarios.destroy', $user) }}" onsubmit="return confirm('¿Estás seguro de eliminar a {{ $user->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            汽
                                <td colspan="7" style="text-align: center; padding: 3rem; color: var(--text-dim);">
                                    <i class="fas fa-users" style="font-size: 48px; margin-bottom: 1rem; display: block;"></i>
                                    No hay usuarios registrados
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Toggle sidebar en móvil
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>
</body>
</html>