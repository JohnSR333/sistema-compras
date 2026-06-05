<?php

namespace App\Http\Controllers;

use App\Models\Ordencompra;
use App\Models\Detallecompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Metodopago;
use App\Models\Pago;
use Illuminate\Http\Request;
use PDF;
use Excel;
use App\Exports\OrdenCompraExport;
use App\Exports\OrdenesComprasExport;
use App\Exports\OrdenesExport;
use App\Exports\OrdenesComprasCompletoExport;

class OrdenCompraController extends Controller
{
    

public function generarExcelGeneral()
{
    return Excel::download(new OrdenesComprasCompletoExport(), 'ordenes-compras-completo.xlsx');
}

    public function index()
    {
        $ordencompras = Ordencompra::with('proveedor')->get();
        return view('ordencompras.index', compact('ordencompras'));
    }

    public function create()
    {
        $proveedores = Proveedor::where('estado', '1')->get();
        $productos = Producto::where('estado', '1')->get();
        $metodosPago = Metodopago::where('estado', '1')->get();
        return view('ordencompras.create', compact('proveedores', 'productos', 'metodosPago'));
    }

public function store(Request $request)
    {
        // TRAMPA 1: Ver si Laravel está rechazando el formulario
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'proveedor_id' => 'required|exists:proveedores,id',
            'fecha' => 'required|date',
            'tipopago' => 'required|in:contado,credito',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            dd('🚨 TRAMPA 1 (Error de Formulario):', $validator->errors()->all());
        }

        // TRAMPA 2: Ver si el problema es el cálculo del Stock
        foreach ($request->productos as $item) {
            $producto = Producto::find($item['id']);
            $nuevoStock = $producto->stock + $item['cantidad'];
            
            if ($nuevoStock > $producto->stockmaximo) {
                dd(
                    '🚨 TRAMPA 2 (Error de Stock Máximo):',
                    'Producto: ' . $producto->nombre,
                    'Stock actual que tiene en BD: ' . $producto->stock,
                    'Cantidad que intentas comprar: ' . $item['cantidad'],
                    'Stock máximo permitido en BD: ' . $producto->stockmaximo
                );
            }
        }

        // TRAMPA 3: Ver si todo pasó limpio
        dd('✅ TRAMPA 3: Todo pasó perfecto. El error está en la base de datos al guardar la Orden.');
    }

    public function show($id)
    {
        $orden = Ordencompra::with(['proveedor', 'detalles.producto', 'pagos'])->findOrFail($id);
        return view('ordencompras.show', compact('orden'));
    }

    public function edit($id)
    {
        $orden = Ordencompra::findOrFail($id);
        $proveedores = Proveedor::where('estado', '1')->get();
        $productos = Producto::where('estado', '1')->get();
        $metodosPago = Metodopago::where('estado', '1')->get();
        return view('ordencompras.edit', compact('orden', 'proveedores', 'productos', 'metodosPago'));
    }

    public function update(Request $request, $id)
    {
        $orden = Ordencompra::findOrFail($id);

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
            $orden = Ordencompra::findOrFail($id);

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
        $orden = Ordencompra::find($request->id);
        if ($orden) {
            $orden->estado = $request->estado;
            $orden->save();
        }
        return response()->json(['success' => true]);
    }

    // PDF
    public function generarPDF($id)
{
    $orden = OrdenCompra::with(['proveedor', 'detalles.producto', 'pagos.metodoPago'])->findOrFail($id);

    $data = [
        'orden' => $orden,
        'fecha' => now()->format('d/m/Y H:i'),
    ];

    $pdf = PDF::loadView('ordencompras.pdf', $data)->setPaper('a4', 'portrait');
    return $pdf->stream('orden-compra-' . $orden->id . '.pdf');
}

    // EXCEL
public function generarExcel($id)
{
    $orden = OrdenCompra::with(['proveedor', 'detalles.producto', 'pagos.metodoPago'])->findOrFail($id);
    return Excel::download(new OrdenCompraCompletoExport($orden), 'orden-compra-' . $id . '.xlsx');
}
}