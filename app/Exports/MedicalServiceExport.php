<?php

namespace App\Exports;

use App\Models\MedicalService;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MedicalServiceExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return MedicalService::all();
    }

    public function headings(): array
    {
        return ['Mã DV', 'Tên dịch vụ', 'Mô tả', 'Giá', 'Giá BHYT', 'Trạng thái'];
    }

    public function map($service): array
    {
        return [
            $service->medical_service_code,
            $service->name,
            strip_tags(html_entity_decode($service->description)),
            number_format($service->price, 0, ',', '.') . ' đ',
            number_format($service->insurance_price, 0, ',', '.') . ' đ',
            $service->status ? 'Hoạt động' : 'Ngừng hoạt động',
        ];
    }
}
