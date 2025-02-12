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
                        <form action="{{ route('admin.search', ['type' => 'manager']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tên nhân viên" name="name">
                        </form>
                    </div>
                    @can('them-vai-tro')
                        <a href="{{ route('manager.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                            Thêm nhân viên</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($managers->count() > 0)
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
                                    <th scope="col">Ảnh</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">SĐT</th>
                                    <th scope="col">Giới tính</th>
                                    @can(['chinh-sua-vai-tro', 'xoa-vai-tro'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($managers as $key => $manager)
                                    <tr>
                                        <td>{{ $managers->firstItem() + $key }}</td>
                                        <td><img src="{{ $manager->avatar }}" alt="Chưa cập nhật" height="50"
                                                width="50" /></td>
                                        <td>{{ $manager->name }}</td>
                                        <td>{{ $manager->email }}</td>
                                        <td>{{ $manager->phone ?? 'Chưa cập nhật' }}</td>
                                        <td>
                                            @if ($manager->gender == 1)
                                                Nam
                                            @elseif ($manager->gender == 2)
                                                Nữ
                                            @else
                                                Chưa cập nhật
                                            @endif
                                        </td>
                                        <td class="d-flex align-items-center">
                                            @can('chinh-sua-vai-tro')
                                                <a href="{{ route('manager.edit', $manager->id) }}"
                                                    class="btn btn-outline-primary btn-sm me-2" title="Edit"><i
                                                        class="fas fa-edit"></i></a>
                                            @endcan
                                            @can('xoa-vai-tro')
                                                <form action="{{ route('manager.destroy', $manager->id) }}" method="POST"
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
                        <p class="alert alert-danger">Không tìm thấy nhân viên nào cho từ khóa
                            <strong>{{ request()->input('name') }}</strong>!
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
