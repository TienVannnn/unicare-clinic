@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    @php
        use Carbon\Carbon;
        $filters = [];
        if (request()->filled('q')) {
            $filters[] = 'Từ khóa: <strong>' . e(request('q')) . '</strong>';
        }
        if (request()->filled('filter_mode')) {
            $mode = request('filter_mode');
            $label = match ($mode) {
                'today' => 'Hôm nay',
                'this_week' => 'Tuần này',
                'this_month' => 'Tháng này',
                'this_year' => 'Năm nay',
                default => null,
            };
            if ($label) {
                $filters[] = 'Chế độ lọc: <strong>' . $label . '</strong>';
            }
        }
        if (request()->filled('status')) {
            $statusText = request('status') == '1' ? 'Hoạt động' : 'Ẩn';
            $filters[] = 'Trạng thái: <strong>' . $statusText . '</strong>';
        }
    @endphp
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (count($filters))
                    Tìm kiếm tin tức
                @else
                    Danh sách tin tức
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('news.index') }}">Quản
                    lý tin tức</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-center">
                    <div class="search-container" title="Tìm kiếm bệnh nhân">
                        <form action="{{ route('admin.search', ['type' => 'news']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm theo từ khóa">
                            <select name="status" title="Tìm kiếm theo trạng thái">
                                <option value="">Trạng thái</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                            <select name="filter_mode" title="Tìm kiếm theo ngày">
                                <option value="">Chọn chế độ</option>
                                <option value="today" {{ request('filter_mode') == 'today' ? 'selected' : '' }}>Hôm nay
                                </option>
                                <option value="this_week" {{ request('filter_mode') == 'this_week' ? 'selected' : '' }}>
                                    Tuần này
                                </option>
                                <option value="this_month" {{ request('filter_mode') == 'this_month' ? 'selected' : '' }}>
                                    Tháng này
                                </option>
                                <option value="this_year" {{ request('filter_mode') == 'this_year' ? 'selected' : '' }}>
                                    Năm
                                    này
                                </option>
                            </select>
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @can('them-tin-tuc')
                    <div class="d-flex justify-content-end my-2">
                        <a href="{{ route('news.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                            Thêm tin tức</a>
                    </div>
                @endcan
                @if (count($filters))
                    <p class="alert alert-info">
                        Kết quả tìm kiếm: {!! implode(', ', $filters) !!}
                    </p>
                @endif
                @if ($news->count() > 0)
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
                                        <td>
                                            @foreach ($new->newsCategories as $category)
                                                <span class="badge bg-primary">{{ $category->name }}</span>
                                            @endforeach
                                        </td>
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
                    <p class="alert alert-danger">Chưa có tin tức nào!</p>
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
