<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompraController extends Controller
{
    public function index()
    {
        return view('compras.index');
    }

    public function create()
    {
        return view('compras.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('compra.index');
    }

    public function show($id)
    {
        return view('compras.show', compact('id'));
    }

    public function edit($id)
    {
        return view('compras.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('compra.index');
    }

    public function destroy($id)
    {
        return redirect()->route('compra.index');
    }
}
