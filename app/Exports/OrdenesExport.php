<?php

namespace App\Exports;

use App\Models\OrdenCompra;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class OrdenesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    public function collection()
    {
        return OrdenCompra::with(['proveedor', 'pagos.metodoPago'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Proveedor',
            'Fecha',
            'Tipo Pago',
            'Total',
            'Saldo Pendiente',
            'Estado',
            'Registrado por',
            'Pagos Realizados'
        ];
    }

    public function map($orden): array
    {
        // Construir la lista de pagos
        $pagosLista = '';
        foreach ($orden->pagos as $pago) {
            $pagosLista .= date('d/m/Y', strtotime($pago->fechapago)) . ': $' . number_format($pago->monto, 2) . ' (' . ($pago->metodoPago->nombre ?? 'N/A') . ')' . "\n";
        }
        
        if (empty($pagosLista)) {
            $pagosLista = 'Sin pagos';
        }

        return [
            $orden->id,
            $orden->proveedor->nombre ?? 'N/A',
            date('d/m/Y H:i', strtotime($orden->fecha)),
            ucfirst($orden->tipopago),
            '$' . number_format($orden->total, 2),
            $orden->saldopendiente > 0 ? '$' . number_format($orden->saldopendiente, 2) : 'Pagado',
            $orden->saldopendiente <= 0 ? 'Pagado' : 'Pendiente',
            $orden->registradopor,
            trim($pagosLista)
        ];
    }

    public function styles($sheet)
    {
        return [
            // Negritas y fondo gris para el encabezado
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E0E0E0']],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = $sheet->getHighestRow();
                $lastColumn = $sheet->getHighestColumn();

                // Autoajustar ancho de columnas
                foreach (range('A', $lastColumn) as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Bordes a toda la tabla
                $sheet->getStyle('A1:' . $lastColumn . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                    ],
                ]);

                // Columna de pagos con texto envuelto
                $sheet->getStyle('I1:I' . $lastRow)->getAlignment()->setWrapText(true);
                $sheet->getColumnDimension('I')->setWidth(40);
            },
        ];
    }
}