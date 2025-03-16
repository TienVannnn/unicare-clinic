<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .header {
            background-color: #FF6600;
            color: #fff;
            padding: 15px;
            text-align: left;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .header-left {
            width: 100%;
        }

        .header-right {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .contact-info {
            width: 100%;
            text-align: right
        }

        .section-title {
            background-color: #FF6600;
            color: #fff;
            padding: 5px 10px;
            font-weight: bold;
        }

        .info-block {
            margin-bottom: 20px;
        }

        .info-block p {
            margin: 5px 0;
        }

        .footer {
            background-color: #FF6600;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        a {
            color: #FF6600;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="header-left">
                    <img src="https://unicaremedic.vn/images/logo.png" alt="CarePlus Logo" style="height: 50px">
                    <div>Công Ty Cổ Phần Y Tế Nha Trang UNI CARE</div>
                </div>
                <div class="header-right">
                    <div class="contact-info">
                        <p>📞 <strong>082.234.5959</strong> (Free Hotline)</p>
                        <p>📘 / <a href="https://www.facebook.com/NhaTrangUNICARE/">Unicare FB</a></p>
                        <p>🌐 <a href="https://unicaremedic.ntu264.vpsttt.vn/">Unicare Website</a></p>
                    </div>
                </div>
            </div>
        </div>
        {!! $data !!}
        <div class="info-block">
            <div class="section-title">HỆ THỐNG PHÒNG KHÁM UNICARE</div>
            <p><strong>Phòng khám Nha Trang:</strong> 59 Lê Thành Phương, Phường Phương Sài, TP. Nha Trang</p>
        </div>

        <div class="footer">
            <p>Unicare NhaTrang - Công Ty Cổ Phần Y Tế Nha Trang UNI CARE.</p>
        </div>
    </div>
</body>

</html>
