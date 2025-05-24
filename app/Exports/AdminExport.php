<?php

namespace App\Exports;

use App\Models\Admin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Admin::with(['clinic', 'department', 'roles'])->get();
    }

    public function headings(): array
    {
        return [
            'Tên nhân viên',
            'Email',
            'Số điện thoại',
            'Giới tính',
            'Phòng khám',
            'Chuyên khoa',
            'Chức vụ',
            'Trạng thái'
        ];
    }

    public function map($admin): array
    {
        return [
            $admin->name,
            $admin->email,
            $admin->phone,
            $admin->gender == 1 ? 'Nam' : 'Nữ',
            optional($admin->clinic)->name,
            optional($admin->department)->name,
            $admin->getRoleNames()->implode(', '),
            $admin->status ? 'Hoạt động' : 'Ngừng hoạt động'
        ];
    }
}
