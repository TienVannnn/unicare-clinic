<?php

namespace App\Exports;

use App\Models\MedicalCertificate;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class MedicalCertificateExport implements FromCollection, WithHeadings, WithEvents, WithCustomStartCell
{
    protected $filterMode;

    public function __construct($filterMode = null)
    {
        $this->filterMode = $filterMode;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function collection()
    {
        $query = MedicalCertificate::with(['patient', 'doctor', 'clinic', 'services']);

        switch ($this->filterMode) {
            case 'today':
                $query->whereDate('medical_time', Carbon::today());
                break;
            case 'this_week':
                $query->whereBetween('medical_time', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('medical_time', Carbon::now()->month)
                    ->whereYear('medical_time', Carbon::now()->year);
                break;
            case 'this_year':
                $query->whereYear('medical_time', Carbon::now()->year);
                break;
        }

        return $query->get()
            ->map(function ($item) {
                return [
                    'Mã giấy khám' => $item->medical_certificate_code,
                    'Tên bệnh nhân' => $item->patient->name ?? '',
                    'Giới tính' => optional($item->patient)->gender == 1 ? 'Nam' : 'Nữ',
                    'Ngày sinh' => optional($item->patient)->dob ?? '',
                    'Bác sĩ' => $item->doctor->name ?? '',
                    'Phòng khám' => $item->clinic->name ?? '',
                    'Dịch vụ khám' => $item->services->pluck('name')->implode(', '),
                    'Triệu chứng' => $item->symptom,
                    'Chẩn đoán' => strip_tags($item->diagnosis),
                    'Kết luận' => strip_tags($item->conclude),
                    'Thời gian khám' => $item->medical_time,
                    'Ngày xuất viện' => $item->discharge_date,
                    'Ngày tái khám' => $item->re_examination_date,
                    'Bảo hiểm' => $item->insurance ? 'Có' : 'Không',
                    'Tình trạng khám' => match ($item->medical_status) {
                        0 => 'Chờ khám',
                        1 => 'Đang khám',
                        default => 'Đã khám',
                    },
                    'Trạng thái thanh toán' => match ($item->payment_status) {
                        0 => 'Chưa thanh toán',
                        1 => 'Đã thanh toán',
                        2 => 'Đã tạm ứng',
                        default => '',
                    },
                ];
            });
    }


    public function headings(): array
    {
        return [
            'Mã giấy khám',
            'Tên bệnh nhân',
            'Giới tính',
            'Ngày sinh',
            'Bác sĩ',
            'Phòng khám',
            'Dịch vụ khám',
            'Triệu chứng',
            'Chẩn đoán',
            'Kết luận',
            'Thời gian khám',
            'Ngày xuất viện',
            'Ngày tái khám',
            'Bảo hiểm',
            'Tình trạng khám',
            'Trạng thái thanh toán',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $title = 'Danh sách giấy khám bệnh';

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
