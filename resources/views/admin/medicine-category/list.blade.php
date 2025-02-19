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
                        <form action="{{ route('admin.search', ['type' => 'category']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tên loại thuốc" name="name">
                        </form>
                    </div>
                    @can('them-loai-thuoc')
                        <a href="{{ route('medicine-category.create') }}" class="btn btn-secondary"><i
                                class="fas fa-plus me-1"></i>
                            Thêm loại thuốc</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($categories->count() > 0)
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
                                    <th scope="col">Tên loại thuốc</th>
                                    <th scope="col">Mô tả</th>
                                    @can(['chinh-sua-loai-thuoc', 'xoa-loai-thuoc'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td>{{ $categories->firstItem() + $key }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
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
