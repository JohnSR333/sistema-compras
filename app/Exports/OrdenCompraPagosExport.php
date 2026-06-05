<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;

class OrdenCompraPagosExport implements FromArray, WithHeadings, WithStyles
{
    protected $orden;

    public function __construct($orden)
    {
        $this->orden = $orden;
    }

    public function array(): array
    {
        $data = [];
        $data[] = ['REGISTRO DE PAGOS - ORDEN N° ' . $this->orden->id];
        $data[] = [];

        foreach ($this->orden->pagos as $pago) {
            $data[] = [
                date('d/m/Y H:i', strtotime($pago->fechapago)),
                '$' . number_format($pago->monto, 2),
                $pago->metodoPago->nombre ?? 'N/A',
                $pago->registradopor,
            ];
        }

        $data[] = [];
        $data[] = ['TOTAL PAGADO', '$' . number_format($this->orden->pagos->sum('monto'), 2), '', ''];

        return $data;
    }

    public function headings(): array
    {
        return ['Fecha', 'Monto', 'Método de Pago', 'Registrado por'];
    }

    public function styles($sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A' . $lastRow)->getFont()->setBold(true);
        
        $sheet->getStyle('A2:D' . ($lastRow - 1))->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);
    }
}