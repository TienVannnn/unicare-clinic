@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center m-4">
            <div class="text-uppercase fw-bold">
                Phản hồi lịch hẹn
            </div>
            <div class="fw-bold text-capitalize">
                <a href="{{ route('appointment.index') }}">Quản lý lịch hẹn khám</a> / Phản hồi lịch hẹn
            </div>
        </div>
        <div class="card shadow-sm m-4">
            <form action="{{ route('admin.handle-reply-appointment') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $appointment->id }}">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <td style="width: 20%; white-space: nowrap;">Tiêu đề gửi</td>
                            <td><input type="text" name="title"
                                    value="Re:{{ $appointment->user->name }} - {{ $appointment->user->phone }}" readonly
                                    class="readonly form-control w-auto">
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 20%; white-space: nowrap;">Gửi tới email</td>
                            <td><input type="email" name="email" value="{{ $appointment->user->email }} "
                                    class="readonly form-control w-auto" readonly></td>
                        </tr>
                        <tr>
                            <td>Trạng thái phản hồi</td>
                            <td>
                                <select id="statusSelect" name="status" class="form-select w-auto">
                                    <option value="1" selected>Xác nhận</option>
                                    <option value="-1">Hủy</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <textarea class="form-control" name="content" id="content">
                                </textarea>
                            </td>
                        </tr>
                    </table>
                </div>

                <table class="table table-striped table-bordered table-hover" style="margin-bottom: 100px">
                    <tr class="text-center">
                        <td>
                            <button type="submit" class="btn btn-success"><i class="far fa-paper-plane me-1"></i>Gửi
                                phản hồi</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' />
    <style>
        .email-content p {
            margin: 0;
            line-height: 1.5;
        }
    </style>
@endsection
@section('js')
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'>
    </script>
    <script>
        var editor = new FroalaEditor('#content', {
            height: 300,
            heightMax: 500
        });
        const confirmContent = `
    <div class="header" style="font-weight: bold; font-size: 25px">XÁC NHẬN ĐẶT LỊCH HẸN</div>
    <p>Kính chào quý khách: {{ $appointment->name }}</p>
    <p>Cảm ơn quý khách đã đặt lịch hẹn tại <a href="https://unicaremedic.ntu264.vpsttt.vn">Unicare medic</a></p>
    <p>Chúng tôi đã nhận được lịch hẹn của quý khách với thông tin như dưới đây:</p>

    <div class="info-block">
        <div class="section-title">THÔNG TIN LỊCH HẸN KHÁM</div>
        <p><strong>NGÀY ĐẶT HẸN:</strong> {{ $appointment->start_time }} -
            {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('d/m/Y') }}</p>
        <p><strong>BÁC SĨ:</strong> Bs. {{ $appointment->doctor->name }}</p>
        <p><strong>CHUYÊN KHOA:</strong> {{ $appointment->department->name }}</p>
    </div>

    <div class="section-title">THÔNG TIN LỊCH HẸN KHÁM</div>
    <div style="display: flex; gap: 40px; margin-top: 20px;">
        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 48%;">
            <thead>
                <tr><th colspan="2" style="background-color: #f0f0f0;">Thông tin người đăng ký</th></tr>
            </thead>
            <tbody>
                <tr><td>Họ và tên</td><td>{{ $appointment->user->name }}</td></tr>
                <tr><td>Điện thoại</td><td>{{ $appointment->user->phone }}</td></tr>
                <tr><td>Email</td><td><a href="mailto:{{ $appointment->user->email }}">{{ $appointment->user->email }}</a></td></tr>
                <tr><td>Lời nhắn</td><td>{{ $appointment->note }}</td></tr>
            </tbody>
        </table>

        <table border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; width: 48%;">
            <thead>
                <tr><th colspan="2" style="background-color: #f0f0f0;">Thông tin bệnh nhân</th></tr>
            </thead>
            <tbody>
                <tr><td>Họ và tên</td><td>{{ $appointment->patient_name }}</td></tr>
                <tr><td>Ngày sinh</td><td>{{ $appointment->dob }}</td></tr>
                <tr><td>Giới tính</td><td>{{ $appointment->gender == 1 ? 'Nam' : 'Nữ' }}</td></tr>
            </tbody>
        </table>
    </div>

    <p class="text-center text-danger" style="margin-top: 30px;">Vui lòng đến đúng giờ để được hướng dẫn khám, chữa bệnh.</p>
`;


        const cancelContent = `
        <div class="header" style="font-weight: bold; font-size: 25px">HỦY LỊCH HẸN</div>
        <p>Kính chào quý khách: {{ $appointment->name }}</p>
        <p>Chúng tôi rất tiếc phải thông báo rằng lịch hẹn khám bệnh của quý khách đã bị hủy vì một số lý do.</p>
        <p>Xin vui lòng liên hệ lại với chúng tôi để đặt lịch mới hoặc được hỗ trợ thêm.</p>
        <p>Trân trọng,</p>
        <p>Unicare Medic</p>
    `;

        document.getElementById('statusSelect').addEventListener('change', function() {
            if (this.value == -1) {
                editor.html.set(cancelContent);
            } else {
                editor.html.set(confirmContent);
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            editor.html.set(confirmContent);
        });
    </script>
@endsection
