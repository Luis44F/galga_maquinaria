<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Lista de Órdenes</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
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
            --dark-bg: #0a0f1c;
        }

        .table-responsive {
            overflow-x: auto;
            margin: 0 -24px;
            padding: 0 24px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }
        
        th {
            text-align: left;
            padding: 12px 16px;
            background: rgba(14, 165, 233, 0.05);
            color: var(--text-dim);
            font-weight: 500;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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
            display: inline-block;
        }
        
        .badge-warning { background: rgba(245, 158, 11, 0.2); color: var(--warning); }
        .badge-success { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .badge-info { background: rgba(14, 165, 233, 0.2); color: var(--primary); }
        .badge-primary { background: rgba(59, 130, 246, 0.2); color: var(--info); }
        .badge-secondary { background: rgba(100, 116, 139, 0.2); color: var(--text-dim); }
        
        .btn-sm {
            padding: 6px 12px;
            border-radius: 8px;
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }
        
        .btn-sm:hover {
            background: var(--primary);
            color: #0a0f1c;
            border-color: var(--primary);
        }
        
        .text-center {
            text-align: center;
        }
        
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 8px;
        }
        
        .page-link {
            padding: 8px 12px;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 6px;
            color: var(--text-dim);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .page-link:hover {
            background: var(--primary);
            color: #0a0f1c;
        }
        
        .btn-primary {
            background: var(--primary);
            color: #0a0f1c;
            padding: 10px 20px;
            border-radius: 10px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: #0284c7;
            transform: translateY(-2px);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }
        
        .empty-state i {
            font-size: 48px;
            color: var(--text-dim);
            margin-bottom: 16px;
        }
        
        .empty-state p {
            color: var(--text-dim);
            margin-bottom: 16px;
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                margin: 0 -16px;
                padding: 0 16px;
            }
            
            th, td {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>N° Orden</th>
                    <th>Proveedor</th>
                    <th>País</th>
                    <th>Modelo</th>
                    <th>Cant.</th>
                    <th>Fecha Orden</th>
                    <th>Fecha Est. Llegada</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </thead>
            <tbody>
                @forelse($ordenes as $orden)
                <tr>
                    <td>
                        <strong>{{ $orden->numero_orden }}</strong><br>
                        <small style="color: var(--text-dim);">ID: #{{ $orden->id }}</small>
                    </td>
                    <td>{{ $orden->proveedor }}</td>
                    <td>{{ $orden->pais_origen ?? 'N/A' }}</td>
                    <td>
                        @if($orden->modelo_maquina)
                            <strong>{{ $orden->modelo_maquina }}</strong>
                        @else
                            <span style="color: var(--text-dim);">No especificado</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="badge" style="background: rgba(14, 165, 233, 0.2); color: var(--primary);">
                            {{ $orden->cantidad_maquinas ?? 1 }}
                        </span>
                    </td>
                    <td>{{ $orden->fecha_orden->format('d/m/Y') }}</td>
                    <td>
                        @if($orden->fecha_estimada_llegada)
                            {{ $orden->fecha_estimada_llegada->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $orden->estado_color }}">
                            {{ $orden->estado_display }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('importaciones.show', $orden->id) }}" class="btn-sm" title="Ver detalles">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('importaciones.edit', $orden->id) }}" class="btn-sm" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button onclick="eliminarOrden({{ $orden->id }})" class="btn-sm" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="empty-state">
                        <i class="fas fa-file-invoice"></i>
                        <p>No hay órdenes registradas</p>
                        <a href="{{ route('importaciones.create') }}" class="btn-primary">
                            <i class="fas fa-plus"></i> Crear Primera Orden
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($ordenes, 'links') && $ordenes->total() > $ordenes->perPage())
    <div class="pagination">
        {{ $ordenes->links() }}
    </div>
    @endif

    <script>
        const csrfToken = '{{ csrf_token() }}';
        
        function eliminarOrden(id) {
            if (confirm('¿Estás seguro de eliminar esta orden?\nEsta acción no se puede deshacer.')) {
                fetch(`/importaciones/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
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
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar la orden');
                });
            }
        }
    </script>
</body>
</html>