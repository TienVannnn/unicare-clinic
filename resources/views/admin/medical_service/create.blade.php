@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title fw-semibold"> <a href="{{ route('medical-service.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>Thêm mới dịch vụ khám</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('medical-service.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên dịch vụ khám <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Nhập tên dịch vụ khám" value="{{ old('name') }}">
                            @error('name')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="description" class="form-label">Mô tả </label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" placeholder="Nhập mô tả dịch vụ khám"
                                value="{{ old('description') }}">
                            @error('description')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                name="price" placeholder="Nhập giá dịch vụ khám" value="{{ old('price') }}">
                            @error('price')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="clinic" class="form-label">Phòng khám<span class="text-danger">*</span></label>
                            <select class="form-control tag-select" multiple="multiple" id="clinic" name="clinic_ids[]">
                                @if (!empty($clinics))
                                    @foreach ($clinics as $clinic)
                                        <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('clinic')
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

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $('.tag-select').select2({
                placeholder: "Chọn phòng khám"
            })
        })
    </script>
@endsection
