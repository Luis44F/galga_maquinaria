@if($maquinas->isNotEmpty())
    @foreach($maquinas as $maquina)
        <tr>
            <td>#{{ $maquina->id }}</td>
            <td>
                @if($maquina->modelo)
                    <strong>{{ $maquina->modelo->marca }} {{ $maquina->modelo->modelo }}</strong>
                @else
                    <strong>{{ $maquina->modelo_maquina ?? 'N/A' }}</strong>
                @endif
            </td>
            <td>
                @if($maquina->modelo)
                    {{ $maquina->modelo->marca ?? 'N/A' }} / {{ $maquina->modelo->modelo ?? 'N/A' }}
                @else
                    {{ $maquina->modelo_maquina ?? 'N/A' }}
                @endif
            </td>
            <td>{{ $maquina->año_fabricacion ?? 'N/A' }}</td>
            <td class="serie-cell">{{ $maquina->numero_serie ?? 'N/A' }}</td>
            <td class="price-cell">
                @if($maquina->precio_venta)
                    ${{ number_format($maquina->precio_venta, 0, ',', '.') }}
                @else
                    N/A
                @endif
            </td>
            <td>
                <span class="badge badge-{{ $maquina->estado_color }}">
                    {{ $maquina->estado_display }}
                </span>
            </td>
            <td class="action-buttons">
                <a href="{{ route('maquinas.show', $maquina->id) }}" class="btn-sm" title="Ver detalles">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('maquinas.edit', $maquina->id) }}" class="btn-sm" title="Editar máquina">
                    <i class="fas fa-edit"></i>
                </a>
                <button class="btn-sm" onclick="abrirModalEstado({{ $maquina->id }}, '{{ $maquina->estado }}')" title="Cambiar estado">
                    <i class="fas fa-exchange-alt"></i>
                </button>
                @if($maquina->estado == 'disponible')
                    <button class="btn-sm" onclick="reservarMaquina({{ $maquina->id }})" title="Reservar">
                        <i class="fas fa-clock"></i>
                    </button>
                    <button class="btn-sm" onclick="venderMaquina({{ $maquina->id }})" title="Vender">
                        <i class="fas fa-dollar-sign"></i>
                    </button>
                @endif
                <button class="btn-sm" onclick="eliminarMaquina({{ $maquina->id }})" title="Eliminar">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="8" style="text-align: center; padding: 40px;">
            <i class="fas fa-cog fa-3x" style="color: var(--text-dim); margin-bottom: 16px;"></i>
            <p style="color: var(--text-dim);">No hay máquinas registradas</p>
            <a href="{{ route('maquinas.create') }}" class="btn-primary" style="margin-top: 16px; display: inline-block;">
                <i class="fas fa-plus"></i> Registrar Máquina
            </a>
        </td>
    </tr>
@endif