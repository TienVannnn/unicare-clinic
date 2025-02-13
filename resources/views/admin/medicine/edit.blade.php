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
                            <label for="name" class="form-label">Tên thuốc</label>
                            <input type="text" value="{{ $medicine->name }}"
                                class="form-control @error('name') is-invalid @enderror" id="name"
                                aria-describedby="emailHelp" name="name">
                            @error('name')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="description" class="form-label">Mô tả</label>
                            <input type="text" value="{{ $medicine->description }}"
                                class="form-control @error('description') is-invalid @enderror" id="description"
                                name="description">
                            @error('description')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="medicine_categories" class="form-label">Loại thuốc</label>
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
                            <label for="unit" class="form-label">Đơn vị</label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit"
                                name="unit" placeholder="Nhập đơn vị tính" value="{{ $medicine->unit }}">
                            @error('unit')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="price" class="form-label">Giá</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                name="price" placeholder="Nhập giá" value="{{ $medicine->price }}">
                            @error('price')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="quantity" class="form-label">Số lượng</label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror"
                                id="quantity" name="quantity" placeholder="Nhập số lượng"
                                value="{{ $medicine->quantity }}">
                            @error('quantity')
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
    <style>
        .select2-container--default {
            width: 100% !important;
        }
    </style>
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
