@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (request()->has('q') && request()->input('q') != '')
                    Tìm kiếm thuốc
                @else
                    Danh sách thuốc
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('medicine.index') }}">Quản
                    lý thuốc</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="search-container" title="Tìm kiếm thuốc">
                        <form action="{{ route('admin.search', ['type' => 'medicine']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                    @can('them-thuoc')
                        <div class="d-flex justify-content-end my-2">
                            <a href="{{ route('medicine.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                                Thêm thuốc</a>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">

                @if (request()->has('q') && request()->input('q') != '')
                    <p class="alert alert-info">
                        Kết quả tìm kiếm cho từ khóa: <strong>{{ request()->input('q') }}</strong>
                    </p>
                @endif
                @if ($medicines->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên thuốc</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Loại thuốc</th>
                                    <th scope="col">Đơn vị</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Trạng thái</th>
                                    @can(['chinh-sua-thuoc', 'xoa-thuoc'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($medicines as $key => $medicine)
                                    <tr>
                                        <td>{{ $medicines->firstItem() + $key }}</td>
                                        <td>{{ $medicine->name }}</td>
                                        <td>{{ $medicine->description }}</td>
                                        <td>
                                            @foreach ($medicine->medicineCategories as $category)
                                                <span class="badge bg-primary">{{ $category->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $medicine->unit }}</td>
                                        <td>{{ number_format($medicine->price, 0, ',', '.') }}</td>
                                        <td>{{ $medicine->quantity }}</td>
                                        <td>
                                            {!! $medicine->status == 1
                                                ? '<span class="badge badge-success">Hoạt động</span>'
                                                : '<span class="badge badge-warning">Tạm ngưng</span>' !!}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-thuoc')
                                                    <a href="{{ route('medicine.edit', $medicine->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa thuốc"></i></a>
                                                @endcan
                                                @can('xoa-thuoc')
                                                    <form action="{{ route('medicine.destroy', $medicine->id) }}"
                                                        method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa thuốc"></i></button>
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
                        <p class="alert alert-danger">Không tìm thấy thuốc nào cho từ khóa
                            <strong>{{ request()->input('name') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có thuốc nào!</p>
                    @endif
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $medicines->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
