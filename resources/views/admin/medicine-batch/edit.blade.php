@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('medicine-batch.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa lô thuốc</span>
                    <span class="text-primary">"{{ $batch->batch_number }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('medicine-batch.update', $batch->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="medicine" class="form-label">Thuốc <span class="text-danger">*</span></label>
                            <select class="form-control tag-select" id="medicine" name="medicine">
                                @if (!empty($medicines))
                                    @foreach ($medicines as $medicine)
                                        <option value="{{ $medicine->id }}"
                                            {{ $batch->medicine->id == $medicine->id ? 'selected' : '' }}>
                                            {{ $medicine->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('medicine')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="manufacturer" class="form-label">Nhà sản xuất <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('manufacturer') is-invalid @enderror"
                                id="manufacturer" name="manufacturer" placeholder="Nhập nhà sản xuất"
                                value="{{ $batch->manufacturer }}">
                            @error('manufacturer')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="production_address" class="form-label">Nơi sản xuất <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('production_address') is-invalid @enderror"
                                id="production_address" name="production_address" placeholder="Nhập nơi sản xuất"
                                value="{{ $batch->production_address }}">
                            @error('production_address')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="manufacture_date" class="form-label">Ngày sản xuất <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('manufacture_date') is-invalid @enderror"
                                id="manufacture_date" name="manufacture_date" value="{{ $batch->manufacture_date }}">
                            @error('manufacture_date')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="expiry_date" class="form-label">Ngày hết hạn <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('expiry_date') is-invalid @enderror"
                                id="expiry_date" name="expiry_date" value="{{ $batch->expiry_date }}">
                            @error('expiry_date')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="quantity_received" class="form-label">Số lượng nhập về <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity_received') is-invalid @enderror"
                                id="quantity_received" name="quantity_received" placeholder="Nhập số lượng"
                                value="{{ $batch->quantity_received }}">
                            @error('quantity_received')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="purchase_price" class="form-label">Giá nhập <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('purchase_price') is-invalid @enderror"
                                id="purchase_price" name="purchase_price" placeholder="Nhập giá nhập theo đơn vị chính"
                                value="{{ $batch->purchase_price }}">
                            @error('purchase_price')
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
                placeholder: "Chọn thuốc"
            })
        })
    </script>
@endsection
