<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Editar Importación</title>
    
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
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --card-bg: #111827;
            --card-border: #1f2937;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --dark-bg: #0a0f1c;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-light);
        }

        .btn-back {
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-back:hover {
            background: var(--card-border);
            color: var(--text-light);
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 32px;
        }

        .card-header {
            margin-bottom: 24px;
            font-size: 20px;
            font-weight: 600;
            color: var(--text-light);
            display: flex;
            align-items: center;
            gap: 8px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--card-border);
        }

        .card-header i {
            color: var(--primary);
        }

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

        .form-control[readonly] {
            background: rgba(0, 0, 0, 0.2);
            color: var(--text-dim);
            cursor: not-allowed;
        }

        .row {
            display: flex;
            margin: 0 -10px;
            flex-wrap: wrap;
        }

        .col-md-6 {
            flex: 0 0 50%;
            max-width: 50%;
            padding: 0 10px;
        }

        .col-md-4 {
            flex: 0 0 33.333%;
            max-width: 33.333%;
            padding: 0 10px;
        }

        .is-invalid {
            border-color: var(--danger) !important;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 12px;
            margin-top: 4px;
        }

        .text-danger {
            color: var(--danger);
        }

        .text-muted {
            color: var(--text-dim);
            font-size: 12px;
            display: block;
            margin-top: 4px;
        }

        .btn-primary {
            background: var(--primary);
            color: #0a0f1c;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
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
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn-secondary:hover {
            background: var(--card-border);
            color: var(--text-light);
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 32px;
        }

        .alert-info {
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.2);
            color: var(--primary);
            padding: 12px;
            border-radius: 12px;
            margin: 20px 0;
            font-size: 13px;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 500;
            background: rgba(14, 165, 233, 0.1);
            color: var(--primary);
        }

        select.form-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }

        hr {
            border: none;
            border-top: 1px solid var(--card-border);
            margin: 24px 0;
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            .col-md-6, .col-md-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .actions {
                flex-direction: column;
            }

            .btn-primary, .btn-secondary {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Editar Orden de Compra</h1>
                <p style="color: var(--text-dim); margin-top: 4px;">Modifica los datos de la orden #{{ $orden->numero_orden }}</p>
            </div>
            <a href="{{ route('importaciones.show', $orden->id) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>

        @if($errors->any())
            <div class="alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul style="margin-top: 8px; margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit"></i> Información de la Orden
                <span class="badge" style="margin-left: auto;">ID: {{ $orden->id }}</span>
            </div>

            <form action="{{ route('importaciones.update', $orden->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Número de Orden *</label>
                            <input type="text" 
                                   name="numero_orden" 
                                   class="form-control" 
                                   value="{{ old('numero_orden', $orden->numero_orden) }}" 
                                   readonly>
                            <small class="text-muted">El número de orden no se puede modificar</small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Proveedor *</label>
                            <select name="proveedor_id" class="form-select @error('proveedor_id') is-invalid @enderror" required>
                                <option value="">Seleccione un proveedor</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}" 
                                        {{ (old('proveedor_id', $orden->proveedor_id) == $proveedor->id) ? 'selected' : '' }}>
                                        {{ $proveedor->nombre }} ({{ $proveedor->pais }})
                                    </option>
                                @endforeach
                            </select>
                            @error('proveedor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Fecha de Orden *</label>
                            <input type="date" 
                                   name="fecha_orden" 
                                   class="form-control @error('fecha_orden') is-invalid @enderror" 
                                   value="{{ old('fecha_orden', $orden->fecha_orden ? $orden->fecha_orden->format('Y-m-d') : '') }}" 
                                   required>
                            @error('fecha_orden')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Fecha Estimada Llegada</label>
                            <input type="date" 
                                   name="fecha_estimada_llegada" 
                                   class="form-control @error('fecha_estimada_llegada') is-invalid @enderror" 
                                   value="{{ old('fecha_estimada_llegada', $orden->fecha_estimada_llegada ? $orden->fecha_estimada_llegada->format('Y-m-d') : '') }}">
                            @error('fecha_estimada_llegada')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Fecha Llegada Real</label>
                            <input type="date" 
                                   name="fecha_llegada_real" 
                                   class="form-control @error('fecha_llegada_real') is-invalid @enderror" 
                                   value="{{ old('fecha_llegada_real', $orden->fecha_llegada_real ? $orden->fecha_llegada_real->format('Y-m-d') : '') }}">
                            @error('fecha_llegada_real')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Puerto de Salida</label>
                            <input type="text" 
                                   name="puerto_salida" 
                                   class="form-control" 
                                   value="{{ old('puerto_salida', $orden->puerto_salida) }}"
                                   placeholder="Ej: Shanghai">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Puerto de Llegada</label>
                            <input type="text" 
                                   name="puerto_llegada" 
                                   class="form-control" 
                                   value="{{ old('puerto_llegada', $orden->puerto_llegada) }}"
                                   placeholder="Ej: San Antonio">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">País de Origen</label>
                            <input type="text" 
                                   name="pais_origen" 
                                   class="form-control" 
                                   value="{{ old('pais_origen', $orden->pais_origen) }}"
                                   placeholder="Ej: China">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Estado *</label>
                    <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                        <option value="pendiente" {{ (old('estado', $orden->estado) == 'pendiente') ? 'selected' : '' }}>📋 Pendiente</option>
                        <option value="en_fabricacion" {{ (old('estado', $orden->estado) == 'en_fabricacion') ? 'selected' : '' }}>🏗️ En Fabricación</option>
                        <option value="en_transito" {{ (old('estado', $orden->estado) == 'en_transito') ? 'selected' : '' }}>🚢 En Tránsito</option>
                        <option value="en_puerto" {{ (old('estado', $orden->estado) == 'en_puerto') ? 'selected' : '' }}>⚓ En Puerto</option>
                        <option value="recibida" {{ (old('estado', $orden->estado) == 'recibida') ? 'selected' : '' }}>📦 Recibida</option>
                        <option value="cancelada" {{ (old('estado', $orden->estado) == 'cancelada') ? 'selected' : '' }}>❌ Cancelada</option>
                    </select>
                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>

                {{-- 👇 SECCIÓN DE MÁQUINAS (LO QUE FALTABA) --}}
                <div class="card-header" style="margin-top: 0;">
                    <i class="fas fa-cog"></i> Información de Máquinas
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Modelo de Máquina</label>
                            <input type="text" 
                                   name="modelo_maquina" 
                                   id="modelo_maquina" 
                                   class="form-control @error('modelo_maquina') is-invalid @enderror" 
                                   value="{{ old('modelo_maquina', $orden->modelo_maquina) }}" 
                                   placeholder="Ej: Retroexcavadora CAT 420">
                            <small class="text-muted">Modelo genérico si no usas catálogo</small>
                            @error('modelo_maquina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Cantidad de Máquinas *</label>
                            <input type="number" 
                                   name="cantidad_maquinas" 
                                   id="cantidad_maquinas" 
                                   class="form-control @error('cantidad_maquinas') is-invalid @enderror" 
                                   min="1" 
                                   value="{{ old('cantidad_maquinas', $orden->cantidad_maquinas ?? 1) }}" 
                                   required>
                            <small class="text-muted">Número de máquinas que incluye esta orden</small>
                            @error('cantidad_maquinas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>Nota:</strong> Cuando cambies el estado a <strong>"Recibida"</strong>, se crearán automáticamente <span id="cantidadNota">{{ old('cantidad_maquinas', $orden->cantidad_maquinas ?? 1) }}</span> máquina(s) en el inventario de "Maquinaria Disponible".
                </div>
                {{-- 👆 FIN DE SECCIÓN DE MÁQUINAS --}}

                <hr>

                <div class="form-group">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" 
                              class="form-control @error('observaciones') is-invalid @enderror" 
                              rows="4"
                              placeholder="Información adicional...">{{ old('observaciones', $orden->observaciones) }}</textarea>
                    @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="actions">
                    <a href="{{ route('importaciones.show', $orden->id) }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Actualizar Orden
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Actualizar el mensaje de la nota cuando cambia la cantidad
        const cantidadInput = document.getElementById('cantidad_maquinas');
        const cantidadNota = document.getElementById('cantidadNota');
        
        if (cantidadInput) {
            cantidadInput.addEventListener('input', function(e) {
                const cantidad = e.target.value || 1;
                if (cantidadNota) {
                    cantidadNota.textContent = cantidad;
                }
            });
        }
    </script>
</body>
</html>