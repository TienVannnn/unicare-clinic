@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    @php
        use Carbon\Carbon;
        $filters = [];
        if (request()->filled('q')) {
            $filters[] = 'Từ khóa: <strong>' . e(request('q')) . '</strong>';
        }
        if (request()->filled('dob')) {
            $dobFormatted = Carbon::createFromFormat('Y-m-d', request('dob'))->format('d/m/Y');
            $filters[] = 'Ngày sinh: <strong>' . e($dobFormatted) . '</strong>';
        }
        if (request()->filled('gender')) {
            $genderText = request('gender') == '1' ? 'Nam' : 'Nữ';
            $filters[] = 'Giới tính: <strong>' . $genderText . '</strong>';
        }
    @endphp
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                @if (count($filters))
                    Tìm kiếm bệnh nhân
                @else
                    Danh sách bệnh nhân
                @endif
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('patient.index') }}">Quản lý bệnh
                    nhân</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-center">
                    <div class="search-container" title="Tìm kiếm bệnh nhân">
                        <form action="{{ route('admin.search', ['type' => 'patient']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm theo từ khóa">
                            <input type="date" name="dob" value="{{ request('dob') }}"
                                title="Tìm kiếm theo ngày sinh">
                            <select name="gender" title="Tìm kiếm theo giới tính">
                                <option value="">Giới tính</option>
                                <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>Nam</option>
                                <option value="0" {{ request('gender') == '0' ? 'selected' : '' }}>Nữ</option>
                            </select>
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                </div>

            </div>
            <div class="card-body">
                @can('them-nhan-vien')
                    <div class="d-flex justify-content-end my-2 align-items-center">
                        <a href="{{ route('patients.export') }}" class="btn btn-label-success btn-round btn-sm me-2">Excel</a>
                        <a href="{{ route('patient.create') }}" class="btn btn-secondary">
                            <i class="fas fa-plus me-1"></i> Thêm bệnh nhân
                        </a>
                    </div>
                @endcan
                @if (count($filters))
                    <p class="alert alert-info">
                        Kết quả tìm kiếm: {!! implode(', ', $filters) !!}
                    </p>
                @endif
                @if ($patients->count() > 0)
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
                                    <th scope="col">Địa chỉ</th>
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
                                        <td class="text-truncate" style="display: block; width: 200px">
                                            {{ $patient->address }}
                                        </td>
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
                    <p class="alert alert-danger">Chưa có bệnh nhân nào!</p>
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
