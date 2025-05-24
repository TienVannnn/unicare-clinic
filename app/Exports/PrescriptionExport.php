<?php

namespace App\Exports;

use App\Models\Prescription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PrescriptionExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $prescriptions = Prescription::with(['doctor', 'medical_certificate.patient', 'medicines'])->get();

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
}
