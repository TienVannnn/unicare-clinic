@extends('user.layout.main')
@section('content')
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="container py-5 col-md-6">
            <div class="text-center alert alert-{{ $status == 'error' ? 'danger' : 'info' }}">
                <h4 class="alert-heading">Xác thực thất bại
                </h4>
                <p>{{ $message }}</p>
                <hr>
                <div>
                    @if (!empty($expired) && $expired)
                        <form action="{{ route('user.resend-email') }}" method="POST">
                            @csrf
                            <input type="hidden" name="email" value="{{ $email }}">
                            <button type="submit" class="btn btn-danger">Gửi lại email xác thực</button>
                        </form>
                    @endif
                    <a href="{{ route('user.login') }}" class="btnn-outline">Đăng nhập</a>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <style>
        .btnn-outline {
            color: #f05a28;
            padding: 13px 25px;
            font-size: 14px;
            text-transform: capitalize;
            font-weight: bold;
            background: transparent;
            position: relative;
            box-shadow: none;
            display: inline-block;
        }
    </style>
@endsection
