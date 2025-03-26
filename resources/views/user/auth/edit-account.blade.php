@extends('user.auth.layout_profile')
@section('content_profile')
    <form action="{{ route('user.account-edit') }}" method="POST">
        @csrf
        <div class="row" style="margin: 0 auto">
            <div class="form-outline mb-3 col-lg-6">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" class="form-control" disabled value="{{ $user->email }}" />
            </div>
            <div class="form-outline mb-3 col-lg-6">
                <label class="form-label" for="name">Họ tên <span class="text-danger">*</span></label>
                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                    value="{{ $user->name }}" />
                @error('name')
                    <div class="message-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-outline mb-3 col-lg-6">
                <label class="form-label" for="phone">Điện thoại</label>
                <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror"
                    name="phone" value="{{ $user->phone ? $user->phone : old('phone') }}"
                    placeholder="Nhập số điện thoại" />
                @error('phone')
                    <div class="message-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-outline mb-3 col-lg-6">
                <label class="form-label" for="address">Địa chỉ</label>
                <input type="text" id="address" class="form-control" name="address"
                    value="{{ $user->address ? $user->address : old('address') }}" placeholder="Nhập địa chỉ" />
            </div>
            <div class="form-outline mb-3 col-lg-6">
                <label class="form-label" for="patient_code">Mã bệnh nhân</label>
                <input type="text" id="patient_code" class="form-control" name="patient_code"
                    value="{{ $user->patient_code ? $user->patient_code : old('patient_code') }}"
                    placeholder="Nhập mã bệnh nhân" />
            </div>
        </div>
        <div class="pl-3">
            <button type="submit" class="btn btn-primary mb-3">Cập nhật</button>
        </div>
    </form>
@endsection
