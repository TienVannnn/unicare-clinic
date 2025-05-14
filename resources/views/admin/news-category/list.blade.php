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
                    Tìm kiếm danh mục tin tức
                @else
                    Danh sách danh mục tin tức
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('news-category.index') }}">Quản
                    lý danh mục tin tức</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="search-container" title="Tìm kiếm danh mục tin tức">
                        <form action="{{ route('admin.search', ['type' => 'news_category']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm danh mục tin tức">
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
                    @can('them-danh-muc-tin-tuc')
                        <div class="d-flex justify-content-end my-2">
                            <a href="{{ route('news-category.create') }}" class="btn btn-secondary"><i
                                    class="fas fa-plus me-1"></i>
                                Thêm danh mục tin tức</a>
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
                                    <th scope="col">Tên danh mục</th>
                                    <th scope="col">Trạng thái</th>
                                    @can(['chinh-sua-danh-muc-tin-tuc', 'xoa-danh-muc-tin-tuc'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>{{ $categories->firstItem() + $key }}</td>
                                        <td>{{ $category->name }} ({{ $category->news->count() }} bài viết)</td>
                                        <td>
                                            {!! $category->status == 1
                                                ? '<span class="badge badge-success">Hoạt động</span>'
                                                : '<span class="badge badge-warning">Tạm ngưng</span>' !!}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-danh-muc-tin-tuc')
                                                    <a href="{{ route('news-category.edit', $category->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa danh mục tin tức"></i></a>
                                                @endcan
                                                @can('xoa-danh-muc-tin-tuc')
                                                    <form action="{{ route('news-category.destroy', $category->id) }}"
                                                        method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa danh mục tin tức"></i></button>
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
                    <p class="alert alert-danger">Chưa có danh mục tin tức nào!</p>
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
