@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (request()->has('q') && request()->input('q') != '')
                    Tìm kiếm quyền
                @else
                    Danh sách quyền
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('permission.index') }}">Quản
                    lý quyền</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="search-container" title="Tìm kiếm quyền">
                        <form action="{{ route('admin.search', ['type' => 'permission']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm quyền">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                    @can('them-quyen')
                        <div class="d-flex justify-content-end my-2">
                            <a href="{{ route('permission.create') }}" class="btn btn-secondary"><i
                                    class="fas fa-plus me-1"></i>
                                Thêm quyền</a>
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
                @if ($permissions->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Tên quyền</th>
                                    @can(['chinh-sua-quyen', 'xoa-quyen'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $key => $permission)
                                    <tr>
                                        <td>{{ $permissions->firstItem() + $key }}</td>
                                        <td>{{ $permission->name_permission }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-quyen')
                                                    <a href="{{ route('permission.edit', $permission->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa quyền"></i></a>
                                                @endcan
                                                @can('xoa-quyen')
                                                    <form action="{{ route('permission.destroy', $permission->id) }}"
                                                        method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa quyền"></i></button>
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
                    @if (request()->has('q') && request()->input('q') != '')
                        <p class="alert alert-danger">Không tìm thấy kết quả nào cho từ khóa
                            <strong>{{ request()->input('q') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có quyền nào!</p>
                    @endif
                @endif
            </div>

            <div class="d-flex justify-content-center ">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
