@extends('user.auth.layout_profile')
@section('content_profile')
    @if ($auth->patient_code)
        <div class="d-flex justify-content-between align-items-center mb-3">
            <p class="text-capitalize font-weight-bold">Thông tin bệnh nhân</p>
            <p>{{ $auth->patient->name }} - {{ \Carbon\Carbon::parse($auth->patient->dob)->format('d/m/Y') }}</p>
        </div>
        <div class="table-responsive">
            <table class="table">
                <thead class="table-primary">
                    <tr>
                        <th>STT</th>
                        <th>Ngày khám</th>
                        <th>Bác sĩ</th>
                        <th>Chẩn đoán</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($medical_history as $key => $his)
                        <tr>
                            <td>{{ $medical_history->firstItem() + $key }}</td>
                            <td>{{ $his->created_at->format('H:i d:m:Y') }}</td>
                            <td>BS. {{ $his->doctor->name }}</td>
                            <td>{!! $his->diagnosis !!}</td>
                            <td><a href="{{ route('user.medical-history-detail', $his->id) }}" class="font-weight-bold"
                                    style="color:#f05a28">Xem
                                    chi tiết</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $medical_history->links() }}
            </div>
        </div>
    @else
        <div class="mb-3">
            <p>Vui lòng nhập mã bệnh nhân trên giấy khám bệnh vào bên dưới để xem lịch sử khám, chữa bệnh tại Unicare.</p>
        </div>
        <form action="{{ route('user.medical-history.get-patient') }}" method="POST">
            @csrf
            <input type="text" name="patient_code" placeholder="Mã bệnh nhân" class="col-md-6">
            @error('patient_code')
                <div class="message-error">{{ $message }}</div>
            @enderror
        </form>
    @endif
@endsection
