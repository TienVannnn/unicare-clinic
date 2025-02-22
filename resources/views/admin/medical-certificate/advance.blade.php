<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Biên Nhận Thu Tạm Ứng Viện Phí</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            max-width: 800px;
            margin: auto;
            line-height: 1.2;
        }


        body {
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


        .info,
        .footer {
            margin-top: 20px;
        }

        .signatures {
            width: 100%;
        }

        .signature-box {
            display: inline-block;
            width: 49%;
            vertical-align: top;
        }

        .signature-box p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    @php
        $price = $medical_certificate->medical_service->price;
        if ($medical_certificate->insurance) {
            $price *= 0.8;
        }
    @endphp
    <div class="header">
        <div>
            <h5 class="title">Phòng khám đa khoa Unicare</h5>
            <h5 class="title">TT Y Tế Thành Phố</h5>
            <small>Số điện thoại: 082.234.5959</small>
        </div>
        <div style="text-align: right">
            <h5>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h5>
            <small><strong>Độc lập - Tự do - Hạnh phúc</strong></small>
        </div>
    </div>
    <div style="text-align: center">
        <h2>PHIẾU THU TẠM ỨNG</h2>
    </div>

    <div class="info">
        <p><strong>Họ và tên BN:</strong> {{ $medical_certificate->patient->name }} - <strong>Mã số BN:</strong>
            {{ $medical_certificate->patient->patient_code }}
        </p>
        <p><strong>Địa chỉ:</strong> {{ $medical_certificate->patient->address }}</p>
        <p><strong>Khoa:</strong> {{ $medical_certificate->clinic->name }}</p>
        <p><strong>Tạm ứng:</strong> {{ number_format($price, 0, ',', '.') }} VND</p>
    </div>

    <div class="signatures">
        <div class="signature-box">
            <p><strong>Người nộp tiền</strong></p>
            <p>(Ký và ghi rõ họ tên)</p>
            <br><br>
            <p>....................................</p>
        </div>
        <div class="signature-box" style="text-align: right">
            <p>Ngày {{ now()->format('d') }} tháng {{ now()->format('m') }} năm {{ now()->format('Y') }}</p>
            <p><strong>Người thu tiền</strong></p>
            <p>(Ký và ghi rõ họ tên)</p>
            <br><br>
            <p><strong>TN. {{ $auth->name }}</strong></p>
        </div>
    </div>

    <div class="footer">
        <p><strong>Lưu ý:</strong></p>
        <ul>
            <li>Bệnh nhân giữ biên nhận này và xuất trình khi làm thủ tục thanh toán ra viện.</li>
            <li>Trong lúc nằm viện, bệnh viện không có trách nhiệm hoàn trả lại tiền tạm ứng.</li>
            <li>Trẻ em hoặc bệnh nhân cần có người giám hộ khi đóng tiền.</li>
        </ul>
    </div>
</body>

</html>
