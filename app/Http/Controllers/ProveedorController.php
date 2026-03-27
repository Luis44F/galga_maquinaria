<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $usuario = Auth::user();
        
        $query = Proveedor::query();
        
        if ($request->filled('buscar')) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->buscar . '%')
                  ->orWhere('codigo', 'like', '%' . $request->buscar . '%')
                  ->orWhere('nit', 'like', '%' . $request->buscar . '%')
                  ->orWhere('pais', 'like', '%' . $request->buscar . '%');
            });
        }
        
        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->filled('activo')) {
            $query->where('activo', $request->activo);
        }
        
        if ($request->filled('pais')) {
            $query->where('pais', $request->pais);
        }
        
        $proveedores = $query->orderBy('nombre', 'asc')->paginate(15);
        
        $paises = Proveedor::whereNotNull('pais')->distinct()->pluck('pais');
        
        // Si es una petición AJAX, devolver JSON con el HTML de la tabla
        if ($request->ajax()) {
            $html = view('importaciones.proveedores.lista', compact('proveedores'))->render();
            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
        
        return view('importaciones.proveedores.index', compact('usuario', 'proveedores', 'paises'));
    }

    public function create()
    {
        $usuario = Auth::user();
        return view('importaciones.proveedores.create', compact('usuario'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('proveedores', 'codigo')
            ],
            'nombre' => 'required|string|max:255',
            'razon_social' => 'nullable|string|max:255',
            'nit' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('proveedores', 'nit')
            ],
            'pais' => 'nullable|string|max:100',
            'ciudad' => 'nullable|string|max:100',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'contacto_nombre' => 'nullable|string|max:255',
            'contacto_telefono' => 'nullable|string|max:50',
            'contacto_email' => 'nullable|email|max:255',
            'tipo' => 'required|in:nacional,internacional',
            'observaciones' => 'nullable|string',
            'activo' => 'sometimes|boolean'
        ]);

        try {
            $proveedor = Proveedor::create([
                'codigo' => $validated['codigo'],
                'nombre' => $validated['nombre'],
                'razon_social' => $validated['razon_social'] ?? null,
                'nit' => $validated['nit'] ?? null,
                'pais' => $validated['pais'] ?? null,
                'ciudad' => $validated['ciudad'] ?? null,
                'direccion' => $validated['direccion'] ?? null,
                'telefono' => $validated['telefono'] ?? null,
                'email' => $validated['email'] ?? null,
                'contacto_nombre' => $validated['contacto_nombre'] ?? null,
                'contacto_telefono' => $validated['contacto_telefono'] ?? null,
                'contacto_email' => $validated['contacto_email'] ?? null,
                'tipo' => $validated['tipo'],
                'observaciones' => $validated['observaciones'] ?? null,
                'activo' => $request->has('activo') ? 1 : 0
            ]);
            
            return redirect()->route('proveedores.index')
                ->with('success', 'Proveedor registrado correctamente');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error al registrar: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Proveedor $proveedore)
    {
        $usuario = Auth::user();
        $proveedor = $proveedore;
        $proveedor->load('ordenesCompra');
        return view('importaciones.proveedores.show', compact('usuario', 'proveedor'));
    }

    public function edit(Proveedor $proveedore)
    {
        $usuario = Auth::user();
        $proveedor = $proveedore;
        return view('importaciones.proveedores.edit', compact('usuario', 'proveedor'));
    }

    public function update(Request $request, Proveedor $proveedore)
    {
        $proveedor = $proveedore;
        
        $validated = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('proveedores', 'codigo')->ignore($proveedor->id)
            ],
            'nombre' => 'required|string|max:255',
            'razon_social' => 'nullable|string|max:255',
            'nit' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('proveedores', 'nit')->ignore($proveedor->id)
            ],
            'pais' => 'nullable|string|max:100',
            'ciudad' => 'nullable|string|max:100',
            'direccion' => 'nullable|string',
            'telefono' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'contacto_nombre' => 'nullable|string|max:255',
            'contacto_telefono' => 'nullable|string|max:50',
            'contacto_email' => 'nullable|email|max:255',
            'tipo' => 'required|in:nacional,internacional',
            'observaciones' => 'nullable|string',
            'activo' => 'sometimes|boolean'
        ]);

        try {
            $proveedor->update([
                'codigo' => $validated['codigo'],
                'nombre' => $validated['nombre'],
                'razon_social' => $validated['razon_social'] ?? null,
                'nit' => $validated['nit'] ?? null,
                'pais' => $validated['pais'] ?? null,
                'ciudad' => $validated['ciudad'] ?? null,
                'direccion' => $validated['direccion'] ?? null,
                'telefono' => $validated['telefono'] ?? null,
                'email' => $validated['email'] ?? null,
                'contacto_nombre' => $validated['contacto_nombre'] ?? null,
                'contacto_telefono' => $validated['contacto_telefono'] ?? null,
                'contacto_email' => $validated['contacto_email'] ?? null,
                'tipo' => $validated['tipo'],
                'observaciones' => $validated['observaciones'] ?? null,
                'activo' => $request->has('activo') ? 1 : 0
            ]);
            
            return redirect()->route('proveedores.show', $proveedor)
                ->with('success', 'Proveedor actualizado correctamente');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Error al actualizar: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Proveedor $proveedore)
    {
        $proveedor = $proveedore;
        
        try {
            if ($proveedor->ordenesCompra()->count() > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede eliminar el proveedor porque tiene ' . $proveedor->ordenesCompra()->count() . ' órdenes de compra asociadas. Desactívelo en su lugar.'
                ], 400);
            }
            
            $proveedor->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Proveedor eliminado correctamente'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function toggleActivo(Proveedor $proveedore)
    {
        $proveedor = $proveedore;
        
        try {
            $proveedor->activo = !$proveedor->activo;
            $proveedor->save();
            
            return response()->json([
                'success' => true,
                'message' => $proveedor->activo ? 'Proveedor activado correctamente' : 'Proveedor desactivado correctamente',
                'activo' => $proveedor->activo
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}