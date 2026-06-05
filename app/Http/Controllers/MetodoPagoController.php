<?php

namespace App\Http\Controllers;

use App\Models\Metodopago;
use App\Http\Requests\MetodoPagoRequest;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class MetodopagoController extends Controller
{
    public function index()
    {
        $metodopagos = Metodopago::all();
        return view('metodopagos.index', compact('metodopagos'));
    }

    public function create()
    {
        return view('metodopagos.create');
    }

    public function store(MetodoPagoRequest $request)
    {
        MetodoPago::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado' => '1',
            'registradopor' => auth()->user()->name,
        ]);

        return redirect()->route('metodopagos.index')->with('successMsg', 'Método de pago creado exitosamente');
    }

    public function show($id)
    {
        $metodopago = Metodopago::findOrFail($id);
        return view('metodopagos.show', compact('metodopago'));
    }

    public function edit($id)
    {
        $metodopago = Metodopago::findOrFail($id);
        return view('metodopagos.edit', compact('metodopago'));
    }

    public function update(MetodoPagoRequest $request, $id)
    {
        $metodopago = Metodopago::findOrFail($id);

        $metodopago->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'registradopor' => auth()->user()->name,
        ]);

        return redirect()->route('metodopagos.index')->with('successMsg', 'Método de pago actualizado exitosamente');
    }

    public function destroy($id)
    {
        try {
            $metodopago = Metodopago::findOrFail($id);
            $metodopago->delete();
            return redirect()->route('metodopagos.index')->with('successMsg', 'Método de pago eliminado exitosamente');
        } catch (QueryException $e) {
            Log::error('Error al eliminar el método de pago: ' . $e->getMessage());
            return redirect()->route('metodopagos.index')->withErrors('No se puede eliminar el método de pago porque tiene pagos relacionados');
        } catch (Exception $e) {
            Log::error('Error inesperado: ' . $e->getMessage());
            return redirect()->route('metodopagos.index')->withErrors('Ocurrió un error inesperado');
        }
    }

    public function cambioestado(Request $request)
    {
        $metodopago = Metodopago::find($request->id);
        if ($metodopago) {
            $metodopago->estado = $request->estado;
            $metodopago->save();
        }
        return response()->json(['success' => true]);
    }
}