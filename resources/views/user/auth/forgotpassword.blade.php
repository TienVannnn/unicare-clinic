@extends('user.layout.main')
@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="row shadow-lg rounded bg-white overflow-hidden"
            style="max-width: 900px; width: 100%; box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px; margin: 40px">
            <div class="col-md-6  d-none d-md-flex justify-content-center align-items-center p-4"
                style="background: #ffe8cc;">
                <img src="{{ asset('user/assets/img/forgot.png') }}" alt="Login Illustration" class="img-fluid">
            </div>

            <div class="col-md-6 p-4 appointment">
                <h3 class="text-center text-uppercase mb-3">QUÊN MẬT KHẨU</h3>
                <p class="text-center text-small">Vui lòng nhập email đăng nhập của bạn,
                    chúng tôi sẽ gửi mã xác
                    nhận cho bạn qua email này.</p>
                <form action="{{ route('user.forgot') }}" method="POST" class="form">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" id="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" placeholder="Nhập email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <button type="submit" class="btn btn-primary w-100 mb-3">Gửi mã xác nhận</button>

                </form>
            </div>
        </div>
    </div>
@endsection
