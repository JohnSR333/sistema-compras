<?php

namespace App\Exports;

use App\Models\Pago;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;

class OrdenesComprasPagosExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Pago::with(['ordenCompra.proveedor', 'metodoPago'])->get();
    }

    public function headings(): array
    {
        return [
            'Orden #',
            'Proveedor',
            'Fecha Pago',
            'Monto',
            'Método de Pago',
            'Registrado por'
        ];
    }

    public function map($pago): array
    {
        return [
            $pago->ordenCompra->id,
            $pago->ordenCompra->proveedor->nombre ?? 'N/A',
            date('d/m/Y H:i', strtotime($pago->fechapago)),
            '$' . number_format($pago->monto, 2),
            $pago->metodoPago->nombre ?? 'N/A',
            $pago->registradopor,
        ];
    }

    public function styles($sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}