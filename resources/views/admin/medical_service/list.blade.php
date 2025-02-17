@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="search-container">
                        <form action="{{ route('admin.search', ['type' => 'medical_service']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tên dịch vụ khám" name="name">
                        </form>
                    </div>
                    @can('them-quyen')
                        <a href="{{ route('medical-service.create') }}" class="btn btn-secondary"><i
                                class="fas fa-plus me-1"></i>
                            Thêm dịch vụ khám</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($medical_services->count() > 0)
                    @if (request()->has('name') && request()->input('name') != '')
                        <p class="alert alert-info">
                            Kết quả tìm kiếm cho từ khóa: <strong>{{ request()->input('name') }}</strong>
                        </p>
                    @endif
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Mã</th>
                                    <th scope="col">Tên dịch vụ khám</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Giá (VNĐ)</th>
                                    <th scope="col">Phòng khám</th>
                                    @can(['chinh-sua-quyen', 'xoa-quyen'])
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
                                        <td>
                                            @foreach ($medical_service->clinics as $clinic)
                                                <span class="badge badge-info">{{ $clinic->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-quyen')
                                                    <a href="{{ route('medical-service.edit', $medical_service->id) }}"
                                                        class="btn btn-outline-primary btn-sm me-2" title="Edit"><i
                                                            class="fas fa-edit"></i></a>
                                                @endcan
                                                @can('xoa-quyen')
                                                    <form action="{{ route('medical-service.destroy', $medical_service->id) }}"
                                                        method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-sm delete-btn"><i
                                                                class="fas fa-trash"></i></button>
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
                    @if (request()->has('name') && request()->input('name') != '')
                        <p class="alert alert-danger">Không tìm thấy kết quả nào cho từ khóa
                            <strong>{{ request()->input('name') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có dịch vụ khám nào!</p>
                    @endif
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
