<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 - Không tìm thấy trang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            text-align: center;
        }

        .error-container {
            max-width: 500px;
        }

        .error-container img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="error-container">
        <img src="{{ asset('uploads/404.jpg') }}" alt="404 Not Found">
        <h1 class="mt-3">Oops! Trang không tồn tại</h1>
        <p class="text-muted">Trang bạn đang tìm kiếm có thể đã bị xóa hoặc không tồn tại.</p>
        <a href="javascript:window.history.back();" class="btn btn-primary">Quay lại</a>
    </div>
</body>

</html>
