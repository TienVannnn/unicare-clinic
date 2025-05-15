@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('medical-service.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa dịch vụ khám</span>
                    <span class="text-primary">"{{ $medical_service->name }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('medical-service.update', $medical_service->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên dịch vụ khám <span
                                    class="text-danger">*</span></label>
                            <input type="text" value="{{ $medical_service->name }}"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                aria-describedby="emailHelp" name="name">
                            @error('name')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="description" class="form-label">Mô tả</label>
                            <input type="text" value="{{ $medical_service->description }}"
                                class="form-control @error('description') is-invalid @enderror"
                                id="description"name="description" placeholder="Nhập mô tả">
                            @error('description')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="price" class="form-label">Giá (VNĐ) <span class="text-danger">*</span></label>
                            <input type="number" min="0" value="{{ $medical_service->price }}"
                                class="form-control @error('price') is-invalid @enderror" id="price" name="price">
                            @error('price')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="insurance_price" class="form-label">Giá BHYT<span
                                    class="text-danger">*</span></label>
                            <input type="number" min="0"
                                class="form-control @error('insurance_price') is-invalid @enderror" id="insurance_price"
                                value="{{ $medical_service->insurance_price }}" name="insurance_price"
                                placeholder="Nhập giá BHYT" value="{{ old('insurance_price') }}">
                            @error('insurance_price')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="clinic" class="form-label">Phòng khám <span class="text-danger">*</span></label>
                            <select class="form-control tag-select" multiple="multiple" id="clinic" name="clinic_ids[]">
                                @if (!empty($clinics))
                                    @foreach ($clinics as $clinic)
                                        <option value="{{ $clinic->id }}"
                                            {{ in_array($clinic->id, $clinicsChecked) ? 'selected' : '' }}>
                                            {{ $clinic->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                            @error('clinic')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ $medical_service->status == 1 ? 'selected' : '' }}>Hoạt động
                                </option>
                                <option value="0" {{ $medical_service->status == 0 ? 'selected' : '' }}>Tạm ngưng
                                </option>
                            </select>
                            @error('status')
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
                placeholder: "Chọn chuyên khoa"
            })
        })
    </script>
@endsection
