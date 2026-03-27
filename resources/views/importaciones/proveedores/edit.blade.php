<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GALGA · Editar Proveedor</title>
    
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
            --primary-dark: #0284c7;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --card-bg: #111827;
            --card-border: #1f2937;
            --text-light: #f8fafc;
            --text-dim: #94a3b8;
            --dark-bg: #0a0f1c;
        }
        .container { max-width: 800px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 16px; }
        h1 { font-size: 28px; font-weight: 700; color: var(--text-light); }
        .btn-back { background: transparent; border: 1px solid var(--card-border); color: var(--text-dim); padding: 10px 20px; border-radius: 10px; text-decoration: none; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-back:hover { background: var(--card-border); color: var(--text-light); }
        .card { background: var(--card-bg); border: 1px solid var(--card-border); border-radius: 24px; padding: 32px; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 30px; font-size: 11px; font-weight: 500; background: rgba(14, 165, 233, 0.2); color: var(--primary); margin-left: 12px; }
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; color: var(--text-dim); font-size: 14px; font-weight: 500; margin-bottom: 8px; }
        .form-label .required { color: var(--danger); }
        .form-control, .form-select { width: 100%; padding: 12px 16px; background: var(--dark-bg); border: 1px solid var(--card-border); border-radius: 12px; color: var(--text-light); font-family: 'Inter', sans-serif; font-size: 14px; transition: all 0.3s; }
        .form-control:focus, .form-select:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.2); }
        textarea.form-control { resize: vertical; min-height: 100px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-check { display: flex; align-items: center; gap: 10px; margin-top: 8px; }
        .form-check input { width: 18px; height: 18px; accent-color: var(--primary); }
        .section-title { font-size: 18px; font-weight: 600; color: var(--primary); margin: 24px 0 16px 0; padding-bottom: 8px; border-bottom: 1px solid var(--card-border); }
        .actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 32px; }
        .btn-primary { background: var(--primary); color: #0a0f1c; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .btn-primary:hover { background: var(--primary-dark); transform: translateY(-2px); }
        .btn-secondary { background: transparent; border: 1px solid var(--card-border); color: var(--text-dim); padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .btn-secondary:hover { background: var(--card-border); color: var(--text-light); }
        .btn-danger { background: var(--danger); color: white; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px; }
        .alert { padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; }
        .alert-danger { background: rgba(239, 68, 68, 0.1); border: 1px solid var(--danger); color: var(--danger); }
        hr { border-color: var(--card-border); margin: 20px 0; }
        @media (max-width: 768px) {
            body { padding: 16px; }
            .card { padding: 20px; }
            .form-row { grid-template-columns: 1fr; }
            .actions { flex-direction: column; }
            .btn-primary, .btn-secondary, .btn-danger { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-edit"></i> Editar Proveedor</h1>
            <a href="{{ route('proveedores.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <ul style="margin-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3 style="color: var(--text-light);">{{ $proveedor->codigo }} - {{ $proveedor->nombre }}</h3>
                <span class="badge">{{ $proveedor->ordenesCompra->count() }} órdenes asociadas</span>
            </div>

            <form action="{{ route('proveedores.update', $proveedor) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Código <span class="required">*</span></label>
                        <input type="text" name="codigo" class="form-control" value="{{ old('codigo', $proveedor->codigo) }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">NIT</label>
                        <input type="text" name="nit" class="form-control" value="{{ old('nit', $proveedor->nit) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nombre <span class="required">*</span></label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $proveedor->nombre) }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Razón Social</label>
                    <input type="text" name="razon_social" class="form-control" value="{{ old('razon_social', $proveedor->razon_social) }}">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">País</label>
                        <input type="text" name="pais" class="form-control" value="{{ old('pais', $proveedor->pais) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ciudad</label>
                        <input type="text" name="ciudad" class="form-control" value="{{ old('ciudad', $proveedor->ciudad) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $proveedor->direccion) }}">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $proveedor->telefono) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $proveedor->email) }}">
                    </div>
                </div>

                <div class="section-title">
                    <i class="fas fa-user-tie"></i> Persona de Contacto
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nombre</label>
                        <input type="text" name="contacto_nombre" class="form-control" value="{{ old('contacto_nombre', $proveedor->contacto_nombre) }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Teléfono</label>
                        <input type="text" name="contacto_telefono" class="form-control" value="{{ old('contacto_telefono', $proveedor->contacto_telefono) }}">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Email de Contacto</label>
                    <input type="email" name="contacto_email" class="form-control" value="{{ old('contacto_email', $proveedor->contacto_email) }}">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Tipo de Proveedor <span class="required">*</span></label>
                        <select name="tipo" class="form-select">
                            <option value="nacional" {{ old('tipo', $proveedor->tipo) == 'nacional' ? 'selected' : '' }}>🇨🇴 Nacional</option>
                            <option value="internacional" {{ old('tipo', $proveedor->tipo) == 'internacional' ? 'selected' : '' }}>🌎 Internacional</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Estado</label>
                        <div class="form-check" style="margin-top: 10px;">
                            <input type="checkbox" name="activo" id="activo" value="1" {{ old('activo', $proveedor->activo) ? 'checked' : '' }}>
                            <label for="activo">Activo</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Observaciones</label>
                    <textarea name="observaciones" class="form-control" placeholder="Información adicional...">{{ old('observaciones', $proveedor->observaciones) }}</textarea>
                </div>

                <hr>

                <div class="actions">
                    <a href="{{ route('proveedores.index') }}" class="btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                    @if($proveedor->ordenesCompra->count() == 0)
                        <button type="button" onclick="eliminarProveedor({{ $proveedor->id }})" class="btn-danger">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    @endif
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
            </form>
        </div>
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
    </script>
</body>
</html>