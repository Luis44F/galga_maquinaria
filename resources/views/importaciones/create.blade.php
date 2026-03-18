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


        <!-- FORMULARIO - CORREGIDO: action="/importaciones" -->
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

                            <option value="{{ $proveedor->id }}">
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
                            value="{{ now()->toDateString() }}"
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
                    >

                </div>



                <div class="form-group">

                    <label class="form-label">Estado *</label>

                    <select name="estado" class="form-control" required>

                        <option value="pendiente">Pendiente</option>
                        <option value="en_transito">En Tránsito</option>
                        <option value="recibida">Recibida</option>
                        <option value="cancelada">Cancelada</option>

                    </select>

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
                    ></textarea>

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