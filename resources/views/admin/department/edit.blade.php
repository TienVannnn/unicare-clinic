@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('department.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa chuyên khoa</span>
                    <span class="text-primary">"{{ $department->name }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('department.update', $department->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên chuyên khoa <span
                                    class="text-danger">*</span></label>
                            <input type="text" value="{{ $department->name }}"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                aria-describedby="emailHelp" name="name">
                            @error('name')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ $department->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ $department->status == 0 ? 'selected' : '' }}>Tạm ngưng</option>
                            </select>
                            @error('status')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <input type="text" value="{{ $department->description }}"
                                class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description" placeholder="Nhập mô tả">
                            @error('description')
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
