<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Editar Orden</title>
    
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
            padding: 24px 32px;
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

        .btn-back {
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-back:hover {
            background: var(--card-border);
            color: var(--text-light);
        }

        .btn-primary {
            background: var(--primary);
            color: #0a0f1c;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: var(--card-border);
            color: var(--text-light);
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 24px;
        }

        .card-header {
            margin-bottom: 24px;
            font-size: 20px;
            font-weight: 600;
            color: var(--text-light);
            padding-bottom: 12px;
            border-bottom: 1px solid var(--card-border);
        }

        /* Formularios */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            color: var(--text-dim);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
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

        select.form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 13px;
            margin-top: 4px;
        }

        .is-invalid {
            border-color: var(--danger) !important;
        }

        /* Grid */
        .row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 20px;
        }

        .col-md-6 {
            width: 100%;
        }

        .col-md-12 {
            grid-column: span 2;
        }

        /* Actions */
        .actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 32px;
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

        .alert i {
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 16px;
            }
            
            .row {
                grid-template-columns: 1fr;
            }
            
            .col-md-12 {
                grid-column: span 1;
            }
            
            .content-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .btn-back, .btn-primary, .btn-secondary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="content-header">
        <div class="header-title">
            <h1>
                <i class="fas fa-edit" style="color: var(--primary);"></i> 
                Editar Orden de Compra
            </h1>
            <p>Modifica los datos de la orden #{{ $orden->numero_orden }}</p>
        </div>
        <a href="{{ route('importaciones.index') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Volver al listado
        </a>
    </div>

    <!-- Errores de validación -->
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

    <!-- Formulario -->
    <div class="card">
        <div class="card-header">
            <i class="fas fa-file-invoice" style="color: var(--primary);"></i>
            Información de la Orden
        </div>

        <form action="{{ route('importaciones.update', $orden->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <!-- Número de Orden -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Número de Orden <span class="text-danger">*</span></label>
                        <input type="text" name="numero_orden" class="form-control @error('numero_orden') is-invalid @enderror" 
                               value="{{ old('numero_orden', $orden->numero_orden) }}" required>
                        @error('numero_orden')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Proveedor -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Proveedor <span class="text-danger">*</span></label>
                        <select name="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror" required>
                            <option value="">Seleccione un proveedor</option>
                            @foreach($proveedores as $proveedor)
                                <option value="{{ $proveedor->id }}" {{ $orden->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                                    {{ $proveedor->nombre }} ({{ $proveedor->pais }})
                                </option>
                            @endforeach
                        </select>
                        @error('proveedor_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Fecha de Orden -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Fecha de Orden <span class="text-danger">*</span></label>
                        <input type="date" name="fecha_orden" class="form-control @error('fecha_orden') is-invalid @enderror" 
                               value="{{ old('fecha_orden', $orden->fecha_orden->format('Y-m-d')) }}" required>
                        @error('fecha_orden')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Fecha Estimada Llegada -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Fecha Estimada Llegada</label>
                        <input type="date" name="fecha_estimada_llegada" class="form-control @error('fecha_estimada_llegada') is-invalid @enderror" 
                               value="{{ old('fecha_estimada_llegada', $orden->fecha_estimada_llegada ? $orden->fecha_estimada_llegada->format('Y-m-d') : '') }}">
                        @error('fecha_estimada_llegada')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Fecha Llegada Real -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Fecha Llegada Real</label>
                        <input type="date" name="fecha_llegada_real" class="form-control @error('fecha_llegada_real') is-invalid @enderror" 
                               value="{{ old('fecha_llegada_real', $orden->fecha_llegada_real ? $orden->fecha_llegada_real->format('Y-m-d') : '') }}">
                        @error('fecha_llegada_real')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Estado -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Estado <span class="text-danger">*</span></label>
                        <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                            <option value="pendiente" {{ $orden->estado == 'pendiente' ? 'selected' : '' }}>📋 Pendiente</option>
                            <option value="en_fabricacion" {{ $orden->estado == 'en_fabricacion' ? 'selected' : '' }}>🏗️ En Fabricación</option>
                            <option value="en_transito" {{ $orden->estado == 'en_transito' ? 'selected' : '' }}>🚢 En Tránsito</option>
                            <option value="en_puerto" {{ $orden->estado == 'en_puerto' ? 'selected' : '' }}>⚓ En Puerto</option>
                            <option value="recibida" {{ $orden->estado == 'recibida' ? 'selected' : '' }}>📦 Recibida</option>
                            <option value="cancelada" {{ $orden->estado == 'cancelada' ? 'selected' : '' }}>❌ Cancelada</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Puertos -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Puerto de Salida</label>
                        <input type="text" name="puerto_salida" class="form-control" 
                               value="{{ old('puerto_salida', $orden->puerto_salida) }}" placeholder="Ej: Shanghai">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Puerto de Llegada</label>
                        <input type="text" name="puerto_llegada" class="form-control" 
                               value="{{ old('puerto_llegada', $orden->puerto_llegada) }}" placeholder="Ej: San Antonio">
                    </div>
                </div>

                <!-- Fecha Salida -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Fecha de Salida</label>
                        <input type="date" name="fecha_salida" class="form-control" 
                               value="{{ old('fecha_salida', $orden->fecha_salida ? $orden->fecha_salida->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <!-- Observaciones -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones" class="form-control" rows="4" placeholder="Información adicional...">{{ old('observaciones', $orden->observaciones) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="actions">
                <a href="{{ route('importaciones.index') }}" class="btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Actualizar Orden
                </button>
            </div>
        </form>
    </div>

    @if($orden->maquinas && $orden->maquinas->count() > 0)
    <div class="card">
        <div class="card-header">
            <i class="fas fa-cog" style="color: var(--success);"></i>
            Máquinas de esta Importación
        </div>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="text-align: left; padding: 12px; color: var(--text-dim);">ID</th>
                        <th style="text-align: left; padding: 12px; color: var(--text-dim);">Modelo</th>
                        <th style="text-align: left; padding: 12px; color: var(--text-dim);">Serie</th>
                        <th style="text-align: left; padding: 12px; color: var(--text-dim);">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orden->maquinas as $maquina)
                    <tr>
                        <td style="padding: 12px; border-top: 1px solid var(--card-border);">#{{ $maquina->id }}</td>
                        <td style="padding: 12px; border-top: 1px solid var(--card-border);">{{ optional($maquina->modelo)->modelo ?? 'N/A' }}</td>
                        <td style="padding: 12px; border-top: 1px solid var(--card-border);">{{ $maquina->numero_serie ?? 'N/A' }}</td>
                        <td style="padding: 12px; border-top: 1px solid var(--card-border);">{{ $maquina->estado_display ?? $maquina->estado }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</body>
</html>