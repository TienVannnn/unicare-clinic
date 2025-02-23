@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('medicine-category.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa loại thuốc</span>
                    <span class="text-primary">"{{ $category->name }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('medicine-category.update', $category->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên loại thuốc <span class="text-danger">*</span></label>
                        <input type="text" value="{{ $category->name }}"
                            class="form-control @error('name') is-invalid @enderror" id="name"
                            aria-describedby="emailHelp" name="name">
                        @error('name')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <input type="text" value="{{ $category->description }}"
                            class="form-control @error('description') is-invalid @enderror" id="description"
                            name="description">
                        @error('description')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
