@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="fw-bold">ĐỔI MẬT KHẨU</h5>
            </div>
            <div class="card-body">
                <h6 class="fw-semibold">Thông tin cơ bản</h6>
                <p class="text-muted small">Điền tất cả thông tin bên dưới</p>
                <form action="{{ route('admin.handle_change-password') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="current-password" class="form-label">Mật khẩu hiện tại <span
                                class="text-danger">*</span></label>
                        <input type="password" id="current-password" name="old_pass"
                            class="form-control @error('old_pass') is-invalid @enderror"
                            placeholder="Nhập mật khẩu hiện tại">
                        @error('old_pass')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="new-password" class="form-label">Mật khẩu mới <span class="text-danger">*</span></label>
                        <input type="password" id="new-password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu mới">
                        @error('password')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Nhập lại mật khẩu mới <span
                                class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" id="confirm-password" class="form-control"
                            placeholder="Nhập lại mật khẩu mới">
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Lưu lại</button>
                        <a href="javascript:window.history.back();" class="btn btn-secondary">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
