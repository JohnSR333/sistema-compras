<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        return view('productos.create');
    }

public function store(Request $request)
{
    $request->validate([
        'nombre'       => 'required',
        'preciocompra' => 'required|numeric|min:0',
        'stockmaximo'  => 'required|integer|min:0',
        'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $rutaImagen = null;

    if ($request->hasFile('imagen')) {
        $file = $request->file('imagen');
        $nombreImagen = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Ruta ABSOLUTA para garantizar que existe
        $targetPath = '/var/www/html/public/images/productos';
        
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }
        
        $file->move($targetPath, $nombreImagen);
        $rutaImagen = '/images/productos/' . $nombreImagen;
    }

    Producto::create([
        'nombre'        => $request->nombre,
        'preciocompra'  => $request->preciocompra,
        'descripcion'   => $request->descripcion,
        'stockmaximo'   => $request->stockmaximo,
        'stock'         => $request->stockmaximo,
        'imagen'        => $rutaImagen,
        'estado'        => '1',
        'registradopor' => auth()->user()->name,
    ]);

    return redirect()->route('productos.index')->with('successMsg', 'Producto registrado exitosamente');
}

    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.show', compact('producto'));
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

public function update(Request $request, $id)
{
    $producto = Producto::findOrFail($id);

    $request->validate([
        'nombre' => 'required|unique:productos,nombre,' . $id,
        'preciocompra' => 'required|numeric|min:0',
        'stockmaximo' => 'required|integer|min:0',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $rutaImagen = $producto->imagen;
    if ($request->hasFile('imagen')) {
        $file = $request->file('imagen');
        $nombre = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images/productos'), $nombre);
        $rutaImagen = 'images/productos/' . $nombre;
    }

    $producto->update([
        'nombre' => $request->nombre,
        'preciocompra' => $request->preciocompra,
        'descripcion' => $request->descripcion,
        'stockmaximo' => $request->stockmaximo,
        // stock NO se modifica aquí
        'imagen' => $rutaImagen,
        'registradopor' => auth()->user()->name,
    ]);

    return redirect()->route('productos.index')->with('successMsg', 'Producto actualizado exitosamente');
}

    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();
            return redirect()->route('productos.index')->with('successMsg', 'Producto eliminado exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al eliminar el producto: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('No se puede eliminar el producto porque tiene compras relacionadas');
        } catch (Exception $e) {
            Log::error('Error inesperado: ' . $e->getMessage());
            return redirect()->route('productos.index')->withErrors('Ocurrió un error inesperado');
        }
    }

    public function cambioestado(Request $request)
    {
        $producto = Producto::find($request->id);
        if ($producto) {
            $producto->estado = $request->estado;
            $producto->save();
        }
        return response()->json(['success' => true]);
    }
}