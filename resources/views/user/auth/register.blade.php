@extends('user.layout.main')
@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row shadow-lg rounded bg-white overflow-hidden"
            style="max-width: 900px; width: 100%; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; margin: 40px">
            <div class="col-md-6  d-none d-md-flex justify-content-center align-items-center p-4"
                style="background: #ffe8cc;">
                <img src="{{ asset('user/assets/img/signup.png') }}" alt="Login Illustration" class="img-fluid">
            </div>

            <div class="col-md-6 p-4 appointment">
                <h3 class="text-center text-uppercase mb-3">ĐĂNG KÝ</h3>
                <form action="{{ route('user.register') }}" method="POST" class="form">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="name">Họ tên <span class="text-danger">*</span></label>
                        <input type="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" placeholder="Nhập họ tên">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
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

                    <div class="mb-3">
                        <label class="form-label" for="confirm">Xác nhận mật khẩu <span
                                class="text-danger">*</span></label>
                        <input type="password" id="confirm" placeholder="Xác nhận mật khẩu" class="form-control"
                            name="password_confirmation">
                    </div>

                    <button type="submit" class="btn w-100 mb-3">Đăng ký</button>

                    <p class="text-center">Bạn đã có tài khoản?
                        <a class="text-danger" href="{{ route('user.login') }}">Đăng nhập</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
