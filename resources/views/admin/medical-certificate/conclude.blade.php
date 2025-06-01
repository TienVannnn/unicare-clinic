@extends('admin.layout_admin.main')
@section('content')
    <div class="container">
        <div class="card shadow-sm m-4">
            <div class="card-header">
                <p class="card-title">
                    <a href="{{ route('medical-certificate.index') }}">
                        <button title="Quay lại" class="btn btn-outline-secondary btn-sm rounded-circle">
                            <i class="fas fa-arrow-left" data-bs-toggle="tooltip" title="Quay lại"></i>
                        </button>
                    </a>
                    <span class="text-uppercase" style="font-size: 14px">Kết luận khám</span>
                    <span class="text-primary">"{{ $medical_certificate->medical_certificate_code }}"</span>
                </p>
            </div>
            <div class="card-body">
                <form action="{{ route('medical-certificate.conclude-handle', $medical_certificate->id) }}" method="POST"
                    enctype="multipart/form-data">
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
                        @if ($medical_certificate->medical_service_id)
                            <div class="mb-3 col-md-6">
                                <label for="medical_service_id" class="form-label">Dịch vụ khám </label>
                                <input type="text" class="form-control"
                                    value="{{ $medical_certificate->medical_service->name }}" disabled>
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="clinic_id" class="form-label">Phòng khám </label>
                                <input type="text" class="form-control" name="clinic_id"
                                    value="{{ $medical_certificate->clinic ? $medical_certificate->clinic->name : '' }}"
                                    disabled>
                            </div>
                        @else
                            <div class="mb-3 col-md-6">
                                <label for="clinic_id" class="form-label">Phòng khám <span
                                        class="text-danger">*</span></label>
                                <select class="form-control tag-select3"id="clinic_id" name="clinic_id">
                                    <option value="" selected>Chọn phòng khám</option>
                                    @if (!empty($clinics))
                                        @foreach ($clinics as $clinic)
                                            <option value="{{ $clinic->id }}"
                                                {{ $clinic->id === optional($medical_certificate->clinic)->id ? 'selected' : '' }}>
                                                {{ $clinic->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @error('clinic_id')
                                    <div class="message-error">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                        <div class="mb-3 col-md-6">
                            <label class="form-label">Ngày đăng ký</label>
                            <input type="datetime" class="form-control"
                                value="{{ $medical_certificate->created_at->format('H:i d/m/Y') }}" disabled>
                        </div>
                        @if ($medical_certificate->medical_time)
                            <div class="mb-3 col-md-6">
                                <label class="form-label">Thời gian khám</label>
                                <input type="datetime" class="form-control"
                                    value="{{ \Carbon\Carbon::parse($medical_certificate->medical_time)->format('H:i d/m/Y') }}"
                                    disabled>
                            </div>
                        @endif
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
                        <div class="mb-3">
                            <label for="conclude" class="form-label">Kết luận và chỉ định <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="conclude" name="conclude">{{ $medical_certificate->conclude }}</textarea>
                            @error('conclude')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="result" class="form-label">Hình ảnh kết quả </label>
                            <input type="file" class="form-control" id="result" name="result_file">
                            @error('result_file')
                                <div class="message-error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="re-examination_date" class="form-label">Ngày tái khám</label>
                            <input type="date" class="form-control" id="re-examination_date"
                                name="re_examination_date" value="{{ $medical_certificate->re_examination_date }}">
                            @error('re_examination_date')
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
                placeholder: "Chọn bệnh nhân",
            });
            new FroalaEditor('#diagnosis', {
                placeholderText: 'Nhập chuẩn đoán'
            });
            new FroalaEditor('#conclude', {
                placeholderText: 'Nhập kết luận'
            });
        });
    </script>
@endsection
