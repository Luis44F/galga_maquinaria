@php
    $grupos = [];
    foreach($maquinas as $maquina) {
        $ordenId = $maquina->ordenCompra ? $maquina->ordenCompra->id : 'sin_orden';
        $ordenNumero = $maquina->ordenCompra ? $maquina->ordenCompra->numero_orden : 'Sin Orden';
        
        if (!isset($grupos[$ordenId])) {
            $grupos[$ordenId] = [
                'orden_id' => $ordenId,
                'orden_numero' => $ordenNumero,
                'maquinas' => []
            ];
        }
        $grupos[$ordenId]['maquinas'][] = $maquina;
    }
@endphp

<style>
.toggle-grupo {
    display: none;
}

.grupo-fila {
    display: none;
}

.grupo-header {
    cursor: pointer;
    transition: background 0.2s;
}

.grupo-header:hover {
    background: rgba(14, 165, 233, 0.1) !important;
}

.icono {
    display: inline-block;
    transition: transform 0.2s ease;
}
</style>

<tbody>
@foreach($grupos as $grupo)
    @php
        $grupoId = 'grupo_' . $grupo['orden_id'];
        $totalMaquinas = count($grupo['maquinas']);
    @endphp

    {{-- CHECKBOX para controlar el grupo --}}
    <input type="checkbox" id="{{ $grupoId }}" class="toggle-grupo" style="display: none;">

    {{-- HEADER del grupo --}}
    <tr class="grupo-header" style="background: rgba(14, 165, 233, 0.05);">
        <td colspan="8" style="padding: 12px 16px;">
            <label for="{{ $grupoId }}" style="cursor: pointer; display: flex; align-items: center; gap: 10px; width: 100%;">
                <span class="icono" style="display: inline-block; transition: transform 0.2s; font-size: 14px;">▶</span>
                <strong>Orden: {{ $grupo['orden_numero'] }}</strong>
                <span style="background: rgba(14, 165, 233, 0.2); color: var(--primary); padding: 2px 8px; border-radius: 12px; font-size: 12px;">{{ $totalMaquinas }} máquinas</span>
            </label>
        </td>
    </tr>

    {{-- FILAS de máquinas del grupo --}}
    @foreach($grupo['maquinas'] as $maquina)
    <tr class="grupo-fila" style="display: none;">
        <td><strong>#{{ $maquina->id }}</strong><br><small>Orden: {{ $grupo['orden_numero'] }}</small></td>
        
        <td>
            @php
                $nombreModelo = 'N/A';
                if ($maquina->modelo && !empty($maquina->modelo->modelo)) {
                    $nombreModelo = $maquina->modelo->modelo;
                } elseif ($maquina->ordenCompra && !empty($maquina->ordenCompra->modelo_maquina)) {
                    $nombreModelo = $maquina->ordenCompra->modelo_maquina;
                }
            @endphp
            <strong>{{ $nombreModelo }}</strong><br>
            <small>Serie: {{ $maquina->numero_serie ?? 'N/A' }}</small>
        </td>
        
        <td>
            @php
                $marcaModelo = 'N/A';
                if ($maquina->modelo) {
                    $marca = $maquina->modelo->marca ?? '';
                    $modelo = $maquina->modelo->modelo ?? '';
                    if (!empty($marca) && !empty($modelo)) {
                        $marcaModelo = $marca . ' ' . $modelo;
                    } elseif (!empty($marca)) {
                        $marcaModelo = $marca;
                    } elseif (!empty($modelo)) {
                        $marcaModelo = $modelo;
                    }
                } elseif ($maquina->ordenCompra && !empty($maquina->ordenCompra->modelo_maquina)) {
                    $marcaModelo = $maquina->ordenCompra->modelo_maquina;
                }
                
                if (trim($marcaModelo) == 'N/A' || trim($marcaModelo) == 'N/A N/A') {
                    $marcaModelo = 'N/A';
                }
            @endphp
            {{ $marcaModelo }}
        </td>
        
        <td>{{ $maquina->año_fabricacion ?? 'N/A' }}</td>
        <td>{{ $maquina->numero_serie ?? 'N/A' }}</td>
        
        <td>
            @php
                $precio = $maquina->precio_venta ?? 0;
                echo '$' . number_format($precio, 0, ',', '.');
            @endphp
        </td>
        
        <td>
            @php
                $estadoMap = [
                    'disponible' => ['class' => 'success', 'icono' => '📦', 'texto' => 'Disponible'],
                    'vendida' => ['class' => 'danger', 'icono' => '💰', 'texto' => 'Vendida'],
                    'en_transito' => ['class' => 'warning', 'icono' => '🚢', 'texto' => 'En Tránsito'],
                    'pendiente_despacho' => ['class' => 'info', 'icono' => '⏳', 'texto' => 'Pendiente Despacho'],
                    'en_bodega' => ['class' => 'info', 'icono' => '🏭', 'texto' => 'En Bodega'],
                    'en_puerto' => ['class' => 'warning', 'icono' => '⚓', 'texto' => 'En Puerto'],
                    'reparacion' => ['class' => 'warning', 'icono' => '🔧', 'texto' => 'En Reparación'],
                    'fabricacion' => ['class' => 'info', 'icono' => '🏗️', 'texto' => 'En Fabricación'],
                    'cancelado' => ['class' => 'secondary', 'icono' => '❌', 'texto' => 'Cancelado']
                ];
                $estado = $estadoMap[$maquina->estado] ?? ['class' => 'secondary', 'icono' => '📌', 'texto' => ucfirst($maquina->estado)];
            @endphp
            <span class="badge badge-{{ $estado['class'] }}">
                {{ $estado['icono'] }} {{ $estado['texto'] }}
            </span>
        </td>
        
        <td style="display: flex; gap: 6px; flex-wrap: wrap;">
            <button class="btn-sm" onclick="verMaquina({{ $maquina->id }})" title="Ver">
                <i class="fas fa-eye"></i>
            </button>
            <button class="btn-sm" onclick="editarMaquina({{ $maquina->id }})" title="Editar">
                <i class="fas fa-edit"></i>
            </button>
            <button class="btn-sm" onclick="abrirModalEstado({{ $maquina->id }}, '{{ $maquina->estado }}')" title="Cambiar Estado">
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

