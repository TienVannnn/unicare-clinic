<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\{
    FromArray,
    WithHeadings,
    WithEvents
};
use Maatwebsite\Excel\Events\AfterSheet;

class DashboardExport implements FromArray, WithHeadings, WithEvents
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return $this->data;
    }

    public function headings(): array
    {
        return ['Tháng', 'Số lượng bệnh nhân', 'Doanh thu'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->insertNewRowBefore(1, 1);
                $sheet->setCellValue('A1', 'Thống kê bệnh và doanh thu năm 2025');
                $sheet->mergeCells('A1:C1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => 'center'],
                ]);
            },
        ];
    }
}
