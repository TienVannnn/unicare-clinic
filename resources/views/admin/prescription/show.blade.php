@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header bg-primary text-white">
                <h4>Chi tiết đơn thuốc #{{ $prescription->prescription_code }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>👨‍🦰 Bệnh nhân</h5>
                        <p><strong>Họ tên:</strong> {{ $prescription->medical_certificate->patient->name }}</p>
                        <p><strong>Ngày sinh:</strong> {{ $prescription->medical_certificate->patient->dob }}</p>
                    </div>
                    <div class="col-md-6">
                        <h5>🧑‍⚕️ Bác sĩ</h5>
                        <p><strong>Họ tên:</strong> {{ $prescription->doctor->name }}</p>
                        <p><strong>Email:</strong> {{ $prescription->doctor->email }}</p>
                    </div>
                </div>

                <div class="mt-3">
                    <h5>📝 Ghi chú</h5>
                    <p>{{ $prescription->note ?? 'Không có ghi chú' }}</p>
                </div>

                <div class="mt-4">
                    <h5>💊 Đơn thuốc</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Tên thuốc</th>
                                    <th>Liều lượng</th>
                                    <th>Số lượng</th>
                                    <th>Giá</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prescription->medicines as $index => $medicine)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $medicine->name }}</td>
                                        <td>{{ $medicine->pivot->dosage }}</td>
                                        <td>{{ $medicine->pivot->quantity }} {{ $medicine->base_unit }}</td>
                                        <td>{{ number_format($medicine->pivot->price) }} VNĐ</td>
                                        <td>{{ number_format($medicine->pivot->subtotal) }} VNĐ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="text-end">
                    <h4><strong>Tổng tiền: {{ number_format($prescription->total_payment) }} VNĐ</strong>
                    </h4>
                </div>
                <div class="mt-4">
                    <h5>💰 Trạng thái thanh toán</h5>
                    @if ($prescription->status == 1)
                        <span class="badge bg-success">Đã thanh toán</span>
                    @else
                        <span class="badge bg-danger">Chưa thanh toán</span>
                    @endif
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <a href="javascript:history.back()" class="btn btn-secondary">Quay lại</a>
                    @if ($prescription->status == 0)
                        <form action="{{ route('prescription.pay', $prescription->id) }}" method="POST" class="pay-form">
                            @csrf
                            <button type="button" class="btn btn-success pay-btn" data-id="{{ $prescription->id }}">
                                <i class="fas fa-money-bill-wave"></i> Thanh toán
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-assets/js/custom/payment.js') }}"></script>
@endsection
