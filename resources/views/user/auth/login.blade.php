@extends('user.layout.main')
@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row shadow-lg rounded bg-white overflow-hidden"
            style="max-width: 900px; width: 100%; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; margin: 40px">
            <div class="col-md-6  d-none d-md-flex justify-content-center align-items-center p-4"
                style="background: #ffe8cc;">
                <img src="{{ asset('user/assets/img/login.png') }}" alt="Login Illustration" class="img-fluid">
            </div>

            <div class="col-md-6 p-4 appointment">
                <h3 class="text-center text-uppercase mb-3">ĐĂNG NHẬP</h3>
                <form action="{{ route('user.login') }}" method="POST" class="form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Nhập email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" id="password" placeholder="Nhập mật khẩu"
                            class="form-control @error('password') is-invalid @enderror" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input" name="remember" type="checkbox" id="remember" checked
                                style="width: auto!important">
                            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                        <a href="{{ route('user.forgot') }}" class="text-decoration-none">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="btn w-100 mb-3">Đăng nhập</button>

                    <p class="text-center">Bạn chưa có tài khoản?
                        <a class="text-danger" href="{{ route('user.register') }}">Đăng ký</a>
                    </p>
                    <div class="text-center">
                        <p>Hoặc đăng nhập với:</p>
                        <a title="Đăng nhập với Google" href="{{ route('user.google-login') }}" class="btn-social mx-1">
                            <img class="img-social" src="{{ asset('user/assets/img/gg.png') }}" alt="">
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <style>
        .img-social {
            width: 30px
        }

        .btn-social {
            background-color: #ffffff;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            color: white;
            border-radius: 5px;
            padding: 10px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            transition: all 0.3s ease;
            border: 1px solid #ddd;
        }

        .btn-social:hover {
            background-color: #ffffff;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 10px 20px;
            transform: translateY(-3px);
            color: #007bff;
        }
    </style>
@endsection
