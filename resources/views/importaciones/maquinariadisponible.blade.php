<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · MAQUINARIA DISPONIBLE</title>
    
    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
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
            min-height: 100vh;
            padding: 24px 32px;
        }

        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --primary-light: #38bdf8;
            --secondary: #2563eb;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #3b82f6;
            --dark-bg: #0a0f1c;
            --card-bg: #111827;
            --card-border: #1f2937;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --sidebar-bg: #0f172a;
        }

        /* Header */
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 32px;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-light);
            margin-bottom: 8px;
        }

        .header-title p {
            color: var(--text-dim);
            font-size: 15px;
        }

        .btn-success {
            background: var(--success);
            color: #0a0f1c;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-success:hover {
            background: #0d9668;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(16, 185, 129, 0.5);
        }

        .btn-primary {
            background: var(--primary);
            color: #0a0f1c;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.5);
        }

        .btn-outline-secondary {
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-outline-secondary:hover {
            background: var(--card-border);
            color: var(--text-light);
        }

        /* Cards */
        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 24px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .card.bg-success { background: var(--success); }
        .card.bg-info { background: var(--info); }
        .card.bg-warning { background: var(--warning); }
        .card.bg-secondary { background: #4b5563; }

        .text-white-50 { color: rgba(255,255,255,0.7); }
        .opacity-50 { opacity: 0.5; }

        /* Stats Cards */
        .row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 32px;
        }

        .col-md-3 {
            width: 100%;
        }

        .display-6 {
            font-size: 32px;
            font-weight: 700;
        }

        .fw-bold { font-weight: 700; }
        .mb-0 { margin-bottom: 0; }
        .me-1 { margin-right: 4px; }
        .me-2 { margin-right: 8px; }
        .mb-4 { margin-bottom: 24px; }
        .mt-2 { margin-top: 8px; }
        .py-5 { padding: 48px 0; }
        .text-center { text-align: center; }
        .text-muted { color: var(--text-dim); }
        .text-success { color: var(--success); }

        /* Filtros */
        .filtros-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
        }

        .filtros-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
        }

        .form-label {
            display: block;
            color: var(--text-dim);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            background: var(--dark-bg);
            border: 1px solid var(--card-border);
            border-radius: 10px;
            color: var(--text-light);
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            transition: all 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        .form-control::placeholder {
            color: #4b5563;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px;
        }

        /* Tabla */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .badge.bg-secondary { background: #4b5563; color: white; }
        .badge.bg-success { background: var(--success); color: #0a0f1c; }
        .badge.bg-info { background: var(--info); color: white; }
        .badge.bg-warning { background: var(--warning); color: #0a0f1c; }
        .badge.bg-primary { background: var(--primary); color: #0a0f1c; }

        .btn-group {
            display: flex;
            gap: 4px;
        }

        .btn-sm {
            padding: 6px 10px;
            border-radius: 6px;
            background: transparent;
            border: 1px solid var(--card-border);
            color: var(--text-dim);
            font-size: 12px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .btn-sm:hover {
            background: var(--primary);
            color: #0a0f1c;
            border-color: var(--primary);
        }

        .btn-sm.btn-info:hover { background: var(--info); color: white; }
        .btn-sm.btn-warning:hover { background: var(--warning); color: #0a0f1c; }
        .btn-sm.btn-primary:hover { background: var(--primary); color: #0a0f1c; }
        .btn-sm.btn-success:hover { background: var(--success); color: #0a0f1c; }
        .btn-sm.btn-danger:hover { background: var(--danger); color: white; }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="content-header">
        <div class="header-title">
            <h1>
                <i class="fas fa-cog" style="color: var(--primary);"></i> 
                MAQUINARIA DISPONIBLE
            </h1>
            <p>Máquinas listas para venta en inventario</p>
        </div>
        <a href="{{ route('maquinas.create') }}" class="btn-success">
            <i class="fas fa-plus"></i> Registrar Nueva Máquina
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row" id="statsContainer">
        @include('importaciones.maquinas.partials.maquinaria-stats')
    </div>

    <!-- Filtros -->
    <div class="filtros-card">
        <form id="maquinariaFiltrosForm">
            <div class="filtros-grid">
                <div>
                    <label class="form-label">Buscar</label>
                    <input type="text" class="form-control" id="buscarMaquina" placeholder="Modelo, marca, serie...">
                </div>
                <div>
                    <label class="form-label">Marca</label>
                    <select class="form-control" id="filtroMarca">
                        <option value="">Todas</option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca }}">{{ $marca }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Precio Mín.</label>
                    <input type="number" class="form-control" id="precioMin" placeholder="0">
                </div>
                <div>
                    <label class="form-label">Precio Máx.</label>
                    <input type="number" class="form-control" id="precioMax" placeholder="1000000">
                </div>
                <div style="display: flex; align-items: flex-end; gap: 8px;">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                    <button type="button" class="btn-outline-secondary" onclick="limpiarFiltros()">
                        <i class="fas fa-undo"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de Maquinaria -->
    <div class="card">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Máquina</th>
                        <th>Marca / Modelo</th>
                        <th>Año</th>
                        <th>Serie</th>
                        <th>Precio Venta</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="maquinariaTableBody">
                    @include('importaciones.maquinas.partials.maquinaria-tabla')
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal para cambiar estado -->
    <div class="modal" id="estadoModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); align-items: center; justify-content: center; z-index: 1000;">
        <div style="background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; padding: 32px; max-width: 500px; width: 90%;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <h2 style="color: var(--text-light);">Cambiar Estado</h2>
                <button onclick="cerrarModal()" style="background: none; border: none; color: var(--text-dim); font-size: 24px; cursor: pointer;">&times;</button>
            </div>
            <div>
                <input type="hidden" id="maquinaId">
                <div style="margin-bottom: 16px;">
                    <label style="display: block; color: var(--text-dim); margin-bottom: 6px;">Nuevo Estado</label>
                    <select class="form-control" id="nuevoEstado">
                        <option value="disponible">📦 Disponible</option>
                        <option value="en_bodega">🏭 En Bodega</option>
                        <option value="en_transito">🚢 En Tránsito</option>
                        <option value="en_puerto">⚓ En Puerto</option>
                        <option value="con_anticipo">🔒 Reservada</option>
                        <option value="vendida">💰 Vendida</option>
                    </select>
                </div>
            </div>
            <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
                <button class="btn-outline-secondary" onclick="cerrarModal()">Cancelar</button>
                <button class="btn-primary" onclick="cambiarEstado()">Guardar</button>
            </div>
        </div>
    </div>

    <script>
        // Token CSRF
        const csrfToken = '{{ csrf_token() }}';

        // Función para limpiar filtros
        function limpiarFiltros() {
            document.getElementById('buscarMaquina').value = '';
            document.getElementById('filtroMarca').value = '';
            document.getElementById('precioMin').value = '';
            document.getElementById('precioMax').value = '';
            cargarMaquinaria();
        }

        // Filtrar máquinas
        document.getElementById('maquinariaFiltrosForm').addEventListener('submit', function(e) {
            e.preventDefault();
            cargarMaquinaria();
        });

        // Cargar máquinas vía AJAX
        function cargarMaquinaria() {
            const buscar = document.getElementById('buscarMaquina').value;
            const marca = document.getElementById('filtroMarca').value;
            const precioMin = document.getElementById('precioMin').value;
            const precioMax = document.getElementById('precioMax').value;

            let url = '{{ route("importaciones.maquinaria-disponible") }}';
            const params = [];
            if (buscar) params.push('buscar=' + encodeURIComponent(buscar));
            if (marca) params.push('marca=' + encodeURIComponent(marca));
            if (precioMin) params.push('precio_min=' + encodeURIComponent(precioMin));
            if (precioMax) params.push('precio_max=' + encodeURIComponent(precioMax));
            
            if (params.length > 0) {
                url += '?' + params.join('&');
            }

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('maquinariaTableBody').innerHTML = data.html;
                    document.getElementById('statsContainer').innerHTML = data.stats;
                }
            });
        }

        // Funciones del modal
        function abrirModalEstado(id, estadoActual) {
            document.getElementById('maquinaId').value = id;
            document.getElementById('nuevoEstado').value = estadoActual;
            document.getElementById('estadoModal').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('estadoModal').style.display = 'none';
        }

        function cambiarEstado() {
            const id = document.getElementById('maquinaId').value;
            const estado = document.getElementById('nuevoEstado').value;
            
            fetch('{{ route("importaciones.maquinaria-disponible.cambiar-estado", ["id" => "ID_REEMPLAZAR"]) }}'.replace('ID_REEMPLAZAR', id), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ estado: estado })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cerrarModal();
                    cargarMaquinaria();
                    alert(data.message);
                }
            });
        }

        function reservarMaquina(id) {
            if (confirm('¿Reservar esta máquina para un cliente?')) {
                fetch('{{ route("importaciones.maquinaria-disponible.reservar", ["id" => "ID_REEMPLAZAR"]) }}'.replace('ID_REEMPLAZAR', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cargarMaquinaria();
                        alert(data.message);
                    }
                });
            }
        }

        function venderMaquina(id) {
            if (confirm('¿Confirmar venta de esta máquina?')) {
                fetch('{{ route("importaciones.maquinaria-disponible.vender", ["id" => "ID_REEMPLAZAR"]) }}'.replace('ID_REEMPLAZAR', id), {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cargarMaquinaria();
                        alert(data.message);
                    }
                });
            }
        }

        function eliminarMaquina(id) {
            if (confirm('¿Estás seguro de eliminar esta máquina?')) {
                fetch(`/maquinas/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        cargarMaquinaria();
                        alert('Máquina eliminada');
                    }
                });
            }
        }

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            const modal = document.getElementById('estadoModal');
            if (event.target === modal) {
                cerrarModal();
            }
        };
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>