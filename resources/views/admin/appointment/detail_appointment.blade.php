@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                Chi tiết lịch hẹn khám
            </div>
            <div class="text-capitalize fw-bold">
                <a href="{{ route('appointment.index') }}">Quản lý lịch hẹn</a> / Chi tiết
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <div class="d-flex align-items-center p-3">
                <i class="fas fa-question-circle me-2 fs-3" style="color: #f05a28"></i> Lịch hẹn khám:
                {{ $appointment->name }}
            </div>
            <div class="table-responsive">
                <table class="table table-bordered ">
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 600;text-transform: capitalize;">Thông
                            tin người đăng ký</td>
                        <td>{{ $appointment->user->name }} <i
                                class="fas fa-angle-left"></i>{{ $appointment->user->email }}<i
                                class="fas fa-angle-right"></i> <br> Điện thoại:
                            {{ $appointment->user->phone }} <br>
                            Thời gian gửi yêu cầu: {{ $appointment->created_at->format('H:i d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 600;text-transform: capitalize;">Thông
                            tin người khám</td>
                        <td>{{ $appointment->patient_name }}<br>Giới tính:
                            {{ $appointment->gender == 1 ? 'Nam' : 'Nữ' }} <br>
                            Ngày sinh: {{ \Carbon\Carbon::parse($appointment->dob)->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 600;text-transform: capitalize;">Thời gian
                            khám</td>
                        <td>{{ $appointment->start_time }} -
                            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 600;text-transform: capitalize;">Trạng thái
                        </td>
                        <td class="status-element">
                            @if ($appointment->status == 0)
                                <span class="badge badge-info"> Chờ xác nhận</span>
                            @elseif ($appointment->status == 1)
                                <span class="badge badge-success"> Đã xác nhận</span>
                            @else
                                <span class="badge badge-danger"> Đã hủy</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 600;text-transform: capitalize;">Chuyên
                            khoa
                        </td>
                        <td> {{ $appointment->department->name }} </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 600;text-transform: capitalize;">Bác sĩ
                        </td>
                        <td> {{ $appointment->doctor->name }} </td>
                    </tr>
                    <tr>
                        <td style="width: 20%; white-space: nowrap; font-weight: 600;text-transform: capitalize;">Nội dung
                        </td>
                        <td> {{ $appointment->note }} </td>
                    </tr>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table ">
                    <tr class="text-center">
                        <td>
                            <a href="{{ route('appointment.index') }}" class="btn btn-info" title="Quay lại"><i
                                    class="fas fa-arrow-left me-2" data-bs-toggle="tooltip"></i>Quay
                                lại</a>&nbsp;
                            @can('tra-loi-lich-hen-kham')
                                @if ($admin->hasRole('Bác sĩ') && $appointment->doctor_id == $admin->id)
                                    <a href="{{ route('admin.reply-appointment', $appointment->id) }}" title="Gửi phản hồi"
                                        class="btn btn-success"><i class="fas fa-reply me-2"></i>Phản hồi</a>
                                    &nbsp;
                                @elseif(!$admin->hasRole('Bác sĩ'))
                                    <a href="{{ route('admin.reply-appointment', $appointment->id) }}" title="Gửi phản hồi"
                                        class="btn btn-success"><i class="fas fa-reply me-2"></i>Phản hồi</a>
                                    &nbsp;
                                @endif
                            @endcan
                            @can('xoa-lich-hen-kham')
                                @if ($admin->hasRole('Bác sĩ') && $appointment->doctor_id == $admin->id)
                                    <form action="{{ route('admin.appointment-delete', $appointment->id) }}" method="POST"
                                        class="delete-form" style="display: inline-block">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" title="Xóa lịch hẹn" class="btn btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này')">
                                            <i class="fas fa-trash me-2" data-bs-toggle="tooltip" title="Xóa lịch hẹn"></i> Xóa
                                        </button>
                                    </form>
                                @elseif(!$admin->hasRole('Bác sĩ'))
                                    <form action="{{ route('admin.appointment-delete', $appointment->id) }}" method="POST"
                                        class="delete-form" style="display: inline-block">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" title="Xóa lịch hẹn" class="btn btn-danger"
                                            onclick="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này')">
                                            <i class="fas fa-trash me-2" data-bs-toggle="tooltip" title="Xóa lịch hẹn"></i> Xóa
                                        </button>
                                    </form>
                                @endif
                            @endcan
                        </td>
                    </tr>
                </table>
            </div>

            @if ($replies->count() > 0)
                <div class="d-flex align-items-center p-3">
                    <i class="fas fa-reply me-2 fs-3 text-success"></i> Phản hồi
                </div>
                @foreach ($replies as $reply)
                    <div class="table-responsive" style="margin-bottom: 100px">
                        <table class="table table-bordered ">
                            <tr>
                                <td style="width: 20%; white-space: nowrap;">Thông tin người gửi</td>
                                <td>{{ $reply->doctor->name }} < {{ $reply->doctor->email }}>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%; white-space: nowrap;">Thời gian</td>
                                <td colspan="3"> {{ $reply->created_at->format('H:i d/m/Y') }} </td>
                            </tr>
                            <tr>
                                <td colspan="2">{!! $reply->content !!} </td>
                            </tr>
                        </table>
                    </div>
                @endforeach
            @else
                <div style="margin-left: 10px">
                    <p class="text-danger">Chưa có phản hồi nào.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
