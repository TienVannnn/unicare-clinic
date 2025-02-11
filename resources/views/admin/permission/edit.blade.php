@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('permission.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa quyền</span>
                    <span class="text-primary">"{{ $permission->name_permission }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('permission.update', $permission->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên quyền</label>
                        <input type="text" value="{{ $permission->name_permission }}"
                            class="form-control @error('name_permission') is-invalid @enderror" id="name"
                            aria-describedby="emailHelp" name="name_permission">
                        @error('name_permission')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{-- <script src="{{ asset('admin/assets/js/custom.js') }}"></script> --}}
@endsection
