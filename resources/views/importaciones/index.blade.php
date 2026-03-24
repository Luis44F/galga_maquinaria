<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Lista de Órdenes</title>
    
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

        .btn-primary {
            background: var(--primary);
            color: #0a0f1c;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: #0284c7;
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

        .badge-warning { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .badge-success { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .badge-info { background: rgba(14, 165, 233, 0.2); color: var(--primary); }
        .badge-secondary { background: rgba(100, 116, 139, 0.2); color: #94a3b8; }

        .btn-sm {
            padding: 6px 10px;
            border-radius: 6px;
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-sm:hover {
            background: var(--primary);
            color: #0a0f1c;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Órdenes de Importación</h1>
        <div>
            <a href="{{ route('dashboard.importaciones') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
            <a href="{{ route('importaciones.create') }}" class="btn-primary" style="margin-left: 10px;">
                <i class="fas fa-plus"></i> Nueva Orden
            </a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>N° Orden</th>
                <th>Proveedor</th>
                <th>País</th>
                <th>Modelo</th>
                <th>Cant.</th>
                <th>Fecha Orden</th>
                <th>Fecha Llegada</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ordenes as $orden)
            <tr>
                <td>#{{ $orden->id }}</td>
                <td><strong>{{ $orden->numero_orden }}</strong></td>
                <td>{{ $orden->proveedor }}</td>
                <td>{{ $orden->pais_origen ?? 'N/A' }}</td>
                <td>{{ $orden->modelo_maquina ?? 'N/A' }}</td>
                <td>{{ $orden->cantidad_maquinas ?? 1 }}</td>
                <td>{{ $orden->fecha_orden->format('d/m/Y') }}</td>
                <td>
                    @if($orden->fecha_estimada_llegada)
                        {{ $orden->fecha_estimada_llegada->format('d/m/Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
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
                            'en_fabricacion' => '🏗️ Fabricación',
                            'en_transito' => '🚢 Tránsito',
                            'en_puerto' => '⚓ Puerto',
                            'recibida' => '📦 Recibida',
                            'cancelada' => '❌ Cancelada'
                        ];
                    @endphp
                    <span class="badge badge-{{ $estadoColors[$orden->estado] ?? 'secondary' }}">
                        {{ $estadoTextos[$orden->estado] ?? $orden->estado }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('importaciones.show', $orden->id) }}" class="btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('importaciones.edit', $orden->id) }}" class="btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align: center; padding: 40px;">
                    <p>No hay órdenes registradas</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if(method_exists($ordenes, 'links'))
    <div style="margin-top: 20px;">
        {{ $ordenes->links() }}
    </div>
    @endif
</body>
</html>