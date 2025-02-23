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
                        <form action="{{ route('admin.search', ['type' => 'news']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tiêu đề tin tức" name="name">
                        </form>
                    </div>
                    @can('them-tin-tuc')
                        <a href="{{ route('news.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                            Thêm tin tức</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($news->count() > 0)
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
                                    <th scope="col">Tiêu đề</th>
                                    <th scope="col">Danh mục</th>
                                    <th scope="col">Trạng thái</th>
                                    <th scope="col">Người đăng</th>
                                    <th scope="col">Thời gian</th>
                                    @can(['chinh-sua-tin-tuc', 'xoa-tin-tuc'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($news as $key => $new)
                                    <tr>
                                        <td>{{ $news->firstItem() + $key }}</td>
                                        <td>{{ $new->title }}</td>
                                        <td><span class="badge bg-primary">{{ $new->category->name }}</span></td>
                                        <td>
                                            @if ($new->status == 1)
                                                <span class="badge bg-success">Hoạt động</span>
                                            @else
                                                <span class="badge bg-warning">Ẩn</span>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-primary">{{ $new->poster->name }}</span></td>
                                        <td>{{ $new->created_at->format('H:i d/m/Y') }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-tin-tuc')
                                                    <a href="{{ route('news.edit', $new->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa tin tức"></i></a>
                                                @endcan
                                                @can('xoa-tin-tuc')
                                                    <form action="{{ route('news.destroy', $new->id) }}" method="POST"
                                                        class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa tin tức"></i></button>
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
                        <p class="alert alert-danger">Không tìm thấy tin tức nào cho từ khóa
                            <strong>{{ request()->input('name') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có tin tức nào!</p>
                    @endif
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $news->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
