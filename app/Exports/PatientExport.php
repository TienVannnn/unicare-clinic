<?php

namespace App\Exports;

use App\Models\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PatientExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $patients = Patient::select('patient_code', 'name', 'dob', 'gender', 'address', 'phone')->get();
        $patients->transform(function ($item) {
            $item->gender = $item->gender == 1 ? 'Nam' : 'Nữ';
            return $item;
        });

        return $patients;
    }
    public function headings(): array
    {
        return ['Mã BN', 'Tên', 'Ngày sinh', 'Giới tính', 'Địa chỉ', 'SĐT'];
    }
}
