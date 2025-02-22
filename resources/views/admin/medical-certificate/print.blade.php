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
        }

        body,
        table {
            line-height: 0.8;
        }

        .header {
            width: 100%;
        }

        .header div {
            display: inline-block;
            width: 49%;
            vertical-align: top;
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
            text-align: center;
        }

        .sign {
            margin-top: 20px;
            text-align: right;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <h5 class="title">Phòng khám đa khoa Unicare</h5>
            <h5 class="title">TT Y Tế Thành Phố</h5>
            <small>Số điện thoại: 082.234.5959</small>
        </div>
        <div style="text-align: right">
            <h5>Mã số bệnh nhân</h5>
            <small>{{ $medical_certificate->patient->patient_code }}</small>
        </div>
    </div>

    <div style="text-align: center">
        <h2>GIẤY KHÁM BỆNH</h2>
    </div>

    <div class="info">
        <p><strong>Họ và tên:</strong> {{ $medical_certificate->patient->name }}
            <span style="font-style: italic"><strong>Tuổi:</strong>
                {{ \Carbon\Carbon::parse($medical_certificate->patient->dob)->age }}
            </span>
        </p>
        <p><strong>Địa chỉ:</strong> {{ $medical_certificate->patient->address }}</p>
        <p><strong>Số thẻ BHYT (nếu có):</strong> ......................................</p>
    </div>

    <p><strong>Triệu chứng:</strong> {{ $medical_certificate->symptom }}</p>
    <p><strong>Chẩn đoán:</strong> {!! $medical_certificate->diagnosis !!}</p>
    <p><strong>Kết luận:</strong> {!! $medical_certificate->conclude !!}</p>
    <p><strong>Ngày khám:</strong> {{ $medical_certificate->created_at->format('d/m/Y') }}</p>

    <div class="sign">
        <p>Ngày {{ now()->format('d') }} tháng {{ now()->format('m') }} năm {{ now()->format('Y') }}</p>
        <p>Bác sĩ khám bệnh</p>
        <p>(Ký, ghi rõ họ tên)</p>
        <br><br>
        <p><strong>BSCKI. {{ $medical_certificate->doctor->name }}</strong></p>
    </div>

    <div class="footer">
        <p> - Vui lòng mang theo giấy này khi tái khám.</p>
        <p> - Số điện thoại liên hệ:</p>
        <small style="font-style: italic"> Sử dụng mã số bệnh nhân để tra cứu thông tin khám, chữa bệnh trên website <a
                href="https://unicaremedic.ntu264.vpsttt.vn">Unicare</a> https://unicaremedic.ntu264.vpsttt.vn
        </small>
    </div>
</body>

</html>
