<?php

namespace App\Exports;

use App\Models\MedicineCategory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MedicineCategoryExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return MedicineCategory::select('id', 'name', 'description', 'status')
            ->get()
            ->map(function ($item) {
                return [
                    'ID' => $item->id,
                    'Tên loại' => $item->name,
                    'Mô tả' => strip_tags($item->description),
                    'Trạng thái' => $item->status == 1 ? 'Hiển thị' : 'Ẩn',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Tên loại',
            'Mô tả',
            'Trạng thái',
        ];
    }
}
