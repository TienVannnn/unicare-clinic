@extends('admin.layout_admin.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/listmodule.css') }}">
@endsection
@section('content')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                Lịch hẹn khám chưa đọc
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('appointment.index') }}">Quản lý lịch hẹn khám</a> / Lịch hẹn chưa đọc
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="search-container" title="Tìm kiếm lịch hẹn khám">
                        <form action="{{ route('admin.search', ['type' => 'appointment']) }}" method="GET">
                            <input type="text" placeholder="Từ khóa" name="q" value="{{ request('q') }}"
                                title="Tìm kiếm theo từ khóa">
                            <input type="date" name="date" value="{{ request('date') }}" title="Tìm kiếm theo ngày">
                            <select name="status" title="Tìm kiếm theo trạng thái">
                                <option value="">Trạng thái</option>
                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đã xem</option>
                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Chưa xem</option>
                                <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đã phản hồi</option>
                            </select>
                            <select name="filter_mode" title="Tìm kiếm theo ngày">
                                <option value="">Chọn chế độ</option>
                                <option value="today" {{ request('filter_mode') == 'today' ? 'selected' : '' }}>Hôm nay
                                </option>
                                <option value="this_week" {{ request('filter_mode') == 'this_week' ? 'selected' : '' }}>
                                    Tuần này
                                </option>
                                <option value="this_month" {{ request('filter_mode') == 'this_month' ? 'selected' : '' }}>
                                    Tháng này
                                </option>
                                <option value="this_year" {{ request('filter_mode') == 'this_year' ? 'selected' : '' }}>
                                    Năm
                                    này
                                </option>
                            </select>
                            <button type="submit"><i class="fas fa-search search-icon"></i></button>
                        </form>
                    </div>
                </div>
                <div class="d-flex justify-content-end my-2">
                    <button id="mark-read-btn" class="btn btn-success btn-sm d-none"><i
                            class="fas fa-envelope-open me-2"></i>Đánh dấu đã đọc</button>
                    @can('xoa-lich-hen-kham')
                        <button id="delete-selected-btn" class="btn btn-danger btn-sm d-none">Xóa</button>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                @if ($appointments->count() > 0)
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
                    <p class="alert alert-danger">Chưa có lịch hẹn khám nào!</p>
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
