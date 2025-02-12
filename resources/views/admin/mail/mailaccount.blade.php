<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chào mừng đến với Unicare</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .email-header {
            background-color: #0073e6;
            color: #ffffff;
            padding: 15px;
            font-size: 20px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .email-body {
            padding: 20px;
        }

        .info {
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin: 10px 0;
            display: inline-block;
            background: #f0f0f0;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .email-footer {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .warning {
            color: red;
            font-size: 14px;
            font-weight: bold;
        }

        .note {
            color: #0073e6;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            Chào mừng bạn đến với hệ thống Unicare
        </div>
        <div class="email-body">
            <h3>Dưới đây là thông tin tài khoản của bạn</h3>
            <p class="info">Email: {{ $email }}</p>
            <p class="info">Password: {{ $pass }}</p>
            <p class="warning">Vui lòng đổi mật khẩu ngay sau khi đăng nhập lần đầu tiên.</p>
        </div>
        <div class="email-footer">
            <p>Nếu bạn không đăng ký tài khoản, vui lòng bỏ qua email này.</p>
            <p>&copy; 2025 Unicare. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</body>

</html>
