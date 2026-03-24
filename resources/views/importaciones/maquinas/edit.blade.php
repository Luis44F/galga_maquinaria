<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Editar Máquina</title>
    
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
            max-width: 800px;
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
                <h1>Editar Máquina</h1>
                <p style="color: var(--text-dim); margin-top: 4px;">Modifica los datos de la máquina #{{ $maquina->id }}</p>
            </div>
            <a href="{{ route('maquinas.show', $maquina->id) }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger" style="background: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); color: var(--danger); padding: 12px; border-radius: 12px; margin-bottom: 20px;">
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
                <i class="fas fa-edit"></i> Información de la Máquina
                <span class="badge" style="background: rgba(14, 165, 233, 0.1); color: var(--primary); padding: 4px 10px; border-radius: 20px; margin-left: auto;">ID: {{ $maquina->id }}</span>
            </div>

            <form action="{{ route('maquinas.update', $maquina->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Modelo</label>
                            <select name="modelo_id" class="form-select @error('modelo_id') is-invalid @enderror" required>
                                <option value="">Seleccione un modelo</option>
                                @foreach($modelos ?? [] as $modelo)
                                    <option value="{{ $modelo->id }}" 
                                        {{ (old('modelo_id', $maquina->modelo_id) == $modelo->id) ? 'selected' : '' }}>
                                        {{ $modelo->marca }} {{ $modelo->modelo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('modelo_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Número de Serie</label>
                            <input type="text" 
                                   name="numero_serie" 
                                   class="form-control @error('numero_serie') is-invalid @enderror" 
                                   value="{{ old('numero_serie', $maquina->numero_serie) }}"
                                   placeholder="Ej: CAT-2024-001">
                            @error('numero_serie')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Año de Fabricación</label>
                            <input type="number" 
                                   name="año_fabricacion" 
                                   class="form-control @error('año_fabricacion') is-invalid @enderror" 
                                   value="{{ old('año_fabricacion', $maquina->año_fabricacion) }}"
                                   min="1900"
                                   max="{{ date('Y') }}">
                            @error('año_fabricacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                                <option value="disponible" {{ old('estado', $maquina->estado) == 'disponible' ? 'selected' : '' }}>📦 Disponible</option>
                                <option value="en_bodega" {{ old('estado', $maquina->estado) == 'en_bodega' ? 'selected' : '' }}>🏭 En Bodega</option>
                                <option value="en_transito" {{ old('estado', $maquina->estado) == 'en_transito' ? 'selected' : '' }}>🚢 En Tránsito</option>
                                <option value="en_puerto" {{ old('estado', $maquina->estado) == 'en_puerto' ? 'selected' : '' }}>⚓ En Puerto</option>
                                <option value="reparacion" {{ old('estado', $maquina->estado) == 'reparacion' ? 'selected' : '' }}>🔧 En Reparación</option>
                                <option value="fabricacion" {{ old('estado', $maquina->estado) == 'fabricacion' ? 'selected' : '' }}>🏗️ En Fabricación</option>
                                <option value="pendiente_despacho" {{ old('estado', $maquina->estado) == 'pendiente_despacho' ? 'selected' : '' }}>⏳ Pendiente Despacho</option>
                                <option value="cancelado" {{ old('estado', $maquina->estado) == 'cancelado' ? 'selected' : '' }}>❌ Cancelado</option>
                                <option value="vendida" {{ old('estado', $maquina->estado) == 'vendida' ? 'selected' : '' }}>💰 Vendida</option>
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label">Ubicación Actual</label>
                            <input type="text" 
                                   name="ubicacion_actual" 
                                   class="form-control @error('ubicacion_actual') is-invalid @enderror" 
                                   value="{{ old('ubicacion_actual', $maquina->ubicacion_actual) }}"
                                   placeholder="Ej: Bodega Central">
                            @error('ubicacion_actual')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Precio de Compra</label>
                            <input type="number" 
                                   name="precio_compra" 
                                   class="form-control @error('precio_compra') is-invalid @enderror" 
                                   value="{{ old('precio_compra', $maquina->precio_compra) }}"
                                   step="0.01"
                                   placeholder="0.00">
                            @error('precio_compra')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Precio de Venta</label>
                            <input type="number" 
                                   name="precio_venta" 
                                   class="form-control @error('precio_venta') is-invalid @enderror" 
                                   value="{{ old('precio_venta', $maquina->precio_venta) }}"
                                   step="0.01"
                                   placeholder="0.00">
                            @error('precio_venta')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" 
                              class="form-control @error('observaciones') is-invalid @enderror" 
                              rows="4"
                              placeholder="Información adicional...">{{ old('observaciones', $maquina->observaciones) }}</textarea>
                    @error('observaciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <input type="checkbox" name="activo" value="1" {{ old('activo', $maquina->activo) ? 'checked' : '' }} class="form-checkbox">
                        Activo
                    </label>
                </div>

                <div class="actions">
                    <a href="{{ route('maquinas.show', $maquina->id) }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Actualizar Máquina
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>