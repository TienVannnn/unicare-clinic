@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                Danh sách lịch hẹn khám
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('admin.dashboard') }}">Quản lý</a> / <a href="{{ route('appointment.index') }}">Quản lý lịch
                    hẹn</a>
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="search-container">
                        <form action="{{ route('admin.search', ['type' => 'appointment']) }}" method="GET">
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                            <input type="text" placeholder="Nhập tiêu đề lịch hẹn khám" name="name">
                        </form>
                    </div>
                    <div>
                        <button id="mark-read-btn" class="btn btn-success btn-sm d-none"><i
                                class="fas fa-envelope-open me-2"></i>Đánh dấu đã đọc</button>
                        @can('xoa-lich-hen-kham')
                            <button id="delete-selected-btn" class="btn btn-danger btn-sm d-none">Xóa</button>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if ($appointments->count() > 0)
                    @if (request()->has('name') && request()->input('name') != '')
                        <p class="alert alert-info">
                            Kết quả tìm kiếm cho từ khóa: <strong>{{ request()->input('name') }}</strong>
                        </p>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th><input type="checkbox" id="select-all"></th>
                                    <th scope="col">Người gửi</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Số điện thoại</th>
                                    <th scope="col">Chuyên khoa</th>
                                    <th scope="col">Bác sĩ</th>
                                    <th scope="col">Thời gian</th>
                                    <th scope="col">Xử lý</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr class="{{ $appointment->is_viewed == 0 ? 'fw-bold text-black' : '' }}">
                                        <td><input type="checkbox" class="appointment-checkbox"
                                                value="{{ $appointment->id }}"
                                                data-is-viewed="{{ $appointment->is_viewed }}">
                                        </td>
                                        <td>{{ $appointment->name }}</td>
                                        <td>{{ $appointment->email }}</td>
                                        <td>{{ $appointment->phone }}</td>
                                        <td>{{ $appointment->department->name }}</td>
                                        <td>{{ $appointment->doctor->name }}</td>
                                        <td>
                                            @php
                                                $diffInDays = $appointment->created_at->diffInDays(now());
                                            @endphp
                                            {{ $diffInDays > 15 ? $appointment->created_at->format('H:i d/m/Y') : $appointment->created_at->diffForHumans() }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if ($appointment->is_viewed == 0)
                                                    <a href="{{ route('appointment.markRead', $appointment->id) }}"
                                                        class="btn btn-xs me-2 btn-danger" title="Đánh dấu là đã đọc"><i
                                                            class="fas fa-envelope-open" data-bs-toggle="tooltip"
                                                            title="Đánh dấu là đã đọc"></i></a>
                                                @elseif($appointment->is_viewed == 1)
                                                    <a href="{{ route('appointment.markRead', $appointment->id) }}"
                                                        class="btn btn-xs me-2 btn-success" title="Đánh dấu là chưa đọc"><i
                                                            class="fa fa-envelope" data-bs-toggle="tooltip"
                                                            title="Đánh dấu là chưa đọc"></i></a>
                                                @endif
                                                @can('xem-chi-tiet-lich-hen-kham')
                                                    <a href="{{ route('appointment.show', $appointment->id) }}"
                                                        class="btn btn-outline-primary btn-xs me-2" title="Xem lịch hẹn khám"><i
                                                            class="fas fa-eye" data-bs-toggle="tooltip"
                                                            title="Xem lịch hẹn khám"></i></a>
                                                @endcan
                                                @can('xoa-lich-hen-kham')
                                                    <form action="{{ route('appointment.destroy', $appointment->id) }}"
                                                        method="POST" class="delete-form">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="button" title="Xóa lịch hẹn khám"
                                                            class="btn btn-outline-danger btn-xs delete-btn"><i
                                                                class="fas fa-trash" data-bs-toggle="tooltip"
                                                                title="Xóa lịch hẹn khám"></i></button>
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
                        <p class="alert alert-danger">Chưa có lịch hẹn khám nào!</p>
                    @endif
                @endif
            </div>

            <div class="d-flex justify-content-center ">
                {{ $appointments->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/deleteSweetaler.js') }}"></script>
    <script src="{{ asset('admin-assets/js/custom/appointment-checkall.js') }}"></script>
@endsection
