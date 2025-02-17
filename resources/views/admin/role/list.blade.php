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
                        <form action="{{ route('admin.search', ['type' => 'role']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tên vai trò" name="name">
                        </form>
                    </div>
                    @can('them-vai-tro')
                        <a href="{{ route('role.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                            Thêm vai trò</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($roles->count() > 0)
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
                                    <th scope="col">Tên vai trò</th>
                                    @can(['chinh-sua-vai-tro', 'xoa-vai-tro'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>{{ $roles->firstItem() + $key }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-vai-tro')
                                                    <a href="{{ route('role.edit', $role->id) }}"
                                                        class="btn btn-outline-primary btn-sm me-2" title="Edit"><i
                                                            class="fas fa-edit"></i></a>
                                                @endcan
                                                @can('xoa-vai-tro')
                                                    <form action="{{ route('role.destroy', $role->id) }}" method="POST"
                                                        class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-sm delete-btn"><i
                                                                class="fas fa-trash"></i></button>
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
                        <p class="alert alert-danger">Không tìm thấy vai trò nào cho từ khóa
                            <strong>{{ request()->input('name') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có quyền nào!</p>
                    @endif
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
