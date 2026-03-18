<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Registrar Máquina</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
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
            text-decoration: none;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.5);
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

        /* Formularios */
        .form-label {
            display: block;
            color: var(--text-dim);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-control, .form-select {
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

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2);
        }

        .form-control::placeholder {
            color: #4b5563;
        }

        select.form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .input-group-text {
            background: var(--dark-bg);
            border: 1px solid var(--card-border);
            border-right: none;
            border-radius: 12px 0 0 12px;
            padding: 12px 16px;
            color: var(--text-dim);
            font-size: 14px;
        }

        .input-group .form-control {
            border-radius: 0 12px 12px 0;
            border-left: none;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 13px;
            margin-top: 4px;
        }

        .is-invalid {
            border-color: var(--danger) !important;
        }

        /* Alertas */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .alert-info {
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .text-danger {
            color: var(--danger);
        }

        .btn-outline-secondary {
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            padding: 10px 24px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline-secondary:hover {
            background: var(--card-border);
            color: var(--text-light);
        }

        .gap-2 {
            gap: 12px;
        }

        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <div class="app-wrapper">
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="logo-icon">
                    <i class="fas fa-cog"></i>
                </div>
                <span class="logo-text">GALGA</span>
            </div>

            <div class="sidebar-user">
                <div class="user-name">{{ $usuario->name ?? 'Usuario' }}</div>
                <span class="user-role">
                    @if(isset($usuario))
                        @switch($usuario->rol)
                            @case('admin') Administrador @break
                            @case('importaciones') Importaciones @break
                            @default {{ ucfirst($usuario->rol) }}
                        @endswitch
                    @else
                        Importaciones
                    @endif
                </span>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('dashboard.importaciones') }}" class="nav-item">
                    <i class="fas fa-ship"></i>
                    Dashboard
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-file-invoice"></i>
                    Órdenes de Compra
                </a>
                <a href="#" class="nav-item active">
                    <i class="fas fa-cog"></i>
                    MAQUINARIA DISPONIBLE
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-truck"></i>
                    En Tránsito
                </a>
                <a href="#" class="nav-item">
                    <i class="fas fa-building"></i>
                    Proveedores
                </a>
                <hr style="border-color: rgba(14,165,233,0.2); margin: 16px 0;">
                <a href="{{ route('logout') }}" class="nav-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    Salir
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </nav>
        </aside>

        <main class="main-content">
            <div class="content-header">
                <div class="header-title">
                    <h1>Registrar Nueva Máquina</h1>
                    <p>Ingresa los datos de la máquina para agregarla al inventario</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('importaciones.maquinaria-disponible') }}" class="btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Volver
                    </a>
                </div>
            </div>

            @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul class="mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="fas fa-cog"></i>
                        Formulario de Registro
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('maquinas.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Modelo <span class="text-danger">*</span></label>
                                <select name="modelo_id" class="form-select @error('modelo_id') is-invalid @enderror" required>
                                    <option value="">-- Seleccione un modelo --</option>
                                    @foreach($modelos as $modelo)
                                        <option value="{{ $modelo->id }}" {{ old('modelo_id') == $modelo->id ? 'selected' : '' }}>
                                            {{ $modelo->marca }} {{ $modelo->modelo }}
                                            @if($modelo->categoria)
                                                ({{ $modelo->categoria->nombre }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('modelo_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Número de Serie</label>
                                <input type="text" name="numero_serie" class="form-control @error('numero_serie') is-invalid @enderror" 
                                       value="{{ old('numero_serie') }}" placeholder="Ej: CAT-2024-001">
                                @error('numero_serie')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Año de Fabricación</label>
                                <input type="number" name="año_fabricacion" class="form-control @error('año_fabricacion') is-invalid @enderror" 
                                       value="{{ old('año_fabricacion') }}" min="1900" max="{{ date('Y') }}" placeholder="Ej: 2023">
                                @error('año_fabricacion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Estado <span class="text-danger">*</span></label>
                                <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                    <option value="">-- Seleccione estado --</option>
                                    <option value="disponible" {{ old('estado') == 'disponible' ? 'selected' : '' }}>📦 Disponible</option>
                                    <option value="en_bodega" {{ old('estado') == 'en_bodega' ? 'selected' : '' }}>🏭 En Bodega</option>
                                    <option value="en_transito" {{ old('estado') == 'en_transito' ? 'selected' : '' }}>🚢 En Tránsito</option>
                                    <option value="en_puerto" {{ old('estado') == 'en_puerto' ? 'selected' : '' }}>⚓ En Puerto</option>
                                    <option value="reparacion" {{ old('estado') == 'reparacion' ? 'selected' : '' }}>🔧 En Reparación</option>
                                    <option value="fabricacion" {{ old('estado') == 'fabricacion' ? 'selected' : '' }}>🏗️ En Fabricación</option>
                                    <option value="pendiente_despacho" {{ old('estado') == 'pendiente_despacho' ? 'selected' : '' }}>⏳ Vendida (Pendiente Despacho)</option>
                                    <option value="cancelado" {{ old('estado') == 'cancelado' ? 'selected' : '' }}>❌ Cancelado</option>
                                    <option value="vendida" {{ old('estado') == 'vendida' ? 'selected' : '' }}>💰 Vendida</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Precio de Compra (USD)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="precio_compra" class="form-control @error('precio_compra') is-invalid @enderror" 
                                           value="{{ old('precio_compra') }}" step="0.01" min="0" placeholder="0.00">
                                </div>
                                @error('precio_compra')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Precio de Venta (USD)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="precio_venta" class="form-control @error('precio_venta') is-invalid @enderror" 
                                           value="{{ old('precio_venta') }}" step="0.01" min="0" placeholder="0.00">
                                </div>
                                @error('precio_venta')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha de Ingreso</label>
                                <input type="date" name="fecha_ingreso" class="form-control @error('fecha_ingreso') is-invalid @enderror" 
                                       value="{{ old('fecha_ingreso', date('Y-m-d')) }}">
                                @error('fecha_ingreso')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Observaciones</label>
                                <textarea name="observaciones" class="form-control" rows="4" placeholder="Información adicional relevante...">{{ old('observaciones') }}</textarea>
                            </div>
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> Los campos marcados con <span class="text-danger">*</span> son obligatorios.
                        </div>

                        <div class="mt-4 d-flex justify-content-end gap-2">
                            <a href="{{ route('importaciones.maquinaria-disponible') }}" class="btn-outline-secondary">
                                <i class="fas fa-times"></i>
                                Cancelar
                            </a>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-save"></i>
                                Guardar Máquina
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serieInput = document.querySelector('input[name="numero_serie"]');
            if (serieInput) {
                serieInput.addEventListener('input', function(e) {
                    this.value = this.value.toUpperCase();
                });
            }
        });
    </script>
</body>
</html>