<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrdenCompraCompletoExport implements WithMultipleSheets
{
    protected $orden;

    public function __construct($orden)
    {
        $this->orden = $orden;
    }

    public function sheets(): array
    {
        return [
            new OrdenCompraExport($this->orden),
            new OrdenCompraPagosExport($this->orden),
        ];
    }
}