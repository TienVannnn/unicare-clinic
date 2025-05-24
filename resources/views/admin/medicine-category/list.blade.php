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
                    Tìm kiếm loại thuốc
                @else
                    Danh sách loại thuốc
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('medicine-category.index') }}">Quản
                    lý loại thuốc</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                    <div class="search-container" title="Tìm kiếm loại thuốc">
                        <form action="{{ route('admin.search', ['type' => 'category']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}">
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
                    @can('them-loai-thuoc')
                        <div class="d-flex justify-content-end my-2 align-items-center">
                            <a href="{{ route('medicine-categories.export') }}"
                                class="btn btn-label-success btn-round btn-sm me-2">Excel</a>
                            <a href="{{ route('medicine-category.create') }}" class="btn btn-secondary"><i
                                    class="fas fa-plus me-1"></i>
                                Thêm loại thuốc</a>
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
                @if ($categories->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên loại thuốc</th>
                                    <th scope="col">Mô tả</th>
                                    <th scope="col">Trạng thái</th>
                                    @can(['chinh-sua-loai-thuoc', 'xoa-loai-thuoc'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>{{ $categories->firstItem() + $key }}</td>
                                        <td>{{ $category->name }}
                                            ({{ $category->medicines->count() }})
                                        </td>
                                        <td>{{ $category->description ?? 'Không có' }}</td>
                                        <td>
                                            {!! $category->status == 1
                                                ? '<span class="badge badge-success">Hoạt động</span>'
                                                : '<span class="badge badge-warning">Tạm ngưng</span>' !!}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-loai-thuoc')
                                                    <a href="{{ route('medicine-category.edit', $category->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa loại thuốc"></i></a>
                                                @endcan
                                                @can('xoa-loai-thuoc')
                                                    <form action="{{ route('medicine-category.destroy', $category->id) }}"
                                                        method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa loại thuốc"></i></button>
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
                        <p class="alert alert-danger">Không tìm thấy loại thuốc nào cho từ khóa
                            <strong>{{ request()->input('name') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có loại thuốc nào!</p>
                    @endif
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
