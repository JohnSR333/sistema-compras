<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrdenesComprasCompletoExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new OrdenesComprasExport(),           // Hoja 1: Resumen de órdenes
            new OrdenesComprasPagosExport(),      // Hoja 2: Detalle de pagos
        ];
    }
}