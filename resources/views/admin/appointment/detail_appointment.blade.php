@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                Chi tiết lịch hẹn khám
            </div>
            <div class="text-uppercase fw-bold">
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
                            tin người dùng</td>
                        <td>{{ $appointment->name }} <i class="fas fa-angle-left"></i> {{ $appointment->email }} <i
                                class="fas fa-angle-right"></i> <br> Điện thoại:
                            {{ $appointment->phone }} <br>
                            Thời gian: {{ $appointment->created_at->format('H:i d/m/Y') }}
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
                            <a href="{{ route('admin.reply-appointment', $appointment->id) }}" title="Gửi phản hồi"
                                class="btn btn-primary">Gửi
                                phản hồi</a>
                            &nbsp;
                            <a href="{{ route('admin.reply-appointment', $appointment->id) }}" title="Gửi phản hồi"
                                class="btn btn-success">Xác nhận</a>
                            &nbsp;
                            <a href="{{ route('admin.reply-appointment', $appointment->id) }}" title="Gửi phản hồi"
                                class="btn btn-danger">Hủy</a>
                            &nbsp;
                            <form action="{{ route('admin.appointment-delete', $appointment->id) }}" method="POST"
                                class="delete-form" style="display: inline-block">
                                @method('DELETE')
                                @csrf
                                <button type="submit" title="Xóa lịch hẹn" class="btn btn-danger"
                                    onclick="return confirm('Bạn có chắc chắn muốn xóa lịch hẹn này')">
                                    <i class="fas fa-trash me-2" data-bs-toggle="tooltip" title="Xóa lịch hẹn"></i> Xóa
                                </button>
                            </form>
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
                                <td>{{ $reply->admin->name }} < {{ $reply->admin->email }}>
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
