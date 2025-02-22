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
                    <span class="text-uppercase" style="font-size: 14px">Chọn dịch vụ khám</span>
                    <span class="text-primary">"{{ $medical_certificate->medical_certificate_code }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('medical-certificate.service-exam', $medical_certificate->id) }}" method="POST">
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
                            <label for="medical_service_id" class="form-label">Dịch vụ khám <span
                                    class="text-danger">*</span></label>
                            <select class="form-control tag-select" id="medical_service_id" name="medical_service_id">
                                <option value="">Chọn dịch vụ khám</option>
                                @foreach ($medical_services as $medical_service)
                                    <option value="{{ $medical_service->id }}"
                                        @if ($medical_certificate->medical_service_id) {{ $medical_service->id === $medical_certificate->medical_service->id ? 'selected' : '' }} @endif>
                                        {{ $medical_service->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('medical_service_id')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="clinic_id" class="form-label">Phòng khám <span class="text-danger">*</span></label>
                            <select class="form-control tag-select3"id="clinic_id" name="clinic_id">
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
                        <div class="mb-3 col-md-6">
                            <label for="doctor_id" class="form-label">Bác sĩ <span class="text-danger">*</span></label>
                            <select class="form-control tag-select2"id="doctor_id" name="doctor_id">
                                <option value="" selected>Chọn bác sĩ</option>
                                @if (!empty($doctors))
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}"
                                            @if ($medical_certificate->doctor_id) {{ $doctor->id === $medical_certificate->doctor->id ? 'selected' : '' }} @endif>
                                            {{ $doctor->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('doctor_id')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="medical_time" class="form-label">Thời gian khám</label>
                            <input type="datetime-local"
                                class="form-control @error('medical_time')
                                'is-invalid'
                            @enderror"
                                id="medical_time" name="medical_time"
                                value="{{ $medical_certificate->medical_time ?? '' }}">
                            @error('medical_time')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="symptom" class="form-label">Triệu chứng <span class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('symptom')
                                'is-invalid'
                            @enderror"
                                id="symptom" placeholder="Triệu chứng" name="symptom"
                                value="{{ $medical_certificate->symptom }}">
                            @error('symptom')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Chuẩn đoán ban đầu <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="diagnosis" name="diagnosis">{{ $medical_certificate->diagnosis }}</textarea>
                            @error('diagnosis')
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
    <link href='https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css' rel='stylesheet'
        type='text/css' />
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js'>
    </script>
    <script>
        $(function() {
            $(".tag-select").select2({
                placeholder: "Chọn dịch vụ khám",
            });
            $(".tag-select2").select2({
                placeholder: "Chọn bác sĩ",
            });
            $(".tag-select3").select2({
                placeholder: "Chọn phòng khám",
            });
            new FroalaEditor('#diagnosis', {
                placeholderText: 'Nhập chuẩn đoán'
            });
        });
    </script>
    <script src="{{ asset('admin-assets/js/custom/loadClinic.js') }}"></script>
@endsection
