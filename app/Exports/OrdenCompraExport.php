<?php

namespace App\Exports;

use App\Models\OrdenCompra;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrdenCompraExport implements FromArray, WithHeadings, WithStyles
{
    protected $orden;

    public function __construct($orden)
    {
        $this->orden = $orden;
    }

    public function array(): array
    {
        $data = [];

        // Encabezado principal
        $data[] = ['=== ORDEN DE COMPRA N° ' . $this->orden->id . ' ==='];
        $data[] = [];
        $data[] = ['DATOS DE LA ORDEN'];
        $data[] = ['ID', $this->orden->id];
        $data[] = ['Proveedor', $this->orden->proveedor->nombre ?? 'N/A'];
        $data[] = ['Fecha', date('d/m/Y H:i', strtotime($this->orden->fecha))];
        $data[] = ['Tipo de Pago', ucfirst($this->orden->tipopago)];
        $data[] = ['Total', '$' . number_format($this->orden->total, 2)];
        $data[] = ['Saldo Pendiente', $this->orden->saldopendiente > 0 ? '$' . number_format($this->orden->saldopendiente, 2) : 'Pagado'];
        $data[] = [];
        $data[] = ['=== DETALLE DE PRODUCTOS ==='];
        $data[] = ['Producto', 'Cantidad', 'Precio Unitario', 'Subtotal'];

        foreach ($this->orden->detalles as $detalle) {
            $data[] = [
                $detalle->producto->nombre,
                $detalle->cantidad . ' uds',
                '$' . number_format($detalle->producto->preciocompra, 2),
                '$' . number_format($detalle->subtotal, 2),
            ];
        }

        $data[] = [];
        $data[] = ['TOTAL GENERAL', '', '', '$' . number_format($this->orden->total, 2)];

        // REGISTRO DE PAGOS
        if ($this->orden->pagos->count() > 0) {
            $data[] = [];
            $data[] = ['=== REGISTRO DE PAGOS ==='];
            $data[] = ['Fecha', 'Monto', 'Método de Pago', 'Registrado por'];
            
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
        }

        return $data;
    }

    public function headings(): array
    {
        return [];
    }

    public function styles($sheet)
    {
        // Estilos para encabezados
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A12')->getFont()->setBold(true);
        
        // Estilo para la fila de total general
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle('A' . $lastRow)->getFont()->setBold(true);
        
        // Bordes para la tabla de productos
        $productosStart = 14;
        $productosEnd = $productosStart + count($this->orden->detalles) - 1;
        if ($productosEnd >= $productosStart) {
            $sheet->getStyle('A' . $productosStart . ':D' . $productosEnd)->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                ],
            ]);
        }
        
        // Si hay pagos, estilos para esa tabla
        if ($this->orden->pagos->count() > 0) {
            $pagosStart = $productosEnd + 5;
            $pagosEnd = $pagosStart + count($this->orden->pagos);
            $sheet->getStyle('A' . $pagosStart . ':D' . $pagosEnd)->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                ],
            ]);
        }
    }
}