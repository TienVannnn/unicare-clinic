<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận mã OTP - Unicare</title>
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

        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #d9534f;
            margin: 10px 0;
            display: inline-block;
            background: #f8d7da;
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

        .btn {
            display: inline-block;
            padding: 10px 20px;
            color: white;
            background: #28a745;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
        }

        .btn:hover {
            background: #218838;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="email-header">
            Chào mừng bạn quay lại với Unicare
        </div>
        <div class="email-body">
            <h3>Dưới đây là thông tin mã xác nhận</h3>
            <p class="otp-code">{{ $token }}</p>
            <p class="warning">Lưu ý: Mã xác nhận chỉ có hiệu lực trong 1 giờ</p>
            <p class="note">Vui lòng sử dụng mã xác nhận để đổi mật khẩu trước khi hết hiệu lực!</p>
        </div>
        <div class="email-footer">
            <p>Nếu bạn không yêu cầu đổi mật khẩu, vui lòng bỏ qua email này.</p>
            <p>&copy; 2025 Unicare. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</body>

</html>
