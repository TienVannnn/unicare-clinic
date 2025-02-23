@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('role.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa vai trò</span>
                    <span class="text-primary">"{{ $role->name }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('role.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên vai trò <span class="text-danger">*</span></label>
                        <input type="text" value="{{ $role->name }}"
                            class="form-control @error('name') is-invalid @enderror" id="name"
                            aria-describedby="emailHelp" name="name">
                        @error('name')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <label class="fw-bold">Quyền cho vai trò</label>
                            <div class="form-check">
                                <input class="form-check-input primary" type="checkbox" id="checkall">
                                <label class="form-check-label text-primary" for="checkall">
                                    Chọn tất cả
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input primary checkbox-childrent" type="checkbox"
                                            id="permission-{{ $permission->id }}" name="permission_id[]"
                                            value="{{ $permission->id }}"
                                            {{ $permissionChecked->contains('id', $permission->id) ? 'checked' : '' }}>
                                        <label class="form-check-label text-dark" for="permission-{{ $permission->id }}">
                                            {{ $permission->name_permission }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('admin-assets/js/custom/checkall.js') }}"></script>
@endsection
