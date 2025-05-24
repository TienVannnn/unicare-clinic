<?php

namespace App\Exports;

use App\Models\Clinic;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClinicExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Clinic::with('department')->get();
    }

    public function headings(): array
    {
        return ['Mã PK', 'Tên phòng khám', 'Chuyên khoa', 'Trạng thái'];
    }

    public function map($clinic): array
    {
        return [
            $clinic->clinic_code,
            $clinic->name,
            optional($clinic->department)->name,
            $clinic->status ? 'Hoạt động' : 'Ngừng hoạt động',
        ];
    }
}
