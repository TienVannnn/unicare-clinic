@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title fw-semibold">
                    <a href="{{ route('medicine.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    Thêm mới thuốc
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('medicine.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="medicine_code" class="form-label">Mã thuốc <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('medicine_code') is-invalid @enderror"
                                id="medicine_code" name="medicine_code" placeholder="Nhập mã thuốc"
                                value="{{ old('medicine_code') }}">
                            @error('medicine_code')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="name" class="form-label">Tên thuốc <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" placeholder="Nhập tên thuốc" value="{{ old('name') }}">
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
                                        <option value="{{ $category->id }}">{{ $category->name }}
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
                                value="{{ old('ingredient') }}">
                            @error('ingredient')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="dosage_strength" class="form-label">Hàm lượng </label>
                            <input type="text" class="form-control @error('dosage_strength') is-invalid @enderror"
                                id="dosage_strength" name="dosage_strength" placeholder="Nhập hàm lượng"
                                value="{{ old('dosage_strength') }}">
                            @error('dosage_strength')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="unit" class="form-label">Đơn vị tính <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit"
                                name="unit" placeholder="Nhập đơn vị tính (ví dụ: viên, lọ)"
                                value="{{ old('unit') }}">
                            @error('unit')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="packaging" class="form-label">Quy cách đóng gói <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('packaging') is-invalid @enderror"
                                id="packaging" name="packaging" placeholder="Nhập quy cách đóng gói (ví dụ: hộp, vỉ)"
                                value="{{ old('packaging') }}">
                            @error('packaging')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="base_unit" class="form-label">Đơn vị cơ sở <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('base_unit') is-invalid @enderror"
                                id="base_unit" name="base_unit" placeholder="Nhập đơn vị cơ sở (ví dụ: viên)"
                                value="{{ old('base_unit') }}">
                            @error('base_unit')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="quantity_per_unit" class="form-label">Số lượng theo đơn vị cơ sở <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity_per_unit') is-invalid @enderror"
                                id="quantity_per_unit" name="quantity_per_unit"
                                placeholder="Nhập số lượng theo đơn vị cơ sở" value="{{ old('quantity_per_unit') }}">
                            @error('quantity_per_unit')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="manufacturer" class="form-label">Nhà sản xuất <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('manufacturer') is-invalid @enderror"
                                id="manufacturer" name="manufacturer" placeholder="Nhập nhà sản xuất"
                                value="{{ old('manufacturer') }}">
                            @error('manufacturer')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="production_address" class="form-label">Nơi sản xuất <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('production_address') is-invalid @enderror"
                                id="production_address" name="production_address" placeholder="Nhập nơi sản xuất"
                                value="{{ old('production_address') }}">
                            @error('production_address')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="manufacture_date" class="form-label">Ngày sản xuất <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('manufacture_date') is-invalid @enderror"
                                id="manufacture_date" name="manufacture_date" value="{{ old('manufacture_date') }}">
                            @error('manufacture_date')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="expiry_date" class="form-label">Ngày hết hạn <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('expiry_date') is-invalid @enderror"
                                id="expiry_date" name="expiry_date" value="{{ old('expiry_date') }}">
                            @error('expiry_date')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="quantity_received" class="form-label">Số lượng nhập về <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity_received') is-invalid @enderror"
                                id="quantity_received" name="quantity_received" placeholder="Nhập số lượng"
                                value="{{ old('quantity_received') }}">
                            @error('quantity_received')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="purchase_price" class="form-label">Giá nhập <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('purchase_price') is-invalid @enderror"
                                id="purchase_price" name="purchase_price" placeholder="Nhập giá nhập theo đơn vị chính"
                                value="{{ old('purchase_price') }}">
                            @error('purchase_price')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="sale_price" class="form-label">Giá bán <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('sale_price') is-invalid @enderror"
                                id="sale_price" name="sale_price" placeholder="Nhập giá bán"
                                value="{{ old('sale_price') }}">
                            @error('sale_price')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="status" class="form-label">Trạng thái <span
                                    class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Tạm ngưng</option>
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
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/select2.css') }}">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function() {
            $('.tag-select').select2({
                placeholder: "Chọn loại thuốc"
            });
        });
        document.addEventListener("DOMContentLoaded", () => {
            const input = document.getElementById("medicine_code");
            let lastCode = "";

            const fields = [
                "name", "ingredient", "dosage_strength", "unit",
                "packaging", "base_unit", "sale_price", "quantity_per_unit"
            ];

            const setField = (id, value) => {
                const el = document.getElementById(id);
                el.value = value || '';
                el.readOnly = true;
            };

            const clearAndEnableFields = () => {
                fields.forEach(id => {
                    const el = document.getElementById(id);
                    el.value = '';
                    el.readOnl = false;
                });

                $('#medicine_categories').val(null).trigger('change').prop('readOnly', false);
            };

            input.addEventListener("blur", async () => {
                const code = input.value.trim();

                if (!code || code === lastCode) return;
                lastCode = code;
                clearAndEnableFields();

                try {
                    const res = await fetch(`/admin/medicines/check-code?code=${code}`);
                    const data = await res.json();

                    if (data.exists) {
                        const m = data.medicine;

                        setField("name", m.name);
                        setField("ingredient", m.ingredient);
                        setField("dosage_strength", m.dosage_strength);
                        setField("unit", m.unit);
                        setField("packaging", m.packaging);
                        setField("base_unit", m.base_unit);
                        setField("sale_price", m.sale_price);
                        setField("quantity_per_unit", m.quantity_per_unit);

                        if (m.categories) {
                            $('#medicine_categories')
                                .val(m.categories)
                                .trigger('change')
                                .prop('readOnly', true);
                        }
                    }
                } catch (err) {
                    console.error("Lỗi khi lấy thông tin thuốc:", err);
                }
            });
        });
    </script>
@endsection
