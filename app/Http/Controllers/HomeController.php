<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Ordencompra;
use App\Models\Pago;
use App\Models\Metodopago;
use App\Models\Detallecompra;

class HomeController extends Controller
{
    public function index()
    {
        // =========================
        // Contar registros
        // =========================
        $totalProveedores = Proveedor::count();

        $totalProductos = Producto::count();

        $totalOrdenes = Ordencompra::count();

        $totalPagos = Pago::count();

        $totalMetodos = Metodopago::count();

        $totalDetalles = Detallecompra::count();

        // =========================
        // Retornar vista
        // =========================
        return view('home', compact(
            'totalProveedores',
            'totalProductos',
            'totalOrdenes',
            'totalPagos',
            'totalMetodos',
            'totalDetalles'
        ));
    }
}