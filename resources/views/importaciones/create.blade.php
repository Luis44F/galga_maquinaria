<div id="formularioSection">
    <div class="card" style="max-width: 800px; margin: 0 auto;">
        
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-plus-circle" style="color: var(--success);"></i>
                Nueva Orden de Importación
            </div>

            <button class="btn-sm"
                onclick="window.location.href='{{ route('dashboard.importaciones') }}'"
                style="background: transparent;">
                <i class="fas fa-arrow-left"></i> Volver
            </button>
        </div>

        <form action="/importaciones" method="POST">
            @csrf

            <div style="margin-bottom: 24px;">

                <h3 style="margin-bottom:16px; color: var(--text-light);">
                    Información General
                </h3>

                <div class="form-group">
                    <label class="form-label">Número de Orden *</label>
                    <input
                        type="text"
                        name="numero_orden"
                        class="form-control"
                        placeholder="Ej: OC-2025-001"
                        value="{{ old('numero_orden') }}"
                        required
                    >
                    <small style="color: var(--text-dim);">
                        Debe ser único
                    </small>
                </div>

                <div class="form-group">
                    <label class="form-label">Proveedor *</label>
                    <select name="proveedor_id" class="form-control" required>
                        <option value="">Seleccione un proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                {{ $proveedor->nombre }} ({{ $proveedor->pais }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
                    <div class="form-group">
                        <label class="form-label">Fecha de Orden *</label>
                        <input
                            type="date"
                            name="fecha_orden"
                            class="form-control"
                            value="{{ old('fecha_orden', now()->toDateString()) }}"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label class="form-label">
                            Fecha Estimada de Llegada
                        </label>
                        <input
                            type="date"
                            name="fecha_estimada_llegada"
                            class="form-control"
                            value="{{ old('fecha_estimada_llegada') }}"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Fecha de Llegada Real
                    </label>
                    <input
                        type="date"
                        name="fecha_llegada_real"
                        class="form-control"
                        value="{{ old('fecha_llegada_real') }}"
                    >
                </div>

                <div class="form-group">
                    <label class="form-label">Estado *</label>
                    <select class="form-control" name="estado" id="estado" required>
                        <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>📋 Pendiente</option>
                        <option value="en_fabricacion" {{ old('estado') == 'en_fabricacion' ? 'selected' : '' }}>🏗️ En Fabricación</option>
                        <option value="en_transito" {{ old('estado') == 'en_transito' ? 'selected' : '' }}>🚢 En Tránsito</option>
                        <option value="en_puerto" {{ old('estado') == 'en_puerto' ? 'selected' : '' }}>⚓ En Puerto</option>
                        <option value="recibida" {{ old('estado') == 'recibida' ? 'selected' : '' }}>📦 Recibida</option>
                        <option value="cancelada" {{ old('estado') == 'cancelada' ? 'selected' : '' }}>❌ Cancelada</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Cantidad de máquinas</label>
                    <input type="number"
                            name="cantidad_maquinas"
                            id="cantidad_maquinas"
                           class="form-control"
                            min="1"
                            value="{{ old('cantidad_maquinas', 1) }}"
                           required>
                    <small class="text-muted">Número de máquinas que incluye esta orden</small>
                </div>

                <div class="form-group">
                    <label class="form-label">Modelo de máquina</label>
                    <input type="text"
                            name="modelo_maquina"
                            id="modelo_maquina"
                           class="form-control"
                            value="{{ old('modelo_maquina') }}"
                           placeholder="Ej: Retroexcavadora CAT 420">
                    <small class="text-muted">Modelo genérico si no usas catálogo</small>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        Observaciones
                    </label>
                    <textarea
                        name="observaciones"
                        class="form-control"
                        rows="3"
                        placeholder="Notas adicionales..."
                    >{{ old('observaciones') }}</textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn-sm"
                    onclick="window.location.href='{{ route('dashboard.importaciones') }}'"
                >
                    Cancelar
                </button>

                <button type="submit" class="btn-success">
                    <i class="fas fa-save"></i>
                    Guardar Orden
                </button>
            </div>
        </form>
    </div>
</div>