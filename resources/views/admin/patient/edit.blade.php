@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('patient.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa bệnh nhân</span>
                    <span class="text-primary">"{{ $patient->name }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('patient.update', $patient->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên bệnh nhân <span
                                    class="text-danger">*</span></label>
                            <input type="text" value="{{ $patient->name }}"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                aria-describedby="emailHelp" name="name">
                            @error('name')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="dob" class="form-label">Ngày sinh <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"
                                name="dob" value="{{ $patient->dob }}">
                            @error('dob')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <div class="form-group">
                                <label for="gender">Giới tính <span class="text-danger">*</span></label>
                                <div>
                                    <input type="radio" id="male" name="gender" value="1"
                                        @if ($patient->gender == 1) checked @endif>
                                    <label for="male">Nam</label>
                                    <input type="radio" id="female" name="gender" value="2"
                                        @if ($patient->gender == 2) checked @endif>
                                    <label for="female">Nữ</label>
                                </div>
                                @error('gender')
                                    <div class="message-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="phone" class="form-label">Số điện thoại <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                name="phone" placeholder="Nhập số điện thoại" value="{{ $patient->phone }}">
                            @error('phone')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                name="address" placeholder="Nhập địa chỉ" value="{{ $patient->address }}">
                            @error('address')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="cccd" class="form-label">Căn cước công dân <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('cccd') is-invalid @enderror" id="cccd"
                                name="cccd" placeholder="Nhập căn cước công dân" value="{{ $patient->cccd }}">
                            @error('cccd')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="bhyt_number" class="form-label">Bảo hiểm y tế </label>
                            <input type="text" class="form-control @error('bhyt_number') is-invalid @enderror"
                                id="bhyt_number" name="bhyt_number" placeholder="Nhập số BHYT"
                                value="{{ $patient->bhyt_number }}">
                            @error('bhyt_number')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="hospital_registered" class="form-label">Bệnh viện đăng ký </label>
                            <input type="text" class="form-control @error('hospital_registered') is-invalid @enderror"
                                id="hospital_registered" name="hospital_registered" placeholder="Nơi đăng ký thẻ"
                                value="{{ $patient->hospital_registered }}">
                            @error('hospital_registered')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="bhyt_expired_date" class="form-label">Ngày hết hạn thẻ </label>
                            <input type="date" class="form-control @error('bhyt_expired_date') is-invalid @enderror"
                                id="bhyt_expired_date" name="bhyt_expired_date"
                                value="{{ $patient->bhyt_expired_date }}">
                            @error('bhyt_expired_date')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
