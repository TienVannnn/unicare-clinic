@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('medical-certificate.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Chỉnh sửa giấy khám bệnh</span>
                    <span class="text-primary">"{{ $medical_certificate->medical_certificate_code }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('medical-certificate.update', $medical_certificate->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="patient_id" class="form-label">Bệnh nhân <span class="text-danger">*</span></label>
                            <select class="form-control tag-select"id="patient_id" name="patient_id">
                                @if (!empty($patients))
                                    @foreach ($patients as $patient)
                                        <option value="{{ $patient->id }}"
                                            {{ $patient->id === $medical_certificate->patient->id ? 'selected' : '' }}>
                                            {{ $patient->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('patient_id')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">BHYT</label>
                            <div style="margin-top: 10px">
                                <input type="checkbox" name="insurance" id="insurance"
                                    {{ $medical_certificate->insurance ? 'checked' : '' }}>
                                <label for="insurance">Miễn phí 1 phần dịch vụ khám</label>
                            </div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="clinic_id" class="form-label">Phòng khám <span class="text-danger">*</span></label>
                            <select class="form-control tag-select2"id="clinic_id" name="clinic_id">
                                <option value="" selected>Chọn phòng khám</option>
                                @if (!empty($clinics))
                                    @foreach ($clinics as $clinic)
                                        <option value="{{ $clinic->id }}"
                                            {{ $clinic->id === $medical_certificate->clinic->id ? 'selected' : '' }}>
                                            {{ $clinic->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('clinic_id')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
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
        $(function() {
            $(".tag-select").select2({
                placeholder: "Chọn bệnh nhân",
            });
            $(".tag-select2").select2({
                placeholder: "Chọn phòng khám",
            });
        });
    </script>
@endsection
