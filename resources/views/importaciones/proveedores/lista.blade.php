@forelse($proveedores as $proveedor)
<tr>
    <td><strong>{{ $proveedor->codigo }}</strong></td>
    <td>
        {{ $proveedor->nombre }}<br>
        <small style="color: var(--text-dim);">{{ $proveedor->razon_social ?? '' }}</small>
    </td>
    <td>{{ $proveedor->nit ?? '—' }}</td>
    <td>{{ $proveedor->pais ?? '—' }}</td>
    <td>
        <span class="badge badge-{{ $proveedor->tipo_color }}">
            {{ $proveedor->tipo_display }}
        </span>
    </td>
    <td>
        {{ $proveedor->contacto_nombre ?? '—' }}<br>
        <small>{{ $proveedor->contacto_telefono ?? '' }}</small>
    </td>
    <td>
        <span class="badge badge-{{ $proveedor->estado_color }}">
            {{ $proveedor->estado_display }}
        </span>
    </td>
    <td class="action-buttons">
        <a href="{{ route('proveedores.show', $proveedor) }}" class="btn-sm" title="Ver detalles">
            <i class="fas fa-eye"></i>
        </a>
        <a href="{{ route('proveedores.edit', $proveedor) }}" class="btn-sm" title="Editar">
            <i class="fas fa-edit"></i>
        </a>
        <button onclick="toggleActivoProveedor({{ $proveedor->id }})" class="btn-sm" title="{{ $proveedor->activo ? 'Desactivar' : 'Activar' }}">
            <i class="fas fa-power-off"></i>
        </button>
        @if($proveedor->ordenesCompra()->count() == 0)
            <button onclick="eliminarProveedor({{ $proveedor->id }})" class="btn-sm" title="Eliminar">
                <i class="fas fa-trash"></i>
            </button>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="8" style="text-align: center; padding: 40px;">
        <i class="fas fa-truck fa-3x" style="color: var(--text-dim); margin-bottom: 16px;"></i>
        <p style="color: var(--text-dim);">No hay proveedores registrados</p>
        <a href="{{ route('proveedores.create') }}" class="btn-primary" style="margin-top: 16px; display: inline-block;">
            <i class="fas fa-plus"></i> Registrar Primer Proveedor
        </a>
    </td>
</tr>
@endforelse