@endforeach
</tbody>

<script>
// Función para inicializar los toggles después de cargar las máquinas
function inicializarToggles() {
    // Buscar todos los headers de grupo
    const headers = document.querySelectorAll('.grupo-header');
    
    headers.forEach(header => {
        // Encontrar el checkbox asociado (está antes del header)
        const checkbox = header.previousElementSibling;
        
        if (checkbox && checkbox.classList.contains('toggle-grupo')) {
            // Agregar evento click al header
            header.addEventListener('click', function(e) {
                // Cambiar el estado del checkbox
                checkbox.checked = !checkbox.checked;
                
                // Buscar las filas que pertenecen a este grupo
                let nextElement = header.nextElementSibling;
                let filasGrupo = [];
                
                while (nextElement && !nextElement.classList.contains('grupo-header')) {
                    if (nextElement.classList.contains('grupo-fila')) {
                        filasGrupo.push(nextElement);
                    }
                    nextElement = nextElement.nextElementSibling;
                }
                
                // Mostrar u ocultar según el estado del checkbox
                filasGrupo.forEach(fila => {
                    if (checkbox.checked) {
                        fila.style.display = 'table-row';
                    } else {
                        fila.style.display = 'none';
                    }
                });
                
                // Rotar el icono
                const icono = header.querySelector('.icono');
                if (icono) {
                    if (checkbox.checked) {
                        icono.style.transform = 'rotate(90deg)';
                    } else {
                        icono.style.transform = 'rotate(0deg)';
                    }
                }
            });
            
            // También manejar el click en el label dentro del header
            const label = header.querySelector('label');
            if (label) {
                label.addEventListener('click', function(e) {
                    e.stopPropagation();
                    checkbox.checked = !checkbox.checked;
                    
                    let nextElement = header.nextElementSibling;
                    let filasGrupo = [];
                    
                    while (nextElement && !nextElement.classList.contains('grupo-header')) {
                        if (nextElement.classList.contains('grupo-fila')) {
                            filasGrupo.push(nextElement);
                        }
                        nextElement = nextElement.nextElementSibling;
                    }
                    
                    filasGrupo.forEach(fila => {
                        if (checkbox.checked) {
                            fila.style.display = 'table-row';
                        } else {
                            fila.style.display = 'none';
                        }
                    });
                    
                    const icono = header.querySelector('.icono');
                    if (icono) {
                        if (checkbox.checked) {
                            icono.style.transform = 'rotate(90deg)';
                        } else {
                            icono.style.transform = 'rotate(0deg)';
                        }
                    }
                });
            }
        }
    });
}

// Inicializar los toggles cuando la página cargue
document.addEventListener('DOMContentLoaded', function() {
    inicializarToggles();
});
</script>