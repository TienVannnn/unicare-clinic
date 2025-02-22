@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header bg-primary text-white">
                <h4>📄 Chi tiết Giấy khám bệnh #{{ $medical_certificate->medical_certificate_code }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>👨‍🦰 Bệnh nhân</h5>
                        <p><strong>Họ tên:</strong> {{ $medical_certificate->patient->name }}</p>
                        <p><strong>Ngày sinh:</strong> {{ $medical_certificate->patient->dob }}</p>
                    </div>

                    <div class="col-md-6">
                        <h5>🧑‍⚕️ Bác sĩ</h5>
                        @if ($medical_certificate->doctor_id)
                            <p><strong>Họ tên:</strong> {{ $medical_certificate->doctor->name }}</p>
                            <p><strong>Email:</strong> {{ $medical_certificate->doctor->email }}</p>
                        @else
                            <p><em>Chưa có bác sĩ</em></p>
                        @endif
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h5>📋 Trạng thái khám</h5>
                        @if ($medical_certificate->medical_status == 2)
                            <span class="badge bg-success">Đã khám</span>
                        @elseif($medical_certificate->medical_status == 1)
                            <span class="badge bg-primary">Đang khám</span>
                        @else
                            <span class="badge bg-warning">Chưa khám</span>
                        @endif
                    </div>

                    <div class="col-md-6">
                        <h5>💰 Trạng thái thanh toán</h5>
                        @if ($medical_certificate->payment_status == 1)
                            <span class="badge bg-success">Đã thanh toán</span>
                        @elseif($medical_certificate->payment_status == 2)
                            <span class="badge bg-warning">Đã tạm ứng</span>
                        @else
                            <span class="badge bg-danger">Chưa thanh toán</span>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="mt-3 col-md-6">
                        <h5>📝 Triệu chứng</h5>
                        <p>{{ $medical_certificate->symptom }}</p>
                    </div>
                    <div class="mt-3 col-md-6">
                        <h5>🔬 Chẩn đoán</h5>
                        <p>{!! $medical_certificate->diagnosis !!}</p>
                    </div>
                </div>

                @if ($medical_certificate->medical_service_id)
                    <div class="mt-3">
                        <h5>🏥 Dịch vụ khám</h5>
                        <p>{{ $medical_certificate->medical_service->name }}</p>
                        <p>Giá: {{ number_format($medical_certificate->medical_service->price) }} VND</p>
                    </div>
                @endif

                <div class="mt-3">
                    <h5>✅ Kết luận</h5>
                    <p>{!! $medical_certificate->conclude !!}</p>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <h5>📅 Ngày khám</h5>
                        <p>{{ \Carbon\Carbon::parse($medical_certificate->medical_time)->format('H:i d/m/Y') }}</p>
                    </div>
                    <div class="col-md-4">
                        <h5>🏥 Ngày xuất viện</h5>
                        <p>{{ $medical_certificate->discharge_date ? \Carbon\Carbon::parse($medical_certificate->discharge_date)->format('d/m/Y') : 'Chưa có' }}
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h5>🔄 Ngày tái khám</h5>
                        <p>{{ $medical_certificate->re_examination_date ? \Carbon\Carbon::parse($medical_certificate->re_examination_date)->format('d/m/Y') : 'Chưa có' }}
                        </p>
                    </div>
                </div>

                @if ($medical_certificate->result_file)
                    <div class="mt-4">
                        <h5>📂 File kết quả</h5>
                        <a href="{{ asset($medical_certificate->result_file) }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-file-download"></i> Xem file
                        </a>
                    </div>
                @endif

                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('medical-certificate.index') }}" class="btn btn-secondary">Quay lại</a>

                    @if ($medical_certificate->payment_status != 1)
                        @if ($medical_certificate->medical_service_id && $medical_certificate->payment_status != 2)
                            <button type="button" class="btn btn-warning pay-advance-btn"
                                data-id="{{ $medical_certificate->id }}">
                                <i class="fas fa-money-bill-wave"></i> Thanh toán tạm ứng
                            </button>
                        @else
                            <button type="button" class="btn btn-success pay-btn"
                                data-id="{{ $medical_certificate->id }}">
                                <i class="fas fa-money-bill-wave"></i> Thanh toán
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/paymentCertificate.js') }}"></script>
@endsection
