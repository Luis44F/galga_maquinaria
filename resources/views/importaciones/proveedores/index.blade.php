<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Proveedores</title>
    
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
        }

        .container {
            max-width: 1400px;
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
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

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
            font-size: 12px;
            cursor: pointer;
        }

        .btn-sm:hover {
            background: var(--primary);
            color: #0a0f1c;
            border-color: var(--primary);
        }

        .search-box {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 10px;
            padding: 8px 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 260px;
        }

        .search-box input {
            background: none;
            border: none;
            color: var(--text-light);
            width: 100%;
            outline: none;
        }

        .filters-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .filters-group {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-select {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 10px;
            padding: 8px 14px;
            color: var(--text-light);
        }

        .table-responsive {
            overflow-x: auto;
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        th {
            text-align: left;
            padding: 16px;
            background: rgba(14, 165, 233, 0.05);
            color: var(--text-dim);
            font-weight: 600;
            font-size: 13px;
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
            font-size: 11px;
            font-weight: 500;
        }

        .badge-success {
            background: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .badge-primary {
            background: rgba(14, 165, 233, 0.2);
            color: var(--primary);
        }

        .badge-secondary {
            background: rgba(100, 116, 139, 0.2);
            color: var(--text-dim);
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid var(--success);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
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
        }

        .page-link:hover {
            background: var(--primary);
            color: #0a0f1c;
        }

        @media (max-width: 768px) {
            body {
                padding: 16px;
            }
            
            .header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .filters-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-truck"></i> Proveedores</h1>
            <div>
                <a href="{{ route('dashboard.importaciones') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
                <a href="{{ route('proveedores.create') }}" class="btn-primary" style="margin-left: 10px;">
                    <i class="fas fa-plus"></i> Nuevo Proveedor
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <div class="filters-bar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Buscar por nombre, código, NIT, país..." value="{{ request('buscar') }}">
            </div>
            <div class="filters-group">
                <select id="tipoFilter" class="filter-select">
                    <option value="">Todos los tipos</option>
                    <option value="nacional" {{ request('tipo') == 'nacional' ? 'selected' : '' }}>Nacional</option>
                    <option value="internacional" {{ request('tipo') == 'internacional' ? 'selected' : '' }}>Internacional</option>
                </select>
                <select id="paisFilter" class="filter-select">
                    <option value="">Todos los países</option>
                    @foreach($paises as $pais)
                        <option value="{{ $pais }}" {{ request('pais') == $pais ? 'selected' : '' }}>{{ $pais }}</option>
                    @endforeach
                </select>
                <select id="activoFilter" class="filter-select">
                    <option value="">Todos</option>
                    <option value="1" {{ request('activo') == '1' ? 'selected' : '' }}>Activos</option>
                    <option value="0" {{ request('activo') == '0' ? 'selected' : '' }}>Inactivos</option>
                </select>
                <button id="applyFilters" class="btn-primary" style="padding: 8px 16px;">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
                <button id="clearFilters" class="btn-sm">
                    <i class="fas fa-undo"></i> Limpiar
                </button>
            </div>
        </div>

        <div class="table-responsive">
             <table
                <thead>
                    汽
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>NIT</th>
                        <th>País</th>
                        <th>Tipo</th>
                        <th>Contacto</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </thead>
                <tbody id="proveedoresTableBody">
                    @include('importaciones.proveedores.lista', ['proveedores' => $proveedores])
                </tbody>
             </table
        </div>

        @if(method_exists($proveedores, 'links'))
        <div class="pagination">
            {{ $proveedores->links() }}
        </div>
        @endif
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        // Filtros
        document.getElementById('applyFilters')?.addEventListener('click', function() {
            const buscar = document.getElementById('searchInput').value;
            const tipo = document.getElementById('tipoFilter').value;
            const pais = document.getElementById('paisFilter').value;
            const activo = document.getElementById('activoFilter').value;
            
            let url = '{{ route("proveedores.index") }}';
            const params = [];
            
            if (buscar) params.push('buscar=' + encodeURIComponent(buscar));
            if (tipo) params.push('tipo=' + tipo);
            if (pais) params.push('pais=' + pais);
            if (activo !== '') params.push('activo=' + activo);
            
            if (params.length) {
                url += '?' + params.join('&');
            }
            
            window.location.href = url;
        });

        document.getElementById('clearFilters')?.addEventListener('click', function() {
            window.location.href = '{{ route("proveedores.index") }}';
        });

        document.getElementById('searchInput')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('applyFilters').click();
            }
        });

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
                        location.reload();
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

        function toggleActivoProveedor(id) {
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