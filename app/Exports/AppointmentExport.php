<?php

namespace App\Exports;

use App\Models\Appointment;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class AppointmentExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    protected $filterMode;

    public function __construct($filterMode = null)
    {
        $this->filterMode = $filterMode;
    }

    public function collection()
    {
        $query = Appointment::with(['doctor', 'department']);
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

        return $query->get()->map(function ($appointment) {
            return [
                'Người gửi'      => $appointment->name,
                'Email'          => $appointment->email,
                'Số điện thoại'  => $appointment->phone,
                'Chuyên khoa'    => optional($appointment->department)->name,
                'Bác sĩ'         => optional($appointment->doctor)->name,
                'Trạng thái'     => match ($appointment->status) {
                    1 => 'Đã xác nhận',
                    0 => 'Chờ xác nhận',
                    -1 => 'Đã hủy',
                },
                'Thời gian gửi'  => $appointment->created_at->format('H:i d/m/Y'),
                'Thời gian khám' => Carbon::parse($appointment->appointment_date . ' ' . $appointment->start_time)->format('H:i d/m/Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Người gửi',
            'Email',
            'Số điện thoại',
            'Chuyên khoa',
            'Bác sĩ',
            'Trạng thái',
            'Thời gian gửi',
            'Thời gian khám',
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
                $title = 'Danh sách  lịch hẹn khám';
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
