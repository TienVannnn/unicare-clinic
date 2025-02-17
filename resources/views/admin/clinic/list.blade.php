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
                        <form action="{{ route('admin.search', ['type' => 'clinic']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tên phòng khám" name="name">
                        </form>
                    </div>
                    @can('them-quyen')
                        <a href="{{ route('clinic.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                            Thêm phòng khám</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($clinics->count() > 0)
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
                                    <th scope="col">Mã</th>
                                    <th scope="col">Tên phòng khám</th>
                                    <th scope="col">Chuyên khoa</th>
                                    @can(['chinh-sua-quyen', 'xoa-quyen'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clinics as $key => $clinic)
                                    <tr>
                                        <td>{{ $clinics->firstItem() + $key }}</td>
                                        <td>{{ $clinic->clinic_code }}</td>
                                        <td>{{ $clinic->name }}</td>
                                        <td><span class="badge badge-info">{{ $clinic->department->name }}</span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-quyen')
                                                    <a href="{{ route('clinic.edit', $clinic->id) }}"
                                                        class="btn btn-outline-primary btn-sm me-2" title="Edit"><i
                                                            class="fas fa-edit"></i></a>
                                                @endcan
                                                @can('xoa-quyen')
                                                    <form action="{{ route('clinic.destroy', $clinic->id) }}" method="POST"
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
                        <p class="alert alert-danger">Không tìm thấy kết quả nào cho từ khóa
                            <strong>{{ request()->input('name') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có phòng khám nào!</p>
                    @endif
                @endif
            </div>

            <div class="d-flex justify-content-center ">
                {{ $clinics->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
