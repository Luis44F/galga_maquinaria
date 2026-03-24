<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Detalles de Orden</title>
    
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
            max-width: 1000px;
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
        }

        .detail-row {
            display: flex;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--card-border);
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th {
            text-align: left;
            padding: 12px;
            color: var(--text-dim);
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--card-border);
        }

        td {
            padding: 16px 12px;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-light);
            font-size: 14px;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            justify-content: flex-end;
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
        }

        .btn-edit { background: var(--warning); color: #0a0f1c; }
        .btn-delete { background: var(--danger); color: white; }
        .btn-action { background: var(--primary); color: white; }

        .btn-edit:hover, .btn-delete:hover, .btn-action:hover {
            transform: translateY(-2px);
            filter: brightness(1.1);
        }

        .alert-empty {
            background: rgba(245, 158, 11, 0.1);
            border: 1px dashed var(--warning);
            padding: 20px;
            border-radius: 16px;
            text-align: center;
            color: var(--warning);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detalles de la Orden</h1>
            <a href="{{ route('importaciones.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver al listado
            </a>
        </div>

        <div class="card">
            <div class="card-title">
                <span><i class="fas fa-file-invoice" style="color: var(--primary); margin-right: 8px;"></i> Orden #{{ $orden->numero_orden }}</span>
                <span class="badge badge-{{ $orden->estado_color ?? 'info' }}">
                    {{ $orden->estado_display ?? $orden->estado }}
                </span>
            </div>

            <div class="detail-row">
                <div class="detail-label">Proveedor:</div>
                <div class="detail-value">
                    {{ $orden->proveedor }}
                    @if($orden->pais_origen)
                        <br><small style="color: var(--text-dim);">{{ $orden->pais_origen }}</small>
                    @endif
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Modelo de máquina:</div>
                <div class="detail-value">{{ $orden->modelo_maquina ?? 'No especificado' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Cantidad de máquinas:</div>
                <div class="detail-value">{{ $orden->cantidad_maquinas ?? 1 }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Fecha de Orden:</div>
                <div class="detail-value">{{ $orden->fecha_orden instanceof \Carbon\Carbon ? $orden->fecha_orden->format('d/m/Y') : $orden->fecha_orden }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Estimada Llegada:</div>
                <div class="detail-value">
                    @if($orden->fecha_estimada_llegada)
                        {{ $orden->fecha_estimada_llegada instanceof \Carbon\Carbon ? $orden->fecha_estimada_llegada->format('d/m/Y') : $orden->fecha_estimada_llegada }}
                    @else
                        <span style="color: var(--text-dim);">No definida</span>
                    @endif
                </div>
            </div>

            @if($orden->puerto_llegada)
            <div class="detail-row">
                <div class="detail-label">Puerto Llegada:</div>
                <div class="detail-value"><i class="fas fa-anchor" style="color: var(--success);"></i> {{ $orden->puerto_llegada }}</div>
            </div>
            @endif

            <div class="actions">
                <a href="{{ route('importaciones.edit', $orden->id) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Editar Orden
                </a>
                <form action="{{ route('importaciones.destroy', $orden->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar esta orden?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-delete">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-title">
                <span><i class="fas fa-cog" style="color: var(--success); margin-right: 8px;"></i> Máquinas Vinculadas</span>
                @if($orden->maquinas->count() > 0)
                    <span class="badge badge-secondary">{{ $orden->maquinas->count() }} unidades</span>
                @endif
            </div>

            @if($orden->maquinas->count() > 0)
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Modelo / Marca</th>
                                <th>Serie</th>
                                <th>Estado</th>
                                <th>Precio Venta</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orden->maquinas as $maquina)
                            <tr>
                                <td>
                                    <strong>{{ $maquina->modelo->modelo ?? 'N/A' }}</strong>
                                    <br><small style="color: var(--text-dim);">{{ $maquina->modelo->marca ?? 'S/M' }}</small>
                                </td>
                                <td><code>{{ $maquina->numero_serie ?? 'Pte.' }}</code></td>
                                <td>
                                    <span class="badge badge-{{ $maquina->estado_color }}">
                                        {{ $maquina->estado_display }}
                                    </span>
                                </td>
                                <td>{{ $maquina->precio_venta_formateado }}</td>
                                <td>
                                    <a href="{{ route('maquinas.show', $maquina->id) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @elseif($orden->estado == 'recibida')
                <div class="alert-empty">
                    <i class="fas fa-exclamation-circle" style="font-size: 24px; margin-bottom: 12px; display: block;"></i>
                    <p>La orden está marcada como <strong>Recibida</strong>, pero no se han generado las máquinas individuales.</p>
                    <button onclick="crearMaquinasManual({{ $orden->id }})" class="btn-action" style="margin-top: 16px;">
                        <i class="fas fa-plus-circle"></i> Generar Máquinas ahora
                    </button>
                </div>
            @else
                <p style="color: var(--text-dim); text-align: center; padding: 20px;">
                    Las máquinas se generarán automáticamente cuando el estado de la orden cambie a "Recibida".
                </p>
            @endif
        </div>
    </div>

    <script>
        function crearMaquinasManual(ordenId) {
            if (confirm('¿Deseas generar los registros individuales de máquinas para esta orden?')) {
                fetch(`/importaciones/${ordenId}/crear-maquinas`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>
</body>
</html>