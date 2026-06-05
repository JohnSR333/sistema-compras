<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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
            'stockmaximo'  => 'required|integer|min:1',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Nuevo producto: stock normal = 0, stockmaximo = lo que ponga
        $rutaImagen = null;

        if ($request->hasFile('imagen')) {
            // 1. Convertimos a Base64
            $foto = base64_encode(file_get_contents($request->file('imagen')->path()));
            
            // 2. Enviamos a ImgBB
            $respuesta = Http::asForm()->post('https://api.imgbb.com/1/upload', [
                'key' => '9bf099bc90ef731c628393a42c0654c9', 
                'image' => $foto,
            ]);

            // 3. Guardamos enlace
            if ($respuesta->successful()) {
                $rutaImagen = $respuesta->json('data.url');
            }
        }

        Producto::create([
            'nombre'        => $request->nombre,
            'preciocompra'  => $request->preciocompra,
            'descripcion'   => $request->descripcion,
            'stockmaximo'   => $request->stockmaximo,
            'stock'         => 0, // 🔥 CORRECCIÓN: El stock arranca en 0 para poder comprar
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
            'nombre'       => 'required|unique:productos,nombre,' . $id,
            'preciocompra' => 'required|numeric|min:0',
            'stockmaximo'  => 'required|integer|min:1',
            'imagen'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $rutaImagen = $producto->imagen;
        
        // 🔥 CORRECCIÓN: Al actualizar, también enviamos a ImgBB para que no se borre en Render
        if ($request->hasFile('imagen')) {
            $foto = base64_encode(file_get_contents($request->file('imagen')->path()));
            
            $respuesta = Http::asForm()->post('https://api.imgbb.com/1/upload', [
                'key' => '9bf099bc90ef731c628393a42c0654c9', 
                'image' => $foto,
            ]);

            if ($respuesta->successful()) {
                $rutaImagen = $respuesta->json('data.url');
            }
        }

        $producto->update([
            'nombre'        => $request->nombre,
            'preciocompra'  => $request->preciocompra,
            'descripcion'   => $request->descripcion,
            'stockmaximo'   => $request->stockmaximo,
            // stock NO se modifica aquí
            'imagen'        => $rutaImagen,
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