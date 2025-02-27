@extends('user.auth.layout_profile')
@section('content_profile')
    <form action="{{ route('user.change-password') }}" method="POST">
        @csrf
        <div style="margin: 0 auto">
            <div class="form-outline mb-3"">
                <label class="form-label" for="now_pass">Mật khẩu hiện tại <span class="text-danger">*</span></label>
                <input type="password" id="now_pass" class="form-control @error('now_pass') is-invalid @enderror"
                    name="now_pass" value="{{ old('now_pass') }}" placeholder="Nhập mật khẩu hiện tại" />
                @error('now_pass')
                    <div class="message-error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-outline mb-3"">
                <label class="form-label" for="new-pass">Mật khẩu mới <span class="text-danger">*</span></label>
                <input type="password" id="new-pass" class="form-control @error('password') is-invalid @enderror"
                    name="password" value="{{ old('password') }}" placeholder="Nhập mật khẩu mới" />
                @error('password')
                    <div class="message-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-outline mb-3"">
                <label class="form-label" for="confirm">Xác nhận mật khẩu <span class="text-danger">*</span></label>
                <input type="password" id="confirm" class="form-control" name="password_confirmation"
                    placeholder="Xác nhận mật khẩu mới" />
            </div>
            <button type="submit" class="btn btn-primary mb-3">Cập nhật</button>
        </div>
    </form>
@endsection
