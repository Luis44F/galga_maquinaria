@forelse($maquinas as $maquina)
<tr>
    <td><span class="badge bg-secondary">#{{ $maquina->id }}</span></td>
    <td>
        <strong>{{ optional($maquina->modelo)->modelo ?? 'N/A' }}</strong>
        @if(optional($maquina->modelo)->categoria)
            <br><small class="text-muted">{{ optional(optional($maquina->modelo)->categoria)->nombre ?? 'Sin categoría' }}</small>
        @endif
    </td>
    <td>
        <strong>{{ optional($maquina->modelo)->marca ?? 'N/A' }}</strong>
    </td>
    <td>{{ $maquina->año_fabricacion ?? 'N/A' }}</td>
    <td><small>{{ $maquina->numero_serie ?? 'N/A' }}</small></td>
    <td>
        <span class="fw-bold text-success">
            ${{ number_format($maquina->precio_venta, 0, ',', '.') }}
        </span>
        @if($maquina->precio_compra)
            <br><small class="text-muted">Compra: ${{ number_format($maquina->precio_compra, 0, ',', '.') }}</small>
        @endif
    </td>
    <td>
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
        <span class="badge bg-{{ $estadoColors[$maquina->estado] ?? 'secondary' }}">
            {{ $estadoTextos[$maquina->estado] ?? $maquina->estado }}
        </span>
    </td>
    <td>
        <div class="btn-group" role="group">
            <a href="{{ route('maquinas.show', $maquina->id) }}" 
               class="btn btn-sm btn-info" 
               title="Ver detalles"
               data-bs-toggle="tooltip">
                <i class="fas fa-eye"></i>
            </a>
            
            <a href="{{ route('maquinas.edit', $maquina->id) }}" 
               class="btn btn-sm btn-warning"
               title="Editar"
               data-bs-toggle="tooltip">
                <i class="fas fa-edit"></i>
            </a>
            
            <button class="btn btn-sm btn-danger" 
                    onclick="eliminarMaquina({{ $maquina->id }})"
                    title="Eliminar"
                    data-bs-toggle="tooltip">
                <i class="fas fa-trash"></i>
            </button>
            
            @if(in_array($maquina->estado, ['disponible', 'en_bodega']))
                <button class="btn btn-sm btn-primary" 
                        onclick="reservarMaquina({{ $maquina->id }})"
                        title="Reservar para cliente"
                        data-bs-toggle="tooltip">
                    <i class="fas fa-tag"></i>
                </button>
            @endif
            
            @if(in_array($maquina->estado, ['disponible', 'en_bodega']))
                <button class="btn btn-sm btn-success" 
                        onclick="venderMaquina({{ $maquina->id }})"
                        title="Vender"
                        data-bs-toggle="tooltip">
                    <i class="fas fa-dollar-sign"></i>
                </button>
            @endif
            
            @if($maquina->estado != 'vendida')
                <button class="btn btn-sm btn-secondary" 
                        onclick="abrirModalEstado({{ $maquina->id }}, '{{ $maquina->estado }}')"
                        title="Cambiar estado"
                        data-bs-toggle="tooltip">
                    <i class="fas fa-sync-alt"></i>
                </button>
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center py-5">
        <i class="fas fa-cog fa-4x text-muted mb-3"></i>
        <h4 class="text-muted">No hay máquinas disponibles</h4>
        <a href="{{ route('maquinas.create') }}" class="btn btn-primary mt-2">
            <i class="fas fa-plus"></i> Registrar Máquina
        </a>
    </td>
</tr>
@endforelse