<?php

namespace App\Exports;

use App\Models\Medicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MedicineExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Medicine::with('medicineCategories')->get()->map(function ($item) {
            return [
                'Mã thuốc' => $item->medicine_code,
                'Tên thuốc' => $item->name,
                'Thành phần' => $item->ingredient,
                'Hàm lượng' => $item->dosage_strength,
                'Đơn vị gốc' => $item->unit,
                'Quy cách' => $item->packaging,
                'Đơn vị cơ sở' => $item->base_unit,
                'Số lượng/đơn vị cs' => $item->quantity_per_unit,
                'Giá bán' => number_format($item->sale_price),
                'Loại thuốc' => $item->medicineCategories->pluck('name')->implode(', '),
                'Trạng thái' => $item->status == 1 ? 'Hiển thị' : 'Ẩn',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Mã thuốc',
            'Tên thuốc',
            'Thành phần',
            'Hàm lượng',
            'Đơn vị gốc',
            'Quy cách',
            'Đơn vị cơ sở',
            'Số lượng/đơn vị cs',
            'Giá bán',
            'Loại thuốc',
            'Trạng thái',
        ];
    }
}
