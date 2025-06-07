@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('user.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa người dùng</span>
                    <span class="text-primary">"{{ $user->name }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên người dùng <span
                                    class="text-danger">*</span></label>
                            <input type="text" value="{{ $user->name }}"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                aria-describedby="emailHelp" name="name">
                            @error('name')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $user->email }}"
                                class="form-control @error('email') is-invalid @enderror" id="email"
                                aria-describedby="emailHelp" name="email">
                            @error('email')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Số điện thoại </label>
                            <input type="number" value="{{ $user->phone }}" placeholder="Nhập số điện thoại"
                                class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone">
                            @error('phone')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="text" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" placeholder="Nhập mật khẩu">
                            @error('password')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="confirm" class="form-label">Xác nhận mật khẩu</label>
                            <input type="text" class="form-control" id="confirm" name="password_confirmation"
                                placeholder="Nhập xác nhận mật khẩu">
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="verify_email" class="form-label">Trạng thái <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="verify_email" name="verify_email">
                                <option value="1" {{ $user->verify_email == 1 ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ $user->verify_email == 0 ? 'selected' : '' }}>Khóa</option>
                            </select>
                            @error('verify_email')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" value="{{ $user->address }}"
                                class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                placeholder="Nhập địa chỉ">
                            @error('address')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="avatar" class="form-label">Ảnh đại diện</label>
                            <input type="file" class="form-control" id="avatar" name="avatar">
                            @error('avatar')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                            @if ($user->avatar)
                                <img src="{{ $user->avatar }}" alt="" width="100">
                            @endif
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/select2.css') }}">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('admin-assets/js/custom/admin.js') }}"></script>
@endsection
