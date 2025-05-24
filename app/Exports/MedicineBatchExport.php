<?php

namespace App\Exports;

use App\Models\MedicineBatch;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MedicineBatchExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return MedicineBatch::with('medicine')->get()->map(function ($item) {
            return [
                'Mã lô' => $item->batch_number,
                'Tên thuốc' => optional($item->medicine)->name,
                'Hãng sản xuất' => $item->manufacturer,
                'Nơi sản xuất' => $item->production_address,
                'Ngày sản xuất' => optional($item->manufacture_date)->format('d/m/Y'),
                'Hạn sử dụng' => optional($item->expiry_date)->format('d/m/Y'),
                'Số lượng nhập' => $item->quantity_received,
                'Giá nhập' => number_format($item->purchase_price, 0, ',', '.'),
                'Tổng số lượng' => $item->total_quantity,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Mã lô',
            'Tên thuốc',
            'Hãng sản xuất',
            'Nơi sản xuất',
            'Ngày sản xuất',
            'Hạn sử dụng',
            'Số lượng nhập',
            'Giá nhập',
            'Tổng số lượng',
        ];
    }
}
