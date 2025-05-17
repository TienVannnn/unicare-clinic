@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="card-title fw-semibold"> <a href="{{ route('prescription.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>Thêm mới đơn thuốc</h5>
            </div>
            <div class="card-body">
                <form id="prescriptionForm">
                    @csrf
                    <div class="row">
                        <h5>Thông tin đơn thuốc</h5>
                        <div class="mb-3 col-md-6">
                            <label for="medical_certificate_id" class="form-label">Giấy khám bệnh <span
                                    class="text-danger">*</span></label>
                            <select class="form-control tag-select2"id="medical_certificate_id"
                                name="medical_certificate_id">
                                <option value="" selected>Chọn giấy khám bệnh</option>
                                @if (!empty($medical_certificates))
                                    @foreach ($medical_certificates as $medical_certificate)
                                        <option value="{{ $medical_certificate->id }}">
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
                                name="note" placeholder="Nhập ghi chú" value="{{ old('note') }}">
                            @error('note')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>
                    <div class="row">
                        <div class="mt-3">
                            <h5>Chi tiết đơn thuốc</h5>
                            <div class="row medicine-row">
                                <div class="col-md-3 mb-2">
                                    <label for="medicine" class="form-label">Tên thuốc <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control tag-select3" id="medicine" name="medicines[0][medicine]">
                                        <option value="" selected></option>
                                        @if (!empty($medicines))
                                            @foreach ($medicines as $medicine)
                                                <option value="{{ $medicine->id }}"
                                                    data-quantity="{{ $medicine->batch_quantity_remaining }}">
                                                    {{ $medicine->name }} ({{ $medicine->batch_quantity_remaining }}
                                                    {{ $medicine->base_unit }} còn lại)
                                                </option>
                                            @endforeach
                                        @endif

                                    </select>
                                    <div class="message-error" id="medicines_0_medicineError"></div>
                                </div>
                                <div class="col-md-2 mb-2">
                                    <label for="medicines_0_quantity" class="form-label">Số lượng <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="medicines_0_quantity"
                                        name="medicines[0][quantity]" placeholder="Nhập số lượng"
                                        value="{{ old('medicines.0.quantity') }}">
                                    <div class="message-error" id="medicines_0_quantityError"></div>
                                </div>
                                <div class="col-md-5">
                                    <label for="medicines_0_dosage" class="form-label">Cách dùng <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="medicines_0_dosage"
                                        name="medicines[0][dosage]" placeholder="Nhập cách dùng"
                                        value="{{ old('medicines.0.dosage') }}">
                                    <div class="message-error" id="medicines_0_dosageError"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-success mt-2" onclick="addRow()">
                                    <i class="fas fa-plus me-1"></i>Thêm
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Lưu lại</button>
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
