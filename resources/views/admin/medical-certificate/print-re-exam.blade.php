<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Giấy Hẹn Khám Lại #{{ $medical_certificate->medical_certificate_code }}</title>
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
            border: none;
            padding: 8px;
            text-align: left;
        }

        .sign {
            margin-top: 20px;
            text-align: right;
            font-style: italic;
        }

        .footer {
            margin-top: 30px;
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
        <h2>GIẤY HẸN KHÁM LẠI</h2>
        <p>Ngày {{ now()->format('d') }} tháng {{ now()->format('m') }} năm {{ now()->format('Y') }}</p>
    </div>

    <table>
        <tr>
            <td><strong>Họ và tên:</strong></td>
            <td>{{ $medical_certificate->patient->name }}</td>
            <td><strong>Ngày sinh:</strong></td>
            <td>{{ \Carbon\Carbon::parse($medical_certificate->patient->dob)->format('d/m/Y') }}
            </td>
            <td><strong>Giới tính:</strong></td>
            <td>{{ $medical_certificate->patient->gender == 1 ? 'Nam' : 'Nữ' }}</td>
        </tr>
        <tr>
            <td><strong>Địa chỉ:</strong></td>
            <td colspan="5">{{ $medical_certificate->patient->address }}</td>
        </tr>
        <tr>
            <td><strong>Triệu chứng:</strong></td>
            <td colspan="5">{{ $medical_certificate->symptom }}</td>
        </tr>
        <tr>
            <td><strong>Chẩn đoán:</strong></td>
            <td colspan="5">{!! $medical_certificate->diagnosis !!}</td>
        </tr>
        <tr>
            <td><strong>Kết luận:</strong></td>
            <td colspan="5">{!! $medical_certificate->conclude !!}</td>
        </tr>
        <tr>
            <td><strong>Ngày khám:</strong></td>
            <td colspan="5">{{ $medical_certificate->created_at->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Ngày ra viện:</strong></td>
            <td colspan="5">
                @if ($medical_certificate->discharge_date)
                    {{ $medical_certificate->discharge_date->format('d/m/Y') }}
                @endif
            </td>
        </tr>
    </table>

    <div class="footer">
        <p>Hẹn khám lại vào ngày @if ($medical_certificate->re_examination_date)
                <strong>{{ \Carbon\Carbon::parse($medical_certificate->re_examination_date)->format('d/m/Y') }}</strong>
            @endif, hoặc bất kỳ thời
            gian nào trước ngày được hẹn khám lại nếu có dấu hiệu (triệu chứng) bất thường.</p>
        <p>Giấy hẹn khám chỉ có giá trị sử dụng 01 (một) lần trong thời hạn 10 ngày làm việc, kể từ ngày được hẹn khám
            lại.</p>
    </div>

    <table style="width: 100%; margin-top: 40px; text-align: center;">
        <tr>
            <td colspan="2" style="text-align: right; padding-bottom: 10px;">
                Ngày {{ now()->format('d') }} tháng {{ now()->format('m') }} năm {{ now()->format('Y') }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>Bệnh nhân</strong><br>
                (Ký và ghi rõ họ tên)<br><br><br><br>
                ....................................
            </td>
            <td style="text-align: right">
                <strong>Bác sĩ khám bệnh</strong><br>
                (Ký và ghi rõ họ tên)<br><br><br><br>
                <strong>Bs. {{ $medical_certificate->doctor->name }}</strong>
            </td>
        </tr>
    </table>
</body>

</html>
