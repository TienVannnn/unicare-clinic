@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('prescription.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa đơn thuốc</span>
                    <span class="text-primary">"{{ $prescription->prescription_code }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form id="prescriptionForm" data-id="{{ $prescription->id }}">
                    @csrf
                    <div class="row">
                        <h5>Thông tin đơn thuốc</h5>
                        <div class="mb-3 col-md-6">
                            <label for="medical_certificate_id" class="form-label">Giấy khám bệnh <span
                                    class="text-danger">*</span></label>
                            <select class="form-control tag-select2"id="medical_certificate_id"
                                name="medical_certificate_id">
                                <option value="" selected>Giấy khám bệnh</option>
                                @if (!empty($medical_certificates))
                                    @foreach ($medical_certificates as $medical_certificate)
                                        <option value="{{ $medical_certificate->id }}"
                                            {{ $medical_certificate->id === $prescription->medical_certificate->id ? 'selected' : '' }}>
                                            {{ $medical_certificate->medical_certificate_code }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <div class="message-error" id="medical_certificate_idError"></div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="patient_id" class="form-label">Bệnh nhân </label>
                            <div>
                                <p class="patient-info"></p>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú</label>
                            <input type="text" class="form-control @error('note') is-invalid @enderror" id="note"
                                name="note" placeholder="Nhập ghi chú" value="{{ $prescription->note }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-3">
                            <h5>Chi tiết đơn thuốc</h5>
                            @foreach ($prescription->medicines as $index => $medicine)
                                <div class="row medicine-row">
                                    <div class="col-md-3 mb-2">
                                        <label for="medicine_{{ $index }}" class="form-label">Tên thuốc <span
                                                class="text-danger">*</span></label>
                                        <select class="form-control tag-select3" id="medicine_{{ $index }}"
                                            name="medicines[{{ $index }}][medicine]">
                                            @foreach ($medicines as $med)
                                                <option value="{{ $med->id }}"
                                                    {{ $med->id == $medicine->id ? 'selected' : '' }}>
                                                    {{ $med->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="message-error" id="medicines_{{ $index }}_medicineError"></div>
                                    </div>
                                    <div class="col-md-2 mb-2">
                                        <label for="medicines_{{ $index }}_quantity" class="form-label">Số lượng
                                            <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control"
                                            id="medicines_{{ $index }}_quantity"
                                            name="medicines[{{ $index }}][quantity]" placeholder="Nhập số lượng"
                                            value="{{ $medicine->pivot->quantity }}">
                                        <div class="message-error" id="medicines_{{ $index }}_quantityError"></div>
                                    </div>
                                    <div class="col-md-5">
                                        <label for="medicines_{{ $index }}_dosage" class="form-label">Cách dùng
                                            <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control"
                                            id="medicines_{{ $index }}_dosage"
                                            name="medicines[{{ $index }}][dosage]" placeholder="Nhập cách dùng"
                                            value="{{ $medicine->pivot->dosage }}">
                                        <div class="message-error" id="medicines_{{ $index }}_dosageError"></div>
                                    </div>
                                    @if ($index > 0)
                                        <div class="col-md-2 col-lg-2">
                                            <label for="" class="form-label w-100">Thao tác</label>
                                            <button type="button" class="btn btn-danger form-control w-auto"
                                                onclick="removeRow(this)">
                                                <i class="far fa-times-circle me-1"></i>Xóa
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-success mt-2" onclick="addRow()">
                                    <i class="fas fa-plus me-1"></i>Thêm
                                </button>
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('admin-assets/css/custom/select2.css') }}">
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let medicines = @json($medicines);
    </script>
    <script src="{{ asset('admin-assets/js/custom/prescription.js') }}"></script>
@endsection
