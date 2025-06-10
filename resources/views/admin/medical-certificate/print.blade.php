<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giấy Khám Bệnh #{{ $medical_certificate->medical_certificate_code }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            max-width: 800px;
            margin: auto;
            line-height: 0.8;
        }

        .header {
            width: 100%;
        }

        .header div {
            display: inline-block;
            width: 49%;
        }

        .title-header {
            text-align: center;
            line-height: 1px;
            margin-top: 30px;
        }

        .title {
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        .sign {
            margin-top: 20px;
            text-align: right;
            font-style: italic;
        }

        .footer {
            position: fixed;
            bottom: 0
        }
    </style>
</head>

<body>
    <div class="header">
        <div style="line-height: 1px">
            <h5 class="title">Phòng khám đa khoa Unicare</h5>
            <h5 class="title">TT Y Tế Thành Phố</h5>
            <small>Số điện thoại: 082.234.5959</small>
        </div>
        <div style="text-align: right; line-height: 1px">
            <small>Số phiếu: {{ $medical_certificate->medical_certificate_code }}</small>
            <h5>Mã số bệnh nhân</h5>
            <small>{{ $medical_certificate->patient->patient_code }}</small>
        </div>
    </div>

    <div class="title-header">
        <h2>GIẤY KHÁM BỆNH</h2>
        <p>Ngày {{ now()->format('d') }} tháng {{ now()->format('m') }} năm {{ now()->format('Y') }}</p>
    </div>

    <table>
        <tr>
            <td style="border: none"><strong>Họ và tên:</strong></td>
            <td style="border: none">{{ $medical_certificate->patient->name }}</td>
            <td style="border: none"><strong>Ngày sinh:</strong></td>
            <td style="border: none">{{ \Carbon\Carbon::parse($medical_certificate->patient->dob)->format('d/m/Y') }}
            </td>
            <td style="border: none"><strong>BHYT:</strong></td>
            <td style="border: none">{{ $medical_certificate->insurance ? 'Có' : 'Không' }}</td>
        </tr>
        <tr>
            <td style="border: none"><strong>Địa chỉ:</strong></td>
            <td style="border: none" colspan="5">{{ $medical_certificate->patient->address }}</td>
        </tr>
        <tr>
            <td style="border: none"><strong>Bác sĩ điều trị:</strong></td>
            <td style="border: none" colspan="5">{{ $medical_certificate->doctor->name ?? 'Chưa khám' }}</td>
        </tr>
        <tr>
            <td style="border: none"><strong>Triệu chứng:</strong></td>
            <td style="border: none" colspan="5">{{ $medical_certificate->symptom }}</td>
        </tr>
        <tr>
            <td style="border: none"><strong>Chẩn đoán:</strong></td>
            <td style="border: none" colspan="5">{!! $medical_certificate->diagnosis !!}</td>
        </tr>
        <tr>
            <td style="border: none"><strong>Kết luận:</strong></td>
            <td style="border: none" colspan="5">{!! $medical_certificate->conclude !!}</td>
        </tr>
        <tr>
            <td style="border: none"><strong>Ngày khám:</strong></td>
            <td style="border: none" colspan="5">{{ $medical_certificate->created_at->format('d/m/Y') }}</td>
        </tr>
    </table>

    <div>
        @if ($medical_certificate->services->count())
            <h4>Dịch vụ khám</h4>
            <table>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Dịch vụ</th>
                        <th>Phòng khám</th>
                        <th>Bác sĩ</th>
                        <th>Giá tiền (đ)</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medical_certificate->services as $index => $service)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $service->name }}</td>
                            <td>
                                {{ optional(\App\Models\Clinic::find($service->pivot->clinic_id))->name }}
                                -
                                {{ optional(\App\Models\Clinic::find($service->pivot->clinic_id))->clinic_code }}
                            </td>
                            <td>{{ optional(\App\Models\Admin::find($service->pivot->doctor_id))->name ?? 'N/A' }}</td>
                            <td>
                                {{ number_format($medical_certificate->insurance ? $service->insurance_price : $service->price) }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($service->pivot->medical_time)->format('H:i d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <p><strong>Tổng tiền: </strong>{{ number_format($medical_certificate->total_price) }} đ |
            <span><strong>Trạng thái thanh toán:</strong> </span>
            @if ($medical_certificate->payment_status == 0)
                Chưa thanh toán
            @elseif ($medical_certificate->payment_status == 1)
                Đã thanh toán
            @else
                Đã tạm ứng
            @endif
        </p>
    </div>

    <table style="width: 100%; margin-top: 40px; text-align: center; border: none; border-collapse: collapse;">
        <tr>
            <td style="border: none; text-align: center"><strong>Bệnh nhân</strong><br>(Ký, ghi rõ họ tên)</td>
            <td style="border: none; text-align: center"><strong>Kế toán</strong><br>(Ký, ghi rõ họ tên)</td>
            <td style="border: none; text-align: center"><strong>Bác sĩ</strong><br>(Ký, ghi rõ họ tên)</td>
        </tr>
    </table>


    <div class="footer">
        <p> - Vui lòng mang theo giấy này khi tái khám.</p>
        <p> - Số điện thoại liên hệ:</p>
        <small style="font-style: italic"> Sử dụng mã số bệnh nhân để tra cứu thông tin khám, chữa bệnh trên website <a
                href="https://unicaremedic.ntu264.vpsttt.vn">Unicare</a> https://unicaremedic.ntu264.vpsttt.vn
        </small>
    </div>
</body>

</html>
