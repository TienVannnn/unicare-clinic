<?php

namespace App\Exports;

use App\Models\Department;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DepartmentExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Department::select('id', 'name', 'slug', 'description', 'status')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Tên chuyên khoa', 'Slug', 'Mô tả', 'Trạng thái'];
    }

    public function map($department): array
    {
        return [
            $department->id,
            $department->name,
            $department->slug,
            $department->description,
            $department->status == 1 ? 'Hoạt động' : 'Ngừng hoạt động',
        ];
    }
}
