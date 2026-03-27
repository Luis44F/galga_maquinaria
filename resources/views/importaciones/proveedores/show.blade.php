<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Detalles del Proveedor</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
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
        .container { max-width: 900px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
        h1 { font-size: 28px; font-weight: 700; color: var(--text-light); }
        .btn-back { background: transparent; border: 1px solid var(--card-border); color: var(--text-dim); padding: 10px 20px; border-radius: 10px; text-decoration: none; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-back:hover { background: var(--card-border); color: var(--text-light); }
        .card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; padding: 32px; margin-bottom: 24px; }
        .card-title { display: flex; justify-content: space-between; align-items: center; font-size: 20px; font-weight: 600; color: var(--text-light); margin-bottom: 20px; padding-bottom: 12px; border-bottom: 1px solid var(--card-border); flex-wrap: wrap; gap: 12px; }
        .detail-row { display: flex; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--card-border); flex-wrap: wrap; }
        .detail-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
        .detail-label { width: 180px; color: var(--text-dim); font-weight: 500; }
        .detail-value { flex: 1; color: var(--text-light); font-weight: 600; }
        .badge { padding: 6px 12px; border-radius: 30px; font-size: 13px; font-weight: 600; display: inline-block; }
        .badge-success { background: rgba(16, 185, 129, 0.2); color: var(--success); }
        .badge-primary { background: rgba(14, 165, 233, 0.2); color: var(--primary); }
        .badge-secondary { background: rgba(100, 116, 139, 0.2); color: #94a3b8; }
        .section-title { font-size: 18px; font-weight: 600; color: var(--primary); margin: 20px 0 16px 0; padding-bottom: 8px; border-bottom: 1px solid var(--card-border); }
        .table-responsive { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th { text-align: left; padding: 12px; background: rgba(14, 165, 233, 0.05); color: var(--text-dim); font-size: 12px; text-transform: uppercase; }
        td { padding: 12px; border-bottom: 1px solid var(--card-border); color: var(--text-light); font-size: 13px; }
        .actions { display: flex; gap: 12px; margin-top: 24px; justify-content: flex-end; flex-wrap: wrap; }
        .btn-edit, .btn-delete, .btn-action { padding: 10px 24px; border-radius: 10px; text-decoration: none; font-weight: 600; transition: all 0.3s; cursor: pointer; border: none; font-size: 14px; display: inline-flex; align-items: center; gap: 8px; }
        .btn-edit { background: var(--warning); color: #0a0f1c; }
        .btn-delete { background: var(--danger); color: white; }
        .btn-action { background: var(--primary); color: white; }
        .btn-edit:hover, .btn-delete:hover, .btn-action:hover { transform: translateY(-2px); filter: brightness(1.1); }
        @media (max-width: 768px) {
            body { padding: 16px; }
            .card { padding: 20px; }
            .detail-label { width: 100%; margin-bottom: 8px; }
            .detail-value { width: 100%; }
            .actions { flex-direction: column; }
            .btn-edit, .btn-delete, .btn-action { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-truck"></i> Detalles del Proveedor</h1>
            <a href="{{ route('proveedores.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        <div class="card">
            <div class="card-title">
                <span><i class="fas fa-id-card"></i> {{ $proveedor->codigo }}</span>
                <span class="badge badge-{{ $proveedor->estado_color }}">
                    {{ $proveedor->estado_display }}
                </span>
            </div>

            <div class="detail-row">
                <div class="detail-label">Nombre:</div>
                <div class="detail-value">{{ $proveedor->nombre }}</div>
            </div>

            @if($proveedor->razon_social)
            <div class="detail-row">
                <div class="detail-label">Razón Social:</div>
                <div class="detail-value">{{ $proveedor->razon_social }}</div>
            </div>
            @endif

            @if($proveedor->nit)
            <div class="detail-row">
                <div class="detail-label">NIT:</div>
                <div class="detail-value">{{ $proveedor->nit }}</div>
            </div>
            @endif

            <div class="detail-row">
                <div class="detail-label">Ubicación:</div>
                <div class="detail-value">
                    {{ $proveedor->ciudad ? $proveedor->ciudad . ', ' : '' }}{{ $proveedor->pais ?? 'No especificado' }}
                </div>
            </div>

            @if($proveedor->direccion)
            <div class="detail-row">
                <div class="detail-label">Dirección:</div>
                <div class="detail-value">{{ $proveedor->direccion }}</div>
            </div>
            @endif

            <div class="detail-row">
                <div class="detail-label">Contacto:</div>
                <div class="detail-value">
                    <div>{{ $proveedor->telefono ?? 'Teléfono no registrado' }}</div>
                    <div>{{ $proveedor->email ?? 'Email no registrado' }}</div>
                </div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Tipo:</div>
                <div class="detail-value">
                    <span class="badge badge-{{ $proveedor->tipo_color }}">
                        {{ $proveedor->tipo_display }}
                    </span>
                </div>
            </div>

            <div class="section-title">
                <i class="fas fa-user-tie"></i> Persona de Contacto
            </div>

            <div class="detail-row">
                <div class="detail-label">Nombre:</div>
                <div class="detail-value">{{ $proveedor->contacto_nombre ?? 'No especificado' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Teléfono:</div>
                <div class="detail-value">{{ $proveedor->contacto_telefono ?? 'No especificado' }}</div>
            </div>

            <div class="detail-row">
                <div class="detail-label">Email:</div>
                <div class="detail-value">{{ $proveedor->contacto_email ?? 'No especificado' }}</div>
            </div>

            @if($proveedor->observaciones)
            <div class="detail-row">
                <div class="detail-label">Observaciones:</div>
                <div class="detail-value">{{ $proveedor->observaciones }}</div>
            </div>
            @endif

            <div class="actions">
                <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn-edit">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <button onclick="toggleActivo({{ $proveedor->id }})" class="btn-action">
                    <i class="fas fa-power-off"></i> 
                    {{ $proveedor->activo ? 'Desactivar' : 'Activar' }}
                </button>
                @if($proveedor->ordenesCompra->count() == 0)
                    <button onclick="eliminarProveedor({{ $proveedor->id }})" class="btn-delete">
                        <i class="fas fa-trash"></i> Eliminar
                    </button>
                @endif
            </div>
        </div>

        @if($proveedor->ordenesCompra->count() > 0)
        <div class="card">
            <div class="card-title">
                <span><i class="fas fa-file-invoice"></i> Órdenes de Compra Asociadas</span>
                <span class="badge badge-primary">{{ $proveedor->ordenesCompra->count() }} órdenes</span>
            </div>
            <div class="table-responsive">
                 <table
                    <thead>
                        汽
                            <th>N° Orden</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Total</th>
                            <th></th>
                        </thead>
                    <tbody>
                        @foreach($proveedor->ordenesCompra as $orden)
                        汽
                            汽<strong>{{ $orden->numero_orden }}</strong>汽
                            汽{{ $orden->fecha_orden->format('d/m/Y') }}汽
                            汽
                                <span class="badge badge-{{ $orden->estado_color }}">
                                    {{ $orden->estado_display }}
                                </span>
                            汽
                            汽${{ number_format($orden->detalles->sum('cantidad * precio_unitario'), 0, ',', '.') }}汽
                            汽
                                <a href="{{ route('importaciones.show', $orden->id) }}" class="btn-sm" style="padding: 4px 8px; background: var(--primary); color: #0a0f1c; border-radius: 6px; text-decoration: none;">
                                    <i class="fas fa-eye"></i> Ver
                                </a>
                            汽
                        汽
                        @endforeach
                    </tbody>
                 </table
            </div>
        </div>
        @endif
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        function eliminarProveedor(id) {
            if (confirm('¿Estás seguro de eliminar este proveedor?\nEsta acción no se puede deshacer.')) {
                fetch(`/proveedores/${id}`, {
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
                        window.location.href = '{{ route("proveedores.index") }}';
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el proveedor');
                });
            }
        }

        function toggleActivo(id) {
            fetch(`/proveedores/${id}/toggle-activo`, {
                method: 'POST',
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
                alert('Error al cambiar estado');
            });
        }
    </script>
</body>
</html>