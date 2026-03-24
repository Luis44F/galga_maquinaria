<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Detalles de Máquina</title>
    
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
            --info: #3b82f6;
            --card-bg: #111827;
            --card-border: #1f2937;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
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
            margin-bottom: 24px;
        }

        .card-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 20px;
            font-weight: 600;
            color: var(--text-light);
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--card-border);
            flex-wrap: wrap;
            gap: 12px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--card-border);
            flex-wrap: wrap;
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-label {
            width: 180px;
            color: var(--text-dim);
            font-weight: 500;
        }

        .detail-value {
            flex: 1;
            color: var(--text-light);
            font-weight: 600;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
        }

        .badge-warning { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .badge-success { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .badge-info { background: rgba(14, 165, 233, 0.2); color: var(--primary); }
        .badge-primary { background: rgba(59, 130, 246, 0.2); color: var(--info); }
        .badge-secondary { background: rgba(100, 116, 139, 0.2); color: #94a3b8; }
        .badge-danger { background: rgba(239, 68, 68, 0.2); color: var(--danger); }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            justify-content: flex-end;
            flex-wrap: wrap;
        }

        .btn-edit, .btn-delete, .btn-action {
            padding: 10px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-edit { background: var(--warning); color: #0a0f1c; }
        .btn-delete { background: var(--danger); color: white; }
        .btn-action { background: var(--primary); color: white; }

        .btn-edit:hover, .btn-delete:hover, .btn-action:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .text-muted {
            color: var(--text-dim);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            padding: 12px;
            color: var(--text-dim);
            font-weight: 500;
            border-bottom: 1px solid var(--card-border);
        }

        td {
            padding: 12px;
            border-bottom: 1px solid var(--card-border);
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }
            
            .card {
                padding: 20px;
            }
            
            .detail-label {
                width: 100%;
                margin-bottom: 8px;
            }
            
            .detail-value {
                width: 100%;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn-edit, .btn-delete, .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detalles de Máquina</h1>
            <a href="{{ url()->previous() }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card">
            <div class="card-title">
                <span><i class="fas fa-cog" style="color: var(--primary); margin-right: 8px;"></i> Máquina #{{ $maquina->id }}</span>
                <span class="badge badge-{{ $maquina->estado_color }}">
                    {{ $maquina->estado_display }}
                </span>
            </div>

            <div class="detail-row">
                <div class="detail-label">Modelo:</div>
                <div class="detail-value">
                    @php
                        // Cargar el modelo manualmente si no está cargado
                        $modeloData = $maquina->modelo;
                        if (!$modeloData && $maquina->modelo_id) {
                            $modeloData = \App\Models\MaquinaModelo::find($maquina->modelo_id);
                        }
                    @endphp
                    
                    @if($modeloData)
                        <strong>{{ $modeloData->marca ?? 'N/A' }} {{ $modeloData->modelo ?? 'N/A' }}</strong>
                        <br><small class="text-muted">ID: {{ $modeloData->id }}</small>
                    @else
                        <span class="text-muted">No especificado (ID en tabla: {{ $maquina->modelo_id ?? 'NULL' }})</span>
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Número de Serie:</div>
                <div class="detail-value"><code>{{ $maquina->numero_serie ?? 'N/A' }}</code></div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Año de Fabricación:</div>
                <div class="detail-value">{{ $maquina->año_fabricacion ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Ubicación Actual:</div>
                <div class="detail-value">{{ $maquina->ubicacion_actual ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Precio de Compra:</div>
                <div class="detail-value">{{ $maquina->precio_compra_formateado ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Precio de Venta:</div>
                <div class="detail-value">{{ $maquina->precio_venta_formateado ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Fecha de Ingreso:</div>
                <div class="detail-value">
                    @if($maquina->fecha_ingreso)
                        {{ $maquina->fecha_ingreso->format('d/m/Y') }}
                    @else
                        N/A
                    @endif
                </div>
            </div>

            @if($maquina->fecha_venta)
            <div class="detail-row">
                <div class="detail-label">Fecha de Venta:</div>
                <div class="detail-value">
                    @if($maquina->fecha_venta)
                        {{ $maquina->fecha_venta->format('d/m/Y') }}
                    @else
                        N/A
                    @endif
                </div>
            </div>
            @endif

            @if($maquina->ordenCompra)
            <div class="detail-row">
                <div class="detail-label">Orden de Importación:</div>
                <div class="detail-value">
                    <a href="{{ route('importaciones.show', $maquina->ordenCompra->id) }}" style="color: var(--primary); text-decoration: none;">
                        {{ $maquina->ordenCompra->numero_orden ?? 'N/A' }}
                    </a>
                </div>
            </div>
            @endif

            @if($maquina->observaciones)
            <div class="detail-row">
                <div class="detail-label">Observaciones:</div>
                <div class="detail-value">{{ $maquina->observaciones }}</div>
            </div>
            @endif

            <div class="actions">
                <a href="{{ route('maquinas.edit', $maquina->id) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Editar Máquina
                </a>
                <form action="{{ route('maquinas.destroy', $maquina->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar esta máquina?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>

        @if($maquina->seguimientosEstado && $maquina->seguimientosEstado->isNotEmpty())
        <div class="card">
            <div class="card-title">
                <span><i class="fas fa-history" style="color: var(--info); margin-right: 8px;"></i> Historial de Estados</span>
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                        </thead>
                        <tbody>
                            @foreach($maquina->seguimientosEstado as $seguimiento)
                            <tr>
                                <td style="padding: 12px; border-bottom: 1px solid var(--card-border);">
                                    @if($seguimiento->created_at)
                                        {{ $seguimiento->created_at->format('d/m/Y H:i') }}
                                    @else
                                        N/A
                                    @endif
                                
                                <td style="padding: 12px; border-bottom: 1px solid var(--card-border);">
                                    <span class="badge badge-{{ $seguimiento->estado_color ?? 'secondary' }}">
                                        {{ $seguimiento->estado_display ?? $seguimiento->estado }}
                                    </span>
                                
                                <td style="padding: 12px; border-bottom: 1px solid var(--card-border);">{{ $seguimiento->observaciones ?? '-' }}
                              
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</body>
</html>