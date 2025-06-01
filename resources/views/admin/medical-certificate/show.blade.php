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
                        <p><strong>Họ tên:</strong> {{ $medical_certificate->patient->name }}
                            <span><strong>BHYT:</strong>
                                {{ $medical_certificate->insurance ? 'Có' : 'Không' }}
                            </span>
                        </p>
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
                        @if ($medical_certificate->insurance)
                            @php
                                $price = $medical_certificate->medical_service->price;
                                if ($medical_certificate->insurance) {
                                    $price *= 0.8;
                                }
                            @endphp
                            <p>Giá BHYT: {{ number_format($price) }} VND</p>
                        @else
                            <p>Giá: {{ number_format($medical_certificate->medical_service->price) }} VND</p>
                        @endif
                    </div>
                @endif

                <div class="row">
                    <div class="mt-3 col-md-6">
                        <h5>✅ Kết luận</h5>
                        <p>{!! $medical_certificate->conclude !!}</p>
                    </div>
                    <div class="mt-3 col-md-6">
                        <h5>💊 Đơn thuốc</h5>
                        @if ($medical_certificate->prescriptions && $medical_certificate->prescriptions->count() > 0)
                            <ul>
                                @foreach ($medical_certificate->prescriptions as $prescription)
                                    <li>
                                        <a href="{{ route('prescription.show', $prescription->id) }}">
                                            Đơn thuốc #{{ $prescription->prescription_code }} -
                                            {{ $prescription->created_at->format('d/m/Y') }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-danger">Chưa kê đơn</span>
                        @endif
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        @if ($medical_certificate->services->count())
                            <h4>Dịch vụ khám</h4>
                            <table>
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Dịch vụ</th>
                                        <th>Phòng khám</th>
                                        <th>Bác sĩ</th>
                                        <th>Giá tiền (đ)</th>
                                        <th>Thời gian</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($medical_certificate->services as $index => $service)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $service->name }}</td>
                                            <td>
                                                {{ optional(\App\Models\Clinic::find($service->pivot->clinic_id))->name }}
                                                -
                                                {{ optional(\App\Models\Clinic::find($service->pivot->clinic_id))->clinic_code }}
                                            </td>
                                            <td>{{ optional(\App\Models\Admin::find($service->pivot->doctor_id))->name ?? 'N/A' }}
                                            </td>
                                            <td>
                                                {{ number_format($medical_certificate->insurance ? $service->insurance_price : $service->price) }}
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($service->pivot->medical_time)->format('H:i d/m/Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                        <p><strong>Tổng tiền: </strong>{{ number_format($medical_certificate->total_price) }} đ |
                            <span><strong>Trạng thái thanh toán:</strong> </span>
                            @if ($medical_certificate->payment_status == 0)
                                Chưa thanh toán
                            @elseif ($medical_certificate->payment_status == 1)
                                Đã thanh toán
                            @else
                                Đã tạm ứng
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4">
                        <h5>📅 Ngày khám</h5>
                        <p>
                            {{ $medical_certificate->medical_time
                                ? \Carbon\Carbon::parse($medical_certificate->medical_time)->format('H:i d/m/Y')
                                : 'Chưa khám' }}
                        </p>

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
                    <a href="javascript:history.back()" class="btn btn-secondary">Quay lại</a>
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

@section('css')
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
@endsection
