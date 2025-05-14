@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (request()->has('q') && request()->input('q') != '')
                    Tìm kiếm menu
                @else
                    Danh sách menu
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('menu.index') }}">Quản
                    lý menu</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex flex-column flex-sm-row justify-content-end align-items-center">
                    @can('them-menu')
                        <div class="d-flex justify-content-end my-2">
                            <a href="{{ route('menu.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                                Thêm menu</a>
                        </div>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($menus->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Khối Menu</th>
                                    <th scope="col">Menu trực thuộc</th>
                                    @can(['sua-menu', 'xoa-menu'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $key => $menu)
                                    <tr>
                                        <td>{{ $menu->id }}</td>
                                        <td><a href="{{ route('menu.show', $menu->id) }}">{{ $menu->name }}</a></td>
                                        <td>
                                            @if ($menu->items->count() > 0)
                                                @foreach ($menu->items as $item)
                                                    <span class="badge bg-secondary">{{ $item->title }}</span>
                                                @endforeach
                                            @else
                                                Chưa có menu trực thuộc
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('sua-menu')
                                                    <a href="{{ route('menu.edit', $menu->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa menu"></i></a>
                                                @endcan
                                                @can('xoa-menu')
                                                    <form action="{{ route('menu.destroy', $menu->id) }}" method="POST"
                                                        class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa menu"></i></button>
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
                    <p class="alert alert-danger">Chưa có menu nào!</p>
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $menus->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
