<?php

// app/Http/Controllers/ProductoController.php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Mostrar productos destacados en el home
public function home()
{
    $featuredProductos = Producto::where('featured', true)->take(8)->get();
    $productos = Producto::all(); // Agrega esta línea
    
    return view('pagina/welcome', compact('featuredProductos', 'productos'));
}

    // Mostrar todos los productos
public function index()
{
    if (auth()->check() && auth()->user()->role === 'admin') {
        // Vista para administración
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }

    // Vista pública
    $featuredProductos = Producto::where('featured', true)->take(8)->get();
    $allProducts = Producto::all();

    return view('productos.index', compact('featuredProductos', 'allProducts'));
}

    // Mostrar formulario de creación
    public function create()
    {
        return view('admin.productos.create');
    }

    // Almacenar nuevo producto
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categoria' => 'required|string|max:255',
            'featured' => 'sometimes|boolean'
        ]);

        $imagePath = $request->file('image')->store('productos', 'public');

        Producto::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image' => $imagePath,
            'categoria' => $request->categoria,
            'featured' => $request->boolean('featured')
        ]);

        return redirect()->route('admin.productos.index')
                         ->with('success', 'Producto creado exitosamente');
    }

    // Mostrar panel de administración
    public function adminIndex()
    {
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
