@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('medicine.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa thuốc</span>
                    <span class="text-primary">"{{ $medicine->name }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('medicine.update', $medicine->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="medicine_code" class="form-label">Mã thuốc <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('medicine_code') is-invalid @enderror"
                                id="medicine_code" name="medicine_code" placeholder="Nhập mã thuốc"
                                value="{{ $medicine->medicine_code }}">
                            @error('medicine_code')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên thuốc <span class="text-danger">*</span></label>
                            <input type="text" value="{{ $medicine->name }}"
                                class="form-control @error('name') is-invalid @enderror" id="name" name="name">
                            @error('name')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="medicine_categories" class="form-label">Loại thuốc <span
                                    class="text-danger">*</span></label>
                            <select class="form-control tag-select" multiple="multiple" id="medicine_categories"
                                name="medicine_categories[]">
                                @if (!empty($medicineCategories))
                                    @foreach ($medicineCategories as $category)
                                        <option value="{{ $category->id }}"
                                            @if (isset($medicine) && $medicine->medicineCategories->contains($category->id)) selected @endif>{{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('medicine_categories')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="ingredient" class="form-label">Thành phần hoạt chất </label>
                            <input type="text" class="form-control @error('ingredient') is-invalid @enderror"
                                id="ingredient" name="ingredient" placeholder="Nhập thành phần hoạt chất"
                                value="{{ $medicine->ingredient }}">
                            @error('ingredient')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="dosage_strength" class="form-label">Hàm lượng </label>
                            <input type="text" class="form-control @error('dosage_strength') is-invalid @enderror"
                                id="dosage_strength" name="dosage_strength" placeholder="Nhập hàm lượng"
                                value="{{ $medicine->dosage_strength }}">
                            @error('dosage_strength')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="unit" class="form-label">Đơn vị tính <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit"
                                name="unit" placeholder="Nhập đơn vị tính (ví dụ: viên, lọ)"
                                value="{{ $medicine->unit }}">
                            @error('unit')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="packaging" class="form-label">Quy cách đóng gói <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('packaging') is-invalid @enderror"
                                id="packaging" name="packaging" placeholder="Nhập quy cách đóng gói (ví dụ: hộp, vỉ)"
                                value="{{ $medicine->packaging }}">
                            @error('packaging')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="base_unit" class="form-label">Đơn vị cơ sở <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('base_unit') is-invalid @enderror"
                                id="base_unit" name="base_unit" placeholder="Nhập đơn vị cơ sở (ví dụ: viên)"
                                value="{{ $medicine->base_unit }}">
                            @error('base_unit')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="quantity_per_unit" class="form-label">Số lượng theo đơn vị cơ sở <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity_per_unit') is-invalid @enderror"
                                id="quantity_per_unit" name="quantity_per_unit"
                                placeholder="Nhập số lượng theo đơn vị cơ sở" value="{{ $medicine->quantity_per_unit }}">
                            @error('quantity_per_unit')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Trạng thái <span
                                    class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ $medicine->status == 1 ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ $medicine->status == 0 ? 'selected' : '' }}>Tạm ngưng</option>
                            </select>
                            @error('status')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="sale_price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('sale_price') is-invalid @enderror"
                                id="sale_price" name="sale_price" placeholder="Nhập giá bán"
                                value="{{ $medicine->sale_price }}">
                            @error('sale_price')
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
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/select2.css') }}">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $('.tag-select').select2({
                placeholder: "Chọn vai trò"
            })
        })
    </script>
@endsection
