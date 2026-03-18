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
            --secondary: #64748b;
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

        .detail-row {
            display: flex;
            margin-bottom: 16px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--card-border);
        }

        .detail-label {
            width: 200px;
            color: var(--text-dim);
            font-weight: 500;
        }

        .detail-value {
            flex: 1;
            color: var(--text-light);
            font-weight: 600;
        }

        .badge {
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 14px;
            display: inline-block;
        }

        /* Colores dinámicos para los estados */
        .badge-success { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .badge-warning { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .badge-primary { background: rgba(14, 165, 233, 0.2); color: var(--primary); }
        .badge-info { background: rgba(14, 165, 233, 0.2); color: var(--primary); }
        .badge-danger { background: rgba(239, 68, 68, 0.2); color: var(--danger); }
        .badge-secondary { background: rgba(100, 116, 139, 0.2); color: var(--secondary); }

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
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Detalles de la Máquina</h1>
            <a href="{{ route('maquinaria-disponible.test') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card">
            <div class="detail-row">
                <div class="detail-label">ID:</div>
                <div class="detail-value">#{{ $maquina->id }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Modelo:</div>
                <div class="detail-value">{{ optional($maquina->modelo)->modelo ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Marca:</div>
                <div class="detail-value">{{ optional($maquina->modelo)->marca ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Categoría:</div>
                <div class="detail-value">{{ optional(optional($maquina->modelo)->categoria)->nombre ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Número de Serie:</div>
                <div class="detail-value">{{ $maquina->numero_serie ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Año de Fabricación:</div>
                <div class="detail-value">{{ $maquina->año_fabricacion ?? 'N/A' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Estado:</div>
                <div class="detail-value">
                    @php
                        $estadoColors = [
                            'disponible' => 'success',
                            'en_bodega' => 'info',
                            'en_transito' => 'warning',
                            'en_puerto' => 'primary',
                            'reparacion' => 'danger',
                            'fabricacion' => 'info',
                            'pendiente_despacho' => 'warning',
                            'cancelado' => 'secondary',
                            'vendida' => 'secondary'
                        ];
                        $estadoTextos = [
                            'disponible' => '📦 Disponible',
                            'en_bodega' => '🏭 En Bodega',
                            'en_transito' => '🚢 En Tránsito',
                            'en_puerto' => '⚓ En Puerto',
                            'reparacion' => '🔧 En Reparación',
                            'fabricacion' => '🏗️ En Fabricación',
                            'pendiente_despacho' => '⏳ Vendida (Pendiente Despacho)',
                            'cancelado' => '❌ Cancelado',
                            'vendida' => '💰 Vendida'
                        ];
                    @endphp
                    <span class="badge badge-{{ $estadoColors[$maquina->estado] ?? 'secondary' }}">
                        {{ $estadoTextos[$maquina->estado] ?? $maquina->estado }}
                    </span>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Precio de Compra:</div>
                <div class="detail-value">${{ number_format($maquina->precio_compra, 0, ',', '.') }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Precio de Venta:</div>
                <div class="detail-value">${{ number_format($maquina->precio_venta, 0, ',', '.') }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Fecha de Ingreso:</div>
                <div class="detail-value">{{ $maquina->created_at->format('d/m/Y') }}</div>
            </div>

            @if($maquina->observaciones)
            <div class="detail-row" style="border-bottom: none;">
                <div class="detail-label">Observaciones:</div>
                <div class="detail-value" style="font-weight: 400; color: var(--text-dim);">
                    {{ $maquina->observaciones }}
                </div>
            </div>
            @endif

            <div class="actions">
                <a href="{{ route('maquinas.edit', $maquina->id) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <button onclick="eliminarMaquina({{ $maquina->id }})" class="btn-delete">
                    <i class="fas fa-trash"></i> Eliminar
                </button>
            </div>
        </div>
    </div>

    <script>
        function eliminarMaquina(id) {
            if (confirm('¿Estás seguro de eliminar esta máquina?')) {
                fetch(`/maquinas/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route("maquinaria-disponible.test") }}';
                    }
                });
            }
        }
    </script>
</body>
</html>