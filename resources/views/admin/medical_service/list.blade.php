@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    @php
        $filters = [];
        if (request()->filled('q')) {
            $filters[] = 'Từ khóa: <strong>' . e(request('q')) . '</strong>';
        }
        if (request()->filled('status')) {
            $statuses = ['0' => 'Tạm ngưng', '1' => 'Hoạt động'];
            $filters[] = 'Trạng thái: <strong>' . ($statuses[request('status')] ?? 'Không rõ') . '</strong>';
        }
    @endphp
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (count($filters))
                    Tìm kiếm dịch vụ khám
                @else
                    Danh sách dịch vụ khám
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('medical-service.index') }}">Quản
                    lý dịch vụ khám</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                    <div class="search-container" title="Tìm kiếm dịch vụ khám">
                        <form action="{{ route('admin.search', ['type' => 'medical_service']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm dịch vụ khám">
                            <select name="status" title="Tìm kiếm theo trạng thái">
                                <option value="">Trạng thái</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Tạm ngưng
                                </option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động
                                </option>
                            </select>
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                    @can('them-dich-vu-kham')
                        <div class="d-flex justify-content-end my-2">
                            <a href="{{ route('medical-service.create') }}" class="btn btn-secondary"><i
                                    class="fas fa-plus me-1"></i>
                                Thêm dịch vụ khám</a>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if (count($filters))
                    <p class="alert alert-info">
                        Kết quả tìm kiếm: {!! implode(', ', $filters) !!}
                    </p>
                @endif
                @if ($medical_services->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã</th>
                                    <th scope="col">Tên dịch vụ khám</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Giá (VNĐ)</th>
                                    <th scope="col">Giá BHYT (VNĐ)</th>
                                    <th scope="col">Phòng khám</th>
                                    <th scope="col">Trạng thái</th>
                                    @can(['chinh-sua-dich-vu-kham', 'xoa-dich-vu-kham'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medical_services as $key => $medical_service)
                                    <tr>
                                        <td>{{ $medical_services->firstItem() + $key }}</td>
                                        <td>{{ $medical_service->medical_service_code }}</td>
                                        <td>{{ $medical_service->name }}</td>
                                        <td>{{ $medical_service->description ?? 'Chưa có mô tả' }}</td>
                                        <td>{{ number_format($medical_service->price, 0, ',', '.') }}</td>
                                        <td>{{ number_format($medical_service->insurance_price, 0, ',', '.') }}</td>
                                        <td>
                                            @foreach ($medical_service->clinics as $clinic)
                                                <span class="badge badge-info">{{ $clinic->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            {!! $medical_service->status == 1
                                                ? '<span class="badge badge-success">Hoạt động</span>'
                                                : '<span class="badge badge-warning">Tạm ngưng</span>' !!}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-dich-vu-kham')
                                                    <a href="{{ route('medical-service.edit', $medical_service->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa dịch vụ khám"></i></a>
                                                @endcan
                                                @can('xoa-dich-vu-kham')
                                                    <form action="{{ route('medical-service.destroy', $medical_service->id) }}"
                                                        method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa dịch vụ khám"></i></button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="alert alert-danger">Chưa có dịch vụ khám nào!</p>
                @endif
            </div>

            <div class="d-flex justify-content-center ">
                {{ $medical_services->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
