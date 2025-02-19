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
                        <form action="{{ route('admin.search', ['type' => 'department']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tên chuyên khoa" name="name">
                        </form>
                    </div>
                    @can('them-chuyen-khoa')
                        <a href="{{ route('department.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                            Thêm chuyên khoa</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($departments->count() > 0)
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
                                    <th scope="col">Tên chuyên khoa</th>
                                    <th scope="col">Mô tả</th>
                                    @can(['chinh-sua-chuyen-khoa', 'xoa-chuyen-khoa'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departments as $key => $department)
                                    <tr>
                                        <td>{{ $departments->firstItem() + $key }}</td>
                                        <td>{{ $department->name }}</td>
                                        <td>{{ $department->description ?? 'Chưa cập nhật' }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-chuyen-khoa')
                                                    <a href="{{ route('department.edit', $department->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa chuyên khoa"></i></a>
                                                @endcan
                                                @can('xoa-chuyen-khoa')
                                                    <form action="{{ route('department.destroy', $department->id) }}"
                                                        method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa chuyên khoa"></i></button>
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
                        <p class="alert alert-danger">Chưa có chuyên khoa nào!</p>
                    @endif
                @endif
            </div>

            <div class="d-flex justify-content-center ">
                {{ $departments->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
