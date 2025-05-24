@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (request()->has('q') && request()->input('q') != '')
                    Tìm kiếm nhân viên
                @else
                    Danh sách nhân viên
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('manager.index') }}">Quản
                    lý nhân viên</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="search-container" title="Tìm kiếm nhân viên">
                        <form action="{{ route('admin.search', ['type' => 'manager']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm nhân viên">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                    @can('them-nhan-vien')
                        <div class="d-flex justify-content-end my-2 align-items-center">
                            <a href="{{ route('admins.export') }}" class="btn btn-label-success btn-round btn-sm me-2">Excel</a>
                            <a href="{{ route('manager.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                                Thêm nhân viên</a>
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
                @if ($managers->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Vai trò</th>
                                    <th scope="col">Phòng ban</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Trạng thái</th>
                                    @can(['chinh-sua-nhan-vien', 'xoa-nhan-vien'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($managers as $key => $manager)
                                    <tr>
                                        <td>{{ $managers->firstItem() + $key }}</td>
                                        <td>
                                            @if ($manager->avatar)
                                                <img src="{{ $manager->avatar }}" alt="Chưa cập nhật" height="30"
                                                    width="30" />
                                            @else
                                                <img src="/uploads/avatars/avatar.png" alt="Chưa cập nhật" height="30"
                                                    width="30" />
                                            @endif
                                        </td>
                                        <td>{{ $manager->name }}</td>
                                        <td>
                                            @foreach ($manager->roles as $role)
                                                <span class="badge badge-primary">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">{{ $manager->clinic->name }}</span>
                                        </td>
                                        <td>{{ $manager->email }}</td>
                                        <td>
                                            {!! $manager->status == 1
                                                ? '<span class="badge badge-success">Hoạt động</span>'
                                                : '<span class="badge badge-danger">Khóa</span>' !!}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-nhan-vien')
                                                    <a href="{{ route('manager.edit', $manager->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa nhân viên"></i></a>
                                                @endcan
                                                @can('xoa-nhan-vien')
                                                    <form action="{{ route('manager.destroy', $manager->id) }}" method="POST"
                                                        class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa nhân viên"></i></button>
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
                        <p class="alert alert-danger">Không tìm thấy nhân viên nào cho từ khóa
                            <strong>{{ request()->input('q') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có nhân viên nào!</p>
                    @endif
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $managers->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
