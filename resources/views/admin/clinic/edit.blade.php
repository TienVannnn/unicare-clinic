@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('clinic.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa phòng khám</span>
                    <span class="text-primary">"{{ $clinic->name }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('clinic.update', $clinic->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên phòng khám</label>
                        <input type="text" value="{{ $clinic->name }}"
                            class="form-control @error('name') is-invalid @enderror" id="name"
                            aria-describedby="emailHelp" name="name">
                        @error('name')
                            <div class="message-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
