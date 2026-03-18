<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Detalles de Orden</title>
    
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
            max-width: 900px;
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
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
        }

        .badge-warning { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .badge-success { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .badge-info { background: rgba(14, 165, 233, 0.2); color: var(--primary); }
        .badge-primary { background: rgba(59, 130, 246, 0.2); color: var(--info); }
        .badge-secondary { background: rgba(100, 116, 139, 0.2); color: #94a3b8; }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            justify-content: flex-end;
        }

        .btn-edit, .btn-delete {
            padding: 10px 24px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
        }

        .btn-edit {
            background: var(--warning);
            color: #0a0f1c;
        }

        .btn-delete {
            background: var(--danger);
            color: white;
        }

        .btn-edit:hover, .btn-delete:hover {
            transform: translateY(-2px);
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
                <i class="fas fa-file-invoice" style="color: var(--primary);"></i>
                Orden #{{ $orden->numero_orden }}
            </div>

            <div class="detail-row">
                <div class="detail-label">ID:</div>
                <div class="detail-value">#{{ $orden->id }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Número de Orden:</div>
                <div class="detail-value">{{ $orden->numero_orden }}</div>
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
                <div class="detail-label">Fecha de Orden:</div>
                <div class="detail-value">{{ $orden->fecha_orden instanceof \Carbon\Carbon ? $orden->fecha_orden->format('d/m/Y') : $orden->fecha_orden }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Fecha Estimada Llegada:</div>
                <div class="detail-value">
                    @if($orden->fecha_estimada_llegada)
                        {{ $orden->fecha_estimada_llegada instanceof \Carbon\Carbon ? $orden->fecha_estimada_llegada->format('d/m/Y') : $orden->fecha_estimada_llegada }}
                    @else
                        <span class="text-dim">No definida</span>
                    @endif
                </div>
            </div>

            @if($orden->fecha_llegada_real)
            <div class="detail-row">
                <div class="detail-label">Fecha Llegada Real:</div>
                <div class="detail-value">{{ $orden->fecha_llegada_real instanceof \Carbon\Carbon ? $orden->fecha_llegada_real->format('d/m/Y') : $orden->fecha_llegada_real }}</div>
            </div>
            @endif

            @if($orden->puerto_salida || $orden->puerto_llegada)
            <div class="detail-row">
                <div class="detail-label">Puertos:</div>
                <div class="detail-value">
                    @if($orden->puerto_salida)
                        <i class="fas fa-map-marker-alt" style="color: var(--warning);"></i> Salida: {{ $orden->puerto_salida }}
                        <br>
                    @endif
                    @if($orden->puerto_llegada)
                        <i class="fas fa-anchor" style="color: var(--success);"></i> Llegada: {{ $orden->puerto_llegada }}
                    @endif
                </div>
            </div>
            @endif

            <div class="detail-row">
                <div class="detail-label">Estado:</div>
                <div class="detail-value">
                    @php
                        $estadoColors = [
                            'pendiente' => 'warning',
                            'en_fabricacion' => 'info',
                            'en_transito' => 'primary',
                            'en_puerto' => 'info',
                            'recibida' => 'success',
                            'cancelada' => 'secondary'
                        ];
                        $estadoTextos = [
                            'pendiente' => '📋 Pendiente',
                            'en_fabricacion' => '🏗️ En Fabricación',
                            'en_transito' => '🚢 En Tránsito',
                            'en_puerto' => '⚓ En Puerto',
                            'recibida' => '📦 Recibida',
                            'cancelada' => '❌ Cancelada'
                        ];
                    @endphp
                    <span class="badge badge-{{ $estadoColors[$orden->estado] ?? 'secondary' }}">
                        {{ $estadoTextos[$orden->estado] ?? $orden->estado }}
                    </span>
                </div>
            </div>

            @if($orden->observaciones)
            <div class="detail-row">
                <div class="detail-label">Observaciones:</div>
                <div class="detail-value">{{ $orden->observaciones }}</div>
            </div>
            @endif

            <div class="detail-row">
                <div class="detail-label">Creado por:</div>
                <div class="detail-value">
                    @if($orden->creador)
                        {{ $orden->creador->name }}
                        <br><small style="color: var(--text-dim);">{{ $orden->created_at ? ($orden->created_at instanceof \Carbon\Carbon ? $orden->created_at->format('d/m/Y H:i') : $orden->created_at) : 'N/A' }}</small>
                    @else
                        Sistema
                    @endif
                </div>
            </div>

            <div class="actions">
                {{-- ✅ CORREGIDO: Usa $orden->id en lugar de $orden->numero_orden --}}
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

        @if(isset($orden->maquinas) && $orden->maquinas->count() > 0)
        <div class="card">
            <div class="card-title">
                <i class="fas fa-cog" style="color: var(--success);"></i>
                Máquinas de esta Importación
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding: 12px; color: var(--text-dim);">ID</th>
                            <th style="text-align: left; padding: 12px; color: var(--text-dim);">Serie</th>
                            <th style="text-align: left; padding: 12px; color: var(--text-dim);">Estado</th>
                            <th style="text-align: left; padding: 12px; color: var(--text-dim);">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orden->maquinas as $maquina)
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid var(--card-border);">#{{ $maquina->id }}</td>
                            <td style="padding: 12px; border-bottom: 1px solid var(--card-border);">{{ $maquina->numero_serie ?? 'N/A' }}</td>
                            <td style="padding: 12px; border-bottom: 1px solid var(--card-border);">{{ $maquina->estado_display ?? $maquina->estado }}</td>
                            <td style="padding: 12px; border-bottom: 1px solid var(--card-border);">
                                <a href="{{ route('maquinas.show', $maquina->id) }}" style="color: var(--primary);">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</body>
</html>