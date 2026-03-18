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
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
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
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
        }

        /* Estilo para validación de errores */
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

        .btn-primary {
            background: var(--primary);
            color: #0a0f1c;
            border: none;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
            margin-top: 24px;
        }

        .alert-info {
            background: rgba(14, 165, 233, 0.1);
            border: 1px solid rgba(14, 165, 233, 0.2);
            color: var(--primary);
            padding: 12px;
            border-radius: 12px;
            margin-top: 12px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Editar Máquina</h1>
            <a href="{{ route('maquinaria-disponible.test') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fas fa-edit"></i> Formulario de Edición
            </div>

            <form action="{{ route('maquinas.update', $maquina->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label class="form-label">Modelo</label>
                    <select name="modelo_id" class="form-select" required>
                        @foreach($modelos as $modelo)
                            <option value="{{ $modelo->id }}" {{ $maquina->modelo_id == $modelo->id ? 'selected' : '' }}>
                                {{ $modelo->marca }} {{ $modelo->modelo }}
                                @if($modelo->categoria)
                                    ({{ $modelo->categoria->nombre }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Número de Serie</label>
                    <input type="text" name="numero_serie" class="form-control" value="{{ $maquina->numero_serie }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Año de Fabricación</label>
                    <input type="number" name="año_fabricacion" class="form-control" value="{{ $maquina->año_fabricacion }}">
                </div>

                <div class="form-group">
                    <label class="form-label">Estado <span class="text-danger">*</span></label>
                    <select name="estado" class="form-select @error('estado') is-invalid @enderror" required>
                        <option value="">-- Seleccione estado --</option>
                        <option value="pendiente" {{ $maquina->estado == 'pendiente' ? 'selected' : '' }}>📋 Pendiente</option>
                        <option value="en_fabricacion" {{ $maquina->estado == 'en_fabricacion' ? 'selected' : '' }}>🏗️ En Fabricación</option>
                        <option value="en_transito" {{ $maquina->estado == 'en_transito' ? 'selected' : '' }}>🚢 En Tránsito</option>
                        <option value="en_puerto" {{ $maquina->estado == 'en_puerto' ? 'selected' : '' }}>⚓ En Puerto</option>
                        <option value="recibida" {{ $maquina->estado == 'recibida' ? 'selected' : '' }}>📦 Recibida en Bodega</option>
                        <option value="cancelada" {{ $maquina->estado == 'cancelada' ? 'selected' : '' }}>❌ Cancelada</option>
                    </select>
                    
                    @if(in_array($maquina->estado, ['recibida', 'cancelada']))
                        <div class="alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> Si cambias este estado, se actualizarán automáticamente todas las máquinas vinculadas a esta orden.
                        </div>
                    @endif

                    @error('estado')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Precio de Compra</label>
                    <input type="number" name="precio_compra" class="form-control" value="{{ $maquina->precio_compra }}" step="0.01">
                </div>

                <div class="form-group">
                    <label class="form-label">Precio de Venta</label>
                    <input type="number" name="precio_venta" class="form-control" value="{{ $maquina->precio_venta }}" step="0.01" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" rows="4">{{ $maquina->observaciones }}</textarea>
                </div>

                <div class="actions">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Actualizar Máquina
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>