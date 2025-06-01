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
            line-height: 0.8;
        }

        .header {
            width: 100%;
            line-height: 1px;
        }

        .header div {
            display: inline-block;
            width: 49%;
            vertical-align: top;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: none;
            padding: 8px;
            text-align: left;
        }

        .footer {
            position: fixed;
            bottom: 0
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
            <h5>CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</h5>
            <small><strong>Độc lập - Tự do - Hạnh phúc</strong></small>
        </div>
    </div>
    <div style="text-align: center; line-height: 1px; margin-top: 30px">
        <h2>PHIẾU THU TẠM ỨNG</h2>
        <p>Số phiếu: {{ $medical_certificate->medical_certificate_code }}</p>
    </div>

    <table style="width: 100%; border: none; border-collapse: collapse">
        <tr>
            <td><strong>Họ và tên BN:</strong></td>
            <td>{{ $medical_certificate->patient->name }}</td>
            <td><strong>Mã số BN:</strong></td>
            <td>{{ $medical_certificate->patient->patient_code }}</td>
        </tr>
        <tr>
            <td><strong>Ngày sinh:</strong></td>
            <td colspan="3">{{ \Carbon\Carbon::parse($medical_certificate->patient->dob)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td><strong>Địa chỉ:</strong></td>
            <td colspan="3">{{ $medical_certificate->patient->address }}</td>
        </tr>
        <tr>
            <td><strong>Phòng khám:</strong></td>
            <td colspan="3">{{ $medical_certificate->clinic->name }}</td>
        </tr>
        <tr>
            <td><strong>Lý do thu:</strong></td>
            <td colspan="3">Tạm ứng tiền dịch vụ</td>
        </tr>
        <tr>
            <td><strong>Số tiền:</strong></td>
            <td colspan="3"><strong>{{ number_format($medical_certificate->total_price) }} đồng</strong></td>
        </tr>
        <tr>
            <td><strong>Viết bằng chữ:</strong></td>
            <td colspan="3">
                <strong>{{ App\Helpers\Helper::convertNumberToWord($medical_certificate->total_price) }}</strong>
            </td>
        </tr>
    </table>


    <table style="width: 100%; margin-top: 40px; text-align: center;">
        <tr>
            <td colspan="2" style="text-align: right; padding-bottom: 10px;">
                Ngày {{ now()->format('d') }} tháng {{ now()->format('m') }} năm {{ now()->format('Y') }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>Người nộp tiền</strong><br>
                (Ký và ghi rõ họ tên)<br><br><br><br>
                ....................................
            </td>
            <td style="text-align: right">
                <strong>Người thu tiền</strong><br>
                (Ký và ghi rõ họ tên)<br><br><br><br>
                <strong>TN. {{ $auth->name }}</strong>
            </td>
        </tr>
    </table>


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
