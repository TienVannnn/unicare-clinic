<?php

namespace App\Exports;

use App\Models\Prescription;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PrescriptionExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    protected $filterMode;

    public function __construct($filterMode = null)
    {
        $this->filterMode = $filterMode;
    }

    public function collection()
    {
        $query = Prescription::with(['doctor', 'medical_certificate.patient', 'medicines']);
        switch ($this->filterMode) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
                break;
            case 'this_year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }

        $prescriptions = $query->get();

        return $prescriptions->map(function ($item) {
            $medicineList = $item->medicines->map(function ($med) {
                return $med->name . ' (' . $med->pivot->quantity . ' x ' . $med->pivot->dosage . ')';
            })->implode(', ');

            return [
                'Mã đơn thuốc' => $item->prescription_code,
                'Bệnh nhân'    => optional($item->medical_certificate->patient)->name,
                'Bác sĩ'       => optional($item->doctor)->name,
                'Danh sách thuốc' => $medicineList,
                'Ghi chú'      => $item->note,
                'Tổng tiền'    => number_format($item->total_payment),
                'Trạng thái'   => $item->status == 1 ? 'Đã thanh toán' : 'Chưa thanh toán',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Mã đơn thuốc',
            'Bệnh nhân',
            'Bác sĩ',
            'Danh sách thuốc',
            'Ghi chú',
            'Tổng tiền',
            'Trạng thái',
        ];
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $title = 'Danh sách đơn thuốc';
                $now = Carbon::now();
                switch ($this->filterMode) {
                    case 'today':
                        $title .= ' ngày ' . $now->format('d/m/Y');
                        break;
                    case 'this_week':
                        $title .= ' - Tuần ' . $now->weekOfYear . ' năm ' . $now->year;
                        break;
                    case 'this_month':
                        $title .= ' tháng ' . $now->month . ' năm ' . $now->year;
                        break;
                    case 'this_year':
                        $title .= ' năm ' . $now->year;
                        break;
                }
                $colCount = count($this->headings());
                $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);
                $sheet->mergeCells("A1:{$lastCol}1");
                $sheet->setCellValue('A1', $title);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
