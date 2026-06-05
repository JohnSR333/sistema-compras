<?php

namespace App\Http\Controllers;

use App\Models\Detallecompra;
use App\Models\Ordencompra;
use App\Models\Producto;
use App\Models\Kardex;
use Illuminate\Http\Request;

class DetalleCompraController extends Controller
{
    // =========================
    // LISTAR
    // =========================
    public function index()
    {
        // 🔥 cargamos orden y producto para poder mostrar datos relacionados
        $detalles = Detallecompra::with(['ordenCompra', 'producto'])
            ->paginate(10);

        return view('detallecompras.index', compact('detalles'));
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        $ordenes = Ordencompra::where('estado', 1)->get();
        $productos = Producto::where('estado', 1)->get();

        return view('detallecompras.create', compact('ordenes', 'productos'));
    }

    // =========================
    // STORE
    // =========================
    public function store(Request $request)
    {
        $request->validate([
            'ordencompra_id' => 'required|exists:ordencompras,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0'
        ]);

        $producto = Producto::findOrFail($request->producto_id);

        $producto->stock += $request->cantidad;
        $producto->save();

        $detalle = Detallecompra::create([
            'ordencompra_id' => $request->ordencompra_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'subtotal' => $request->subtotal,
            'registradopor' => auth()->user()->name
        ]);

        // 💡 actualizar orden
        $orden = Ordencompra::findOrFail($request->ordencompra_id);
        $orden->total += $request->subtotal;
        $orden->saldopendiente = $orden->total;
        $orden->save();

        // 💡 kardex entrada
        Kardex::create([
            'producto_id' => $producto->id,
            'tipo' => 'entrada',
            'cantidad' => $request->cantidad,
            'referencia' => 'Compra #' . $orden->id,
            'registradopor' => auth()->user()->name
        ]);

        return redirect()->route('detallecompras.index')
            ->with('success', 'Compra registrada correctamente');
    }

    // =========================
    // EDITAR
    // =========================
    public function edit($id)
    {
        $detalle = Detallecompra::findOrFail($id);
        $ordenes = Ordencompra::where('estado', 1)->get();
        $productos = Producto::where('estado', 1)->get();

        return view('detallecompras.edit', compact('detalle', 'ordenes', 'productos'));
    }

    // =========================
    // UPDATE
    // =========================
    public function update(Request $request, $id)
    {
        $detalle = Detallecompra::findOrFail($id);

        $request->validate([
            'ordencompra_id' => 'required|exists:ordencompras,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'subtotal' => 'required|numeric|min:0'
        ]);

        $productoAnterior = Producto::findOrFail($detalle->producto_id);
        $productoActual = Producto::findOrFail($request->producto_id);

        $productoAnterior->stock -= $detalle->cantidad;
        if ($productoAnterior->stock < 0) {
            $productoAnterior->stock = 0;
        }
        $productoAnterior->save();

        $productoActual->stock += $request->cantidad;
        $productoActual->save();

        $detalle->update([
            'ordencompra_id' => $request->ordencompra_id,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'subtotal' => $request->subtotal,
            'registradopor' => auth()->user()->name
        ]);

        Kardex::create([
            'producto_id' => $productoActual->id,
            'tipo' => 'ajuste',
            'cantidad' => $request->cantidad,
            'referencia' => 'Edición detalle #' . $detalle->id,
            'registradopor' => auth()->user()->name
        ]);

        return redirect()->route('detallecompras.index')
            ->with('success', 'Actualizado correctamente');
    }

    // =========================
    // DELETE
    // =========================
    public function destroy($id)
    {
        $detalle = Detallecompra::findOrFail($id);

        $producto = Producto::findOrFail($detalle->producto_id);

        $producto->stock -= $detalle->cantidad;
        if ($producto->stock < 0) {
            $producto->stock = 0;
        }
        $producto->save();

        Kardex::create([
            'producto_id' => $producto->id,
            'tipo' => 'salida',
            'cantidad' => $detalle->cantidad,
            'referencia' => 'Eliminación detalle #' . $detalle->id,
            'registradopor' => auth()->user()->name
        ]);

        $detalle->delete();

        return redirect()->route('detallecompras.index')
            ->with('success', 'Eliminado correctamente');
    }
}