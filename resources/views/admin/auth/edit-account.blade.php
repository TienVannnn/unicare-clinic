@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="row m-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <a href="javascript:window.history.back();">
                            <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                                <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                            </button>
                        </a>
                        Cài đặt tài khoản
                    </div>
                </div>
                <div class="card-body">
                    <div class="card-sub">
                        <input type="email" disabled class="form-control" id="email2" value="{{ $data->email }}">
                    </div>
                    <form action="{{ route('admin.handle_edit-account') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Họ tên <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" id="name" value="{{ $data->name }}">
                                    @error('name')
                                        <div class="message-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="gender">Giới tính</label>
                                    <div>
                                        <input type="radio" id="male" name="gender" value="1"
                                            {{ $data->gender == 1 ? 'checked' : '' }}>
                                        <label for="male">Nam</label>
                                        <input type="radio" id="female" name="gender" value="2"
                                            {{ $data->gender == 2 ? 'checked' : '' }}>
                                        <label for="female">Nữ</label>
                                    </div>
                                    @error('gender')
                                        <div class="message-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Số điện thoại</label>
                                    <input type="number" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror" id="phone"
                                        value="{{ $data->phone ?? '' }}" placeholder="Nhập số điện thoại">
                                    @error('phone')
                                        <div class="message-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="address">Địa chỉ</label>
                                    <input type="text" name="address"
                                        class="form-control @error('address') is-invalid @enderror" id="address"
                                        value="{{ $data->address ?? '' }}" placeholder="Nhập địa chỉ">
                                    @error('address')
                                        <div class="message-error">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary">Lưu lại</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
