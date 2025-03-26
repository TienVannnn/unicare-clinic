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
                        <form action="{{ route('admin.search', ['type' => 'patient']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tên bệnh nhân" name="name">
                        </form>
                    </div>
                    @can('them-nhan-vien')
                        <a href="{{ route('patient.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-1"></i>
                            Thêm bệnh nhân</a>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($patients->count() > 0)
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
                                    <th scope="col">Tên</th>
                                    <th scope="col">Giới tính</th>
                                    <th scope="col">Ngày sinh</th>
                                    <th scope="col">SĐT</th>
                                    @can(['chinh-sua-nhan-vien', 'xoa-nhan-vien'])
                                        <th scope="col">Xử lý</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patients as $key => $patient)
                                    <tr>
                                        <td>{{ $patients->firstItem() + $key }}</td>
                                        <td>{{ $patient->patient_code }}</td>
                                        <td>{{ $patient->name }}</td>
                                        <td>
                                            @if ($patient->gender == 1)
                                                Nam
                                            @elseif ($patient->gender == 2)
                                                Nữ
                                            @else
                                                Chưa cập nhật
                                            @endif
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') }}</td>
                                        <td>{{ $patient->phone }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @can('chinh-sua-nhan-vien')
                                                    <a href="{{ route('patient.show', $patient->id) }}"
                                                        class="btn btn-outline-success btn-xs me-2"
                                                        title="Xem lịch sử khám bệnh"><i class="fas fa-clock"
                                                            data-bs-toggle="tooltip" title="Xem lịch sử khám bệnh"></i></a>
                                                @endcan
                                                @can('chinh-sua-nhan-vien')
                                                    <a href="{{ route('patient.edit', $patient->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Edit"><i
                                                            class="fas fa-edit" data-bs-toggle="tooltip"
                                                            title="Chỉnh sửa bệnh nhân"></i></a>
                                                @endcan
                                                @can('xoa-nhan-vien')
                                                    <form action="{{ route('patient.destroy', $patient->id) }}" method="POST"
                                                        class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Delete"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa bệnh nhân"></i></button>
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
                        <p class="alert alert-danger">Không tìm thấy bệnh nhân nào cho từ khóa
                            <strong>{{ request()->input('name') }}</strong>!
                        </p>
                    @else
                        <p class="alert alert-danger">Chưa có bệnh nhân nào!</p>
                    @endif
                @endif
            </div>
            <div class="d-flex justify-content-center ">
                {{ $patients->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
@endsection
