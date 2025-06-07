@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (request()->has('q') && request()->input('q') != '')
                    Tìm kiếm người dùng
                @else
                    Danh sách người dùng
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('user.index') }}">Quản
                    lý người dùng</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center">
                    <div class="search-container" title="Tìm kiếm người dùng">
                        <form action="{{ route('admin.search', ['type' => 'user']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm người dùng">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                    @can('them-nguoi-dung')
                        <div class="d-flex justify-content-end my-2 align-items-center">
                            <a href="{{ route('user.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                                Thêm người dùng</a>
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
                @if ($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Điện thoại</th>
                                    <th scope="col">Địa chỉ</th>
                                    <th scope="col">Trạng thái</th>
                                    @can(['sua-nguoi-dung', 'xoa-nguoi-dung'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $key }}</td>
                                        <td>
                                            @if ($user->avatar)
                                                <img src="{{ $user->avatar }}" alt="Chưa cập nhật" height="30"
                                                    width="30" />
                                            @else
                                                <img src="/uploads/avatars/avatar.png" alt="Chưa cập nhật" height="30"
                                                    width="30" />
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->phone ?? 'Chưa cập nhật' }}</td>
                                        <td>{{ $user->address ?? 'Chưa cập nhật' }}</td>
                                        <td>
                                            {!! $user->verify_email == 1
                                                ? '<span class="badge badge-success">Hoạt động</span>'
                                                : '<span class="badge badge-danger">Khóa</span>' !!}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('sua-nguoi-dung')
                                                    <a href="{{ route('user.edit', $user->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa người dùng"></i></a>
                                                @endcan
                                                @can('xoa-nguoi-dung')
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                        class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa người dùng"></i></button>
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
                        <p class="alert alert-danger">Không tìm thấy người dùng nào cho từ khóa
                            <strong>{{ request()->input('q') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có người dùng nào!</p>
                    @endif
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
