<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Support\Facades\Log;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'    => 'required|unique:proveedores,nombre',
            'documento' => 'required|unique:proveedores,documento',
            'telefono'  => 'required',
            'email'     => 'required|email|unique:proveedores,email',
        ]);

        Proveedor::create([
            'nombre'       => $request->nombre,
            'documento'    => $request->documento,
            'direccion'    => $request->direccion,
            'telefono'     => $request->telefono,
            'email'        => $request->email,
            'estado'       => 1,
            'registradopor'=> auth()->user()->name,
        ]);

        return redirect()->route('proveedores.index')->with('successMsg', 'El registro se guardó exitosamente');
    }

    public function show($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.show', compact('proveedor'));
    }

    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre'    => 'required|unique:proveedores,nombre,' . $id,
            'documento' => 'required|unique:proveedores,documento,' . $id,
            'telefono'  => 'required',
            'email'     => 'required|email|unique:proveedores,email,' . $id,
        ]);

        $proveedor = Proveedor::findOrFail($id);

        $proveedor->update([
            'nombre'       => $request->nombre,
            'documento'    => $request->documento,
            'direccion'    => $request->direccion,
            'telefono'     => $request->telefono,
            'email'        => $request->email,
            'registradopor'=> auth()->user()->name,
        ]);

        return redirect()->route('proveedores.index')->with('successMsg', 'El registro se actualizó exitosamente');
    }

    public function destroy($id)
{
    try {
        $proveedor = Proveedor::findOrFail($id);
        // Al eliminar el proveedor, por CASCADE se eliminan todas sus órdenes, detalles y pagos
        $proveedor->delete();
        return redirect()->route('proveedores.index')->with('successMsg', 'Proveedor eliminado exitosamente');
    } catch (QueryException $e) {
        return redirect()->route('proveedores.index')->withErrors('No se puede eliminar el proveedor');
    }
}

    public function cambioestado(Request $request)
    {
        $proveedor = Proveedor::find($request->id);
        $proveedor->estado = $request->estado;
        $proveedor->save();
        return response()->json(['success' => true]);
    }
}