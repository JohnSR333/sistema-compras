<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\OrdenCompra;
use App\Models\MetodoPago;
use App\Http\Requests\PagoRequest;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class PagoController extends Controller
{
    public function index()
{
    $pagos = Pago::with(['ordenCompra', 'metodoPago'])->get(); // ← get(), no paginate()
    return view('pagos.index', compact('pagos'));
}

    public function create()
    {
        $ordenes = OrdenCompra::where('saldopendiente', '>', 0)->get();
        $metodos = MetodoPago::where('estado', '1')->get();
        return view('pagos.create', compact('ordenes', 'metodos'));
    }

    public function store(PagoRequest $request)
    {
        $orden = OrdenCompra::findOrFail($request->ordencompra_id);

        // Validar que no se pague más del saldo pendiente
        if ($request->monto > $orden->saldopendiente) {
            return back()->withErrors('El monto no puede superar el saldo pendiente de $' . number_format($orden->saldopendiente, 2));
        }

        // Crear pago
        Pago::create([
            'ordencompra_id' => $request->ordencompra_id,
            'fechapago' => now(),
            'monto' => $request->monto,
            'metodopago_id' => $request->metodopago_id,
            'registradopor' => auth()->user()->name,
        ]);

        // Actualizar saldo pendiente
        $nuevoSaldo = $orden->saldopendiente - $request->monto;
        $orden->update([
            'saldopendiente' => $nuevoSaldo,
            'estado' => $nuevoSaldo <= 0 ? 'pagado' : 'pendiente',
        ]);

        return redirect()->route('pagos.index')->with('successMsg', 'Pago registrado exitosamente');
    }

    public function show($id)
    {
        $pago = Pago::with(['ordenCompra.proveedor', 'metodoPago'])->findOrFail($id);
        return view('pagos.show', compact('pago'));
    }

    public function edit($id)
    {
        $pago = Pago::findOrFail($id);
        $ordenes = OrdenCompra::all();
        $metodos = MetodoPago::where('estado', '1')->get();
        return view('pagos.edit', compact('pago', 'ordenes', 'metodos'));
    }

    public function update(PagoRequest $request, $id)
    {
        $pago = Pago::findOrFail($id);
        $ordenAntes = $pago->ordenCompra;

        // Si cambia el monto, ajustar saldo pendiente
        if ($request->monto != $pago->monto) {
            $diferencia = $request->monto - $pago->monto;
            $nuevoSaldo = $ordenAntes->saldopendiente - $diferencia;
            
            if ($nuevoSaldo < 0) {
                return back()->withErrors('El nuevo monto excede el saldo pendiente');
            }
            
            $ordenAntes->update([
                'saldopendiente' => $nuevoSaldo,
                'estado' => $nuevoSaldo <= 0 ? 'pagado' : 'pendiente',
            ]);
        }

        $pago->update([
            'ordencompra_id' => $request->ordencompra_id,
            'monto' => $request->monto,
            'metodopago_id' => $request->metodopago_id,
            'registradopor' => auth()->user()->name,
        ]);

        return redirect()->route('pagos.index')->with('successMsg', 'Pago actualizado exitosamente');
    }

    public function destroy($id)
    {
        try {
            $pago = Pago::findOrFail($id);
            $orden = $pago->ordenCompra;

            // Restaurar saldo pendiente
            $nuevoSaldo = $orden->saldopendiente + $pago->monto;
            $orden->update([
                'saldopendiente' => $nuevoSaldo,
                'estado' => 'pendiente',
            ]);

            $pago->delete();

            return redirect()->route('pagos.index')->with('successMsg', 'Pago eliminado exitosamente');
        } catch (Exception $e) {
            return redirect()->route('pagos.index')->withErrors('No se puede eliminar el pago');
        }
    }

    public function cambioestado(Request $request)
    {
        $pago = Pago::find($request->id);
        if ($pago) {
            $pago->estado = $request->estado;
            $pago->save();
        }
        return response()->json(['success' => true]);
    }
}