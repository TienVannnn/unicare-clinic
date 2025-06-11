<?php

namespace App\Exports;

use App\Models\MedicalCertificate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MedicalCertificateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return MedicalCertificate::with(['patient', 'doctor', 'clinic', 'services'])
            ->get()
            ->map(function ($item) {
                return [
                    'Mã giấy khám' => $item->medical_certificate_code,
                    'Tên bệnh nhân' => $item->patient->name ?? '',
                    'Giới tính' => optional($item->patient)->gender == 1 ? 'Nam' : 'Nữ',
                    'Ngày sinh' => $item->patient->dob ?? '',
                    'Bác sĩ' => $item->doctor->name ?? '',
                    'Phòng khám' => $item->clinic->name ?? '',
                    'Dịch vụ khám' => $item->services->pluck('name')->implode(', '),
                    'Triệu chứng' => $item->symptom,
                    'Chuẩn đoán' => html_entity_decode(strip_tags($item->diagnosis), ENT_QUOTES, 'UTF-8'),
                    'Kết luận' => html_entity_decode(strip_tags($item->conclude), ENT_QUOTES, 'UTF-8'),
                    'Thời gian khám' => $item->medical_time,
                    'Ngày xuất viện' => $item->discharge_date,
                    'Ngày tái khám' => $item->re_examination_date,
                    'Bảo hiểm' => $item->insurance ? 'Có' : 'Không',
                    'Tình trạng khám' => $item->medical_status == 0
                        ? 'Chờ khám'
                        : ($item->medical_status == 1
                            ? 'Đang khám'
                            : 'Đã khám'),
                    'Trạng thái thanh toán' => $item->payment_status == 0 ? 'Chưa thanh toán' : ($item->payment_status == 1 ? 'Đã thanh toán' : 'Đã tạm ứng'),
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
}
