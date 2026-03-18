<style>
    .card {
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        border-radius: 24px;
        padding: 24px;
        margin-bottom: 20px;
    }
    
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .card-title {
        font-weight: 600;
        color: var(--text-light);
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 18px;
    }
    
    .card-title i {
        color: var(--primary);
    }
    
    .btn-primary {
        background: var(--primary);
        color: #0a0f1c;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        display: flex;
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
    
    .badge-warning {
        background: rgba(245, 158, 11, 0.2);
        color: var(--warning);
    }
    
    .badge-success {
        background: rgba(16, 185, 129, 0.2);
        color: var(--success);
    }
    
    .badge-info {
        background: rgba(14, 165, 233, 0.2);
        color: var(--primary);
    }
    
    .badge-danger {
        background: rgba(239, 68, 68, 0.2);
        color: var(--danger);
    }
    
    .badge-secondary {
        background: rgba(148, 163, 184, 0.2);
        color: var(--text-dim);
    }
    
    .action-buttons {
        display: flex;
        gap: 8px;
    }
    
    .btn-sm {
        padding: 6px 12px;
        border-radius: 8px;
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
    
    .btn-danger {
        border-color: var(--danger);
        color: var(--danger);
    }
    
    .btn-danger:hover {
        background: var(--danger);
        color: white;
        border-color: var(--danger);
    }
    
    .pagination {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        margin-top: 24px;
    }
    
    .page-item {
        padding: 8px 12px;
        border-radius: 8px;
        background: var(--card-bg);
        border: 1px solid var(--card-border);
        color: var(--text-dim);
        text-decoration: none;
        transition: all 0.3s;
    }
    
    .page-item:hover,
    .page-item.active {
        background: var(--primary);
        color: #0a0f1c;
        border-color: var(--primary);
    }
</style>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <i class="fas fa-file-invoice" style="color: var(--warning);"></i>
            Listado de Órdenes de Compra
        </div>
        <button class="btn-primary" onclick="mostrarFormularioCrear()">
            <i class="fas fa-plus"></i> Nueva Orden
        </button>
    </div>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>N° Orden</th>
                    <th>Proveedor</th>
                    <th>País</th>
                    <th>Fecha Orden</th>
                    <th>Fecha Est. Llegada</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ordenes as $orden)
                <tr>
                    <td><strong>{{ $orden->numero_orden }}</strong></td>
                    <td>{{ $orden->proveedor }}</td>
                    <td>{{ $orden->pais_origen ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($orden->fecha_orden)->format('d/m/Y') }}</td>
                    <td>
                        @if($orden->fecha_estimada_llegada)
                            {{ \Carbon\Carbon::parse($orden->fecha_estimada_llegada)->format('d/m/Y') }}
                            @if($orden->estado != 'recibida' && \Carbon\Carbon::parse($orden->fecha_estimada_llegada)->isPast())
                                <span class="badge badge-danger">Atrasada</span>
                            @endif
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @php
                            $badgeClass = [
                                'pendiente' => 'badge-warning',
                                'en_transito' => 'badge-info',
                                'recibida' => 'badge-success',
                                'cancelada' => 'badge-danger',
                            ][$orden->estado] ?? 'badge-secondary';
                            
                            $estadoTexto = [
                                'pendiente' => 'Pendiente',
                                'en_transito' => 'En Tránsito',
                                'recibida' => 'Recibida',
                                'cancelada' => 'Cancelada',
                            ][$orden->estado] ?? $orden->estado;
                        @endphp
                        <span class="badge {{ $badgeClass }}">
                            {{ $estadoTexto }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-sm" onclick="verOrden('{{ $orden->id }}')" title="Ver detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn-sm" onclick="mostrarFormularioEditar('{{ $orden->id }}')" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn-sm btn-danger" onclick="eliminarOrden('{{ $orden->id }}')" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px;">
                        <i class="fas fa-file-invoice" style="font-size: 48px; color: var(--text-dim);"></i>
                        <p style="margin-top: 16px; color: var(--text-dim);">No hay órdenes de importación registradas</p>
                        <button class="btn-primary" onclick="mostrarFormularioCrear()" style="margin-top: 16px;">
                            <i class="fas fa-plus"></i> Crear primera orden
                        </button>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(method_exists($ordenes, 'links') && $ordenes->hasPages())
    <div class="pagination">
        {{ $ordenes->links() }}
    </div>
    @endif
</div>