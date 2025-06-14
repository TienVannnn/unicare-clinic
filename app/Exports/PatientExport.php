<?php

namespace App\Exports;

use App\Models\Patient;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class PatientExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    protected $filterMode;

    public function __construct($filterMode = null)
    {
        $this->filterMode = $filterMode;
    }

    public function collection()
    {
        $query = Patient::query();

        switch ($this->filterMode) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;
            case 'this_week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year);
                break;
            case 'this_year':
                $query->whereYear('created_at', Carbon::now()->year);
                break;
        }

        return $query->select('patient_code', 'name', 'dob', 'gender', 'address', 'phone', 'cccd')
            ->get()
            ->map(function ($item) {
                $item->gender = $item->gender == 1 ? 'Nam' : 'Nữ';
                return $item;
            });
    }
    public function headings(): array
    {
        return ['Mã BN', 'Tên', 'Ngày sinh', 'Giới tính', 'Địa chỉ', 'SĐT', 'CCCD'];
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
                $title = 'Danh sách bệnh nhân';
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
                $sheet->mergeCells('A1:G1');
                $sheet->setCellValue('A1', $title);
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
            },
        ];
    }
}
