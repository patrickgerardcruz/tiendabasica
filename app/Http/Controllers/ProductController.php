<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Mostrar el catalago (todos los productos activos)
    public function index()
    {
        $productos = Product::where('activo', true)->latest()->get();
        return view('productos.index', compact('productos'));
    }

    // Mostrar formulario para crear producto (panel admin simple)
    public function create()
    {
        return view('productos.create');
    }

    // Guardar producto nuevo
    
   public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nombre', 'descripcion', 'precio']);
        $data['activo'] = true;

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Product::create($data);

        return redirect()->route('productos.index')->with('exito', 'Producto agregado correctamente');
    }

    // Ver un producto individual (opcional, por si quieres una página de detalle)
    public function show(Product $producto)
    {
        return view('productos.show', compact('producto'));
    }

    // Mostrar formulario para editar producto
public function edit(Product $producto)
{
    return view('productos.edit', compact('producto'));
}

// Actualizar producto
public function update(Request $request, Product $producto)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'precio' => 'required|numeric|min:0',
        'imagen' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['nombre', 'descripcion', 'precio']);

    if ($request->hasFile('imagen')) {
        // Eliminar imagen anterior si existe
        if ($producto->imagen) {
            \Storage::disk('public')->delete($producto->imagen);
        }
        $data['imagen'] = $request->file('imagen')->store('productos', 'public');
    }

    $producto->update($data);

    return redirect()->route('productos.index')->with('exito', 'Producto actualizado correctamente');
}

// Eliminar producto
public function destroy(Product $producto)
{
    if ($producto->imagen) {
        \Storage::disk('public')->delete($producto->imagen);
    }

    $producto->delete();

    return redirect()->route('productos.index')->with('exito', 'Producto eliminado correctamente');
}
}

