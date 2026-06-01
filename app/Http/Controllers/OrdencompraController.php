<?php

namespace App\Http\Controllers;

use App\Models\OrdenCompra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\MetodoPago;
use App\Models\Pago;
use Illuminate\Http\Request;

class OrdenCompraController extends Controller
{
    public function index()
    {
        $ordencompras = OrdenCompra::with('proveedor')->get();
        return view('ordencompras.index', compact('ordencompras'));
    }

    public function create()
    {
        $proveedores = Proveedor::where('estado', '1')->get();
        $productos = Producto::where('estado', '1')->get();
        $metodosPago = MetodoPago::where('estado', '1')->get();
        return view('ordencompras.create', compact('proveedores', 'productos', 'metodosPago'));
    }

    public function store(Request $request)
    {
        // Validación básica
        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'tipopago' => 'required|in:contado,credito',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        // VALIDACIÓN DE STOCK MÁXIMO
        foreach ($request->productos as $item) {
            $producto = Producto::find($item['id']);
            $nuevoStock = $producto->stock + $item['cantidad'];
            
            if ($nuevoStock > $producto->stockmaximo) {
                $disponible = $producto->stockmaximo - $producto->stock;
                return redirect()->back()
                    ->withErrors(["No se puede comprar {$item['cantidad']} unidades de '{$producto->nombre}'. Stock actual: {$producto->stock}, Máximo: {$producto->stockmaximo}. Solo puedes comprar hasta {$disponible} unidades."])
                    ->withInput();
            }
        }

        // Si es CONTADO, necesita método de pago
        if ($request->tipopago == 'contado') {
            // Si no viene método de pago, asigna el primero disponible
            if (empty($request->metodopago_id)) {
                $primerMetodo = MetodoPago::where('estado', '1')->first();
                if ($primerMetodo) {
                    $request->merge(['metodopago_id' => $primerMetodo->id]);
                }
            }
            
            $request->validate([
                'metodopago_id' => 'required|exists:metodopagos,id',
            ]);
        }

        $total = 0;

        // Crear orden
        $orden = OrdenCompra::create([
            'fecha' => $request->fecha,
            'proveedor_id' => $request->proveedor_id,
            'total' => 0,
            'tipopago' => $request->tipopago,
            'saldopendiente' => 0,
            'estado' => '1',
            'registradopor' => auth()->user()->name,
        ]);

        // Crear detalles y calcular total
        foreach ($request->productos as $item) {
            $producto = Producto::find($item['id']);
            $subtotal = $producto->preciocompra * $item['cantidad'];
            $total += $subtotal;

            DetalleCompra::create([
                'ordencompra_id' => $orden->id,
                'producto_id' => $item['id'],
                'cantidad' => $item['cantidad'],
                'subtotal' => $subtotal,
                'registradopor' => auth()->user()->name,
            ]);

            // Aumentar stock
            $producto->stock += $item['cantidad'];
            $producto->save();
        }

        // Lógica según tipo de pago
        if ($request->tipopago == 'contado') {
            Pago::create([
                'ordencompra_id' => $orden->id,
                'fechapago' => now(),
                'monto' => $total,
                'metodopago_id' => $request->metodopago_id,
                'registradopor' => auth()->user()->name,
            ]);
            $orden->update([
                'total' => $total,
                'saldopendiente' => 0,
            ]);
            $mensaje = 'Orden de compra creada y PAGADA exitosamente';
        } else {
            $orden->update([
                'total' => $total,
                'saldopendiente' => $total,
            ]);
            $mensaje = 'Orden de compra creada. Saldo pendiente: $' . number_format($total, 2);
        }

        return redirect()->route('ordencompras.index')->with('successMsg', $mensaje);
    }

    public function show($id)
    {
        $orden = OrdenCompra::with(['proveedor', 'detalles.producto', 'pagos'])->findOrFail($id);
        return view('ordencompras.show', compact('orden'));
    }

    public function edit($id)
    {
        $orden = OrdenCompra::findOrFail($id);
        $proveedores = Proveedor::where('estado', '1')->get();
        $productos = Producto::where('estado', '1')->get();
        $metodosPago = MetodoPago::where('estado', '1')->get();
        return view('ordencompras.edit', compact('orden', 'proveedores', 'productos', 'metodosPago'));
    }

    public function update(Request $request, $id)
    {
        $orden = OrdenCompra::findOrFail($id);

        $request->validate([
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'tipopago' => 'required|in:contado,credito',
        ]);

        $orden->update([
            'fecha' => $request->fecha,
            'proveedor_id' => $request->proveedor_id,
            'tipopago' => $request->tipopago,
            'registradopor' => auth()->user()->name,
        ]);

        return redirect()->route('ordencompras.index')->with('successMsg', 'Orden actualizada exitosamente');
    }

    public function destroy($id)
    {
        try {
            $orden = OrdenCompra::findOrFail($id);

            foreach ($orden->detalles as $detalle) {
                $producto = $detalle->producto;
                $producto->stock -= $detalle->cantidad;
                if ($producto->stock < 0) $producto->stock = 0;
                $producto->save();
            }

            $orden->delete();
            return redirect()->route('ordencompras.index')->with('successMsg', 'Orden eliminada exitosamente');
        } catch (\Exception $e) {
            return redirect()->route('ordencompras.index')->withErrors('No se puede eliminar la orden');
        }
    }

    public function cambioestado(Request $request)
    {
        $orden = OrdenCompra::find($request->id);
        if ($orden) {
            $orden->estado = $request->estado;
            $orden->save();
        }
        return response()->json(['success' => true]);
    }
}