<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác thực email đăng ký - Unicare</title>
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

        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: white !important;
            background: #f05a28;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
        }

        .btn:hover {
            background: #f0521e;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            Chào mừng bạn đến với Unicare
        </div>
        <div class="email-body">
            <h3>Xin chào {{ $name }},</h3>
            <p>Cảm ơn bạn đã đăng ký tài khoản tại <strong>Unicare</strong>!</p>
            <p>Email đăng ký: <strong>{{ $email }}</strong></p>
            <p>Vui lòng nhấn vào nút bên dưới để xác thực email:</p>
            <a href="http://127.0.0.1:8000/auth/verify-email?token={{ $token }}" class="btn"
                style="color: #ffffff!important">Xác thực email</a>
            <p class="warning">Lưu ý: Link xác thực chỉ có hiệu lực trong 24 giờ.</p>
        </div>
        <div class="email-footer">
            <p>Nếu bạn không yêu cầu đăng ký tài khoản, vui lòng bỏ qua email này.</p>
            <p>&copy; 2025 Unicare. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</body>

</html>
