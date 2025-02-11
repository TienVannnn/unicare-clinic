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
                        <form action="{{ route('admin.search', ['type' => 'permission']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tên quyền" name="name">
                        </form>
                    </div>
                    @can('them-quyen')
                        <a href="{{ route('permission.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                            Thêm quyền</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($permissions->count() > 0)
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
                                        <td class="d-flex align-items-center">
                                            @can('chinh-sua-quyen')
                                                <a href="{{ route('permission.edit', $permission->id) }}"
                                                    class="btn btn-outline-primary btn-sm me-2" title="Edit"><i
                                                        class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('xoa-quyen')
                                                <form action="{{ route('permission.destroy', $permission->id) }}" method="POST"
                                                    class="delete-form">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="button" title="Delete"
                                                        class="btn btn-outline-danger btn-sm delete-btn"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            @endcan
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
