<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Listado de Máquinas</title>
    
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
            --dark-bg: #0a0f1c;
            --card-bg: #111827;
            --card-border: #1f2937;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
        }

        h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            overflow: hidden;
        }

        th {
            text-align: left;
            padding: 16px;
            background: rgba(14, 165, 233, 0.1);
            color: var(--text-dim);
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid var(--card-border);
            color: var(--text-light);
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: rgba(14, 165, 233, 0.05);
        }

        .badge {
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .badge-warning { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .badge-info { background: rgba(14, 165, 233, 0.2); color: var(--primary); }
        .badge-danger { background: rgba(239, 68, 68, 0.2); color: var(--danger); }
        .badge-secondary { background: rgba(100, 116, 139, 0.2); color: #94a3b8; }
    </style>
</head>
<body>
    <h1>Listado de Máquinas</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Modelo</th>
                <th>Marca</th>
                <th>Número de Serie</th>
                <th>Año</th>
                <th>Precio Venta</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($maquinas as $maquina)
            <tr>
                <td>#{{ $maquina->id }}</td>
                <td>{{ optional($maquina->modelo)->modelo ?? 'N/A' }}</td>
                <td>{{ optional($maquina->modelo)->marca ?? 'N/A' }}</td>
                <td>{{ $maquina->numero_serie ?? 'N/A' }}</td>
                <td>{{ $maquina->año_fabricacion ?? 'N/A' }}</td>
                <td>${{ number_format($maquina->precio_venta, 0, ',', '.') }}</td>
                <td>
                    @php
                        $estadoColors = [
                            'disponible' => 'success',
                            'en_bodega' => 'info',
                            'en_transito' => 'warning',
                            'en_puerto' => 'info',
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
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center; padding: 40px;">
                    <i class="fas fa-cog fa-3x" style="color: var(--text-dim); margin-bottom: 16px;"></i>
                    <p style="color: var(--text-dim);">No hay máquinas registradas</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>