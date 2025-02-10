@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/profile.css') }}">
@endsection

@section('content')
    <div class="container">
        <div class="row m-2">
            <div class="d-flex justify-content-between align-items-center my-2">
                <p class="text-uppercase fw-bold">Thông tin cá nhân</p>
                <a class="btn btn-secondary" href="{{ route('admin.edit-account') }}"><i class="icon-pencil me-2"></i>Cài đặt
                    tài khoản</a>
            </div>
            <div class="col-md-4">
                <div class="card profile-card shadow-sm">
                    <div class="profile-header">
                        <div class="position-relative d-inline-block">
                            <!-- Avatar -->
                            <img id="user-avatar"
                                src="{{ Auth::guard('admin')->user()->avatar ? Auth::guard('admin')->user()->avatar : '/uploads/avatars/avatar.png' }}"
                                alt="User Avatar" class="rounded-circle img-fluid"
                                style="width: 50px; height: 50px; object-fit: cover;">
                            <!-- Camera Icon -->
                            <div class="camera-icon">
                                <i class="fa fa-camera text-primary" style="cursor: pointer;" data-bs-toggle="tooltip"
                                    title="Thay đổi ảnh" onclick="document.getElementById('avatar-input').click();"></i>
                            </div>
                        </div>
                        <form id="avatar-form" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="avatar" id="avatar-input" class="d-none" accept="image/*">
                        </form>
                        <div>
                            <h5 class="mb-1">Chào mừng trở lại!</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-6 text-center">
                                <p class="fw-bold mb-0">{{ auth()->guard('admin')->user()->name }}</p>
                                <span class="badge badge-primary">Admin</span>
                            </div>
                            <div class="col-md-6 col-6 text-center">
                                <p class="fw-bold mb-0">Giới tính</p>
                                <p class="text-muted">{{ auth()->guard('admin')->user()->gender == 1 ? 'Nam' : 'Nữ' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <p class="text-uppercase fw-bold">Thông tin cá nhân</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <strong>Họ và tên: </strong>
                                    </div>
                                    <div class="col-md-8 col-8">
                                        {{ Auth::guard('admin')->user()->name }}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <strong>Email: </strong>
                                    </div>
                                    <div class="col-md-8 col-8">
                                        {{ Auth::guard('admin')->user()->email }}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <strong>Số điện thoại: </strong>
                                    </div>
                                    <div class="col-md-8 col-8">
                                        {{ Auth::guard('admin')->user()->phone ?? 'Chưa cập nhật' }}
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <strong>Địa chỉ: </strong>
                                    </div>
                                    <div class="col-md-8 col-8">
                                        {{ Auth::guard('admin')->user()->address ?? 'Chưa cập nhật' }}
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('js')
    <script src="{{ asset('admin-assets/js/custom/change-avatar.js') }}"></script>
@endsection
