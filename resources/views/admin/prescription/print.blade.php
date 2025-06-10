<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đơn thuốc #{{ $prescription->prescription_code }}</title>
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
            <small>Số phiếu: {{ $prescription->medical_certificate->medical_certificate_code }}</small>
            <h5>Mã số bệnh nhân</h5>
            <small>{{ $prescription->medical_certificate->patient->patient_code }}</small>
        </div>
    </div>
    <div class="title-header">
        <h2>ĐƠN THUỐC</h2>
    </div>

    <table>
        <tr>
            <td style="border: none"><strong>Họ và tên:</strong></td>
            <td style="border: none">{{ $prescription->medical_certificate->patient->name }}</td>
            <td style="border: none"><strong>Ngày sinh:</strong></td>
            <td style="border: none">
                {{ \Carbon\Carbon::parse($prescription->medical_certificate->patient->dob)->format('d/m/Y') }}
            </td>
            <td style="border: none"><strong>BHYT:</strong></td>
            <td style="border: none">{{ $prescription->medical_certificate->insurance ? 'Có' : 'Không' }}</td>
        </tr>
        <tr>
            <td style="border: none"><strong>CCCD:</strong></td>
            <td style="border: none" colspan="5">{{ $prescription->medical_certificate->patient->cccd }}</td>
        </tr>
        <tr>
            <td style="border: none"><strong>Địa chỉ:</strong></td>
            <td style="border: none" colspan="5">{{ $prescription->medical_certificate->patient->address }}</td>
        </tr>
        <tr>
            <td style="border: none"><strong>Kết luận khám:</strong></td>
            <td style="border: none" colspan="5">{!! $prescription->medical_certificate->conclude !!}</td>
        </tr>
        <tr>
            <td style="border: none"><strong>Ngày cấp thuốc:</strong></td>
            <td style="border: none" colspan="5">{{ $prescription->created_at->format('d/m/Y') }}</td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Tên thuốc</th>
                <th>Liều lượng</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($prescription->medicines as $index => $medicine)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $medicine->name }}</strong></td>
                    <td>{{ $medicine->pivot->dosage }}</td>
                    <td>{{ $medicine->pivot->quantity }} {{ $medicine->base_unit }}</td>
                    <td>{{ number_format($medicine->pivot->price, 0, ',', '.') }} VND</td>
                    <td>{{ number_format($medicine->pivot->subtotal, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Lời dặn:</strong> {{ $prescription->note }}</p>
    <p><strong>Tổng tiền:</strong> {{ number_format($prescription->total_payment, 0, ',', '.') }} VNĐ</p>

    <div class="sign">
        <p>Ngày {{ now()->format('d') }} tháng {{ now()->format('m') }} năm {{ now()->format('Y') }}</p>
        <p>Bác sĩ kê đơn</p>
        <p>(Ký, ghi rõ họ tên)</p>
        <br><br><br>
        <p><strong>BSCKI. {{ $prescription->doctor->name }}</strong></p>
    </div>
    <div class="footer">
        <small>Khám lại xin mang theo đơn này.</small>
        <small style="font-style: italic"> Sử dụng mã số bệnh nhân để tra cứu thông tin khám, chữa bệnh trên website <a
                href="https://unicaremedic.ntu264.vpsttt.vn">Unicare</a> https://unicaremedic.ntu264.vpsttt.vn
        </small>
    </div>
</body>

</html>
