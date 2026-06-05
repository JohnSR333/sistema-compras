<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdenCompraRequest;
use App\Models\Ordencompra;
use App\Models\Detallecompra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Metodopago;
use App\Models\Pago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Excel;
use App\Exports\OrdenCompraExport;
use App\Exports\OrdenesComprasExport;
use App\Exports\OrdenesExport;

class OrdenCompraController extends Controller
{
    


public function exportarExcel()
{
    return Excel::download(new OrdenesExport(), 'ordenes-compras.xlsx');
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

    public function store(OrdenCompraRequest $request)
    {
        $validated = $request->validated();
        $total = 0;

        DB::beginTransaction();

        try {
            $orden = Ordencompra::create([
                'fecha' => $validated['fecha'],
                'proveedor_id' => $validated['proveedor_id'],
                'total' => 0,
                'tipopago' => $validated['tipopago'],
                'saldopendiente' => 0,
                'estado' => '1',
                'registradopor' => auth()->user()->name,
            ]);

            foreach ($validated['productos'] as $item) {
                $producto = Producto::findOrFail($item['id']);
                $cantidad = intval($item['cantidad']);
                $subtotal = $producto->preciocompra * $cantidad;
                $total += $subtotal;

                Detallecompra::create([
                    'ordencompra_id' => $orden->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $cantidad,
                    'subtotal' => $subtotal,
                    'registradopor' => auth()->user()->name,
                ]);

                $producto->stock += $cantidad;
                $producto->save();
            }

            if ($validated['tipopago'] === 'contado') {
                Pago::create([
                    'ordencompra_id' => $orden->id,
                    'fechapago' => now(),
                    'monto' => $total,
                    'metodopago_id' => $validated['metodopago_id'],
                    'registradopor' => auth()->user()->name,
                ]);

                $orden->update(['total' => $total, 'saldopendiente' => 0]);
                $mensaje = 'Orden de compra creada y PAGADA exitosamente';
            } else {
                $abonoInicial = floatval($request->input('abono_inicial', 0));

                if ($abonoInicial < 0) {
                    throw new \Exception('El abono inicial no puede ser negativo');
                }

                if ($abonoInicial > $total) {
                    throw new \Exception('El abono inicial no puede ser mayor al total de la orden');
                }

                $nuevoSaldo = $total - $abonoInicial;

                $orden->update(['total' => $total, 'saldopendiente' => $nuevoSaldo]);

                if ($abonoInicial > 0) {
                    Pago::create([
                        'ordencompra_id' => $orden->id,
                        'fechapago' => now(),
                        'monto' => $abonoInicial,
                        'metodopago_id' => $validated['metodopago_id'],
                        'registradopor' => auth()->user()->name,
                    ]);
                }

                $mensaje = 'Orden de compra creada. ';
                if ($abonoInicial > 0) {
                    $mensaje .= 'Abono inicial: $' . number_format($abonoInicial, 2) . '. ';
                }
                $mensaje .= 'Saldo pendiente: $' . number_format($nuevoSaldo, 2);
            }

            DB::commit();

            return redirect()->route('ordencompras.index')->with('successMsg', $mensaje);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors($e->getMessage())->withInput();
        }
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