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
                <form id="serviceForm" data-id="{{ $medical_certificate->id }}">
                    @csrf
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="patient_id" class="form-label">Bệnh nhân <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" value="{{ $medical_certificate->patient->name }}"
                                disabled>
                            <div class="message-error" id="patient_idError"></div>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="" class="form-label">Căn cước công dân</label>
                            <input type="text" class="form-control" value="{{ $medical_certificate->patient->cccd }}"
                                disabled>
                        </div>
                        <div class="mt-4">
                            <div id="service-rows-container">
                                @if ($medical_certificate->services->count() > 0)
                                    @foreach ($medical_certificate->services as $index => $service)
                                        <div class="row service-row mb-3">
                                            <div class="col-md-4">
                                                <label for="services_{{ $index }}_medical_service_id"
                                                    class="form-label">Dịch vụ khám
                                                    <span class="text-danger">*</span></label>
                                                <select class="form-control tag-select4"
                                                    id="services_{{ $index }}_medical_service_id"
                                                    name="services[{{ $index }}][medical_service_id]">
                                                    <option value="" selected>Chọn dịch vụ</option>
                                                    @foreach ($medical_services as $medical_service)
                                                        <option value="{{ $medical_service->id }}"
                                                            {{ $medical_service->id == $service->pivot->medical_service_id ? 'selected' : '' }}>
                                                            {{ $medical_service->name }}
                                                            ({{ number_format($medical_service->price) }} đ)
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="message-error"
                                                    id="services_{{ $index }}_medical_service_idError"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="services_{{ $index }}_clinic_id"
                                                    class="form-label">Phòng khám <span class="text-danger">*</span></label>
                                                <select class="form-control tag-select5"
                                                    id="services_{{ $index }}_clinic_id"
                                                    name="services[{{ $index }}][clinic_id]">
                                                    <option value="" selected>Chọn phòng khám</option>
                                                    @foreach ($clinics as $clinic)
                                                        <option value="{{ $clinic->id }}"
                                                            {{ $clinic->id == $service->pivot->clinic_id ? 'selected' : '' }}>
                                                            {{ $clinic->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="message-error"
                                                    id="services_{{ $index }}_clinic_idError"></div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="services_{{ $index }}_doctor_id" class="form-label">Bác
                                                    sĩ <span class="text-danger">*</span></label>
                                                <select class="form-control tag-select6"
                                                    id="services_{{ $index }}_doctor_id"
                                                    name="services[{{ $index }}][doctor_id]">
                                                    <option value="" selected>Chọn bác sĩ</option>
                                                    @foreach ($doctors as $doctor)
                                                        <option value="{{ $doctor->id }}"
                                                            {{ $doctor->id == $service->pivot->doctor_id ? 'selected' : '' }}>
                                                            {{ $doctor->name }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="message-error"
                                                    id="services_{{ $index }}_doctor_idError"></div>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="services_{{ $index }}_medical_time"
                                                    class="form-label">Thời gian khám <span
                                                        class="text-danger">*</span></label>
                                                <input type="datetime-local" class="form-control"
                                                    id="services_{{ $index }}_medical_time"
                                                    name="services[{{ $index }}][medical_time]"
                                                    value="{{ $service->pivot->medical_time }}" />
                                                <div class="message-error"
                                                    id="services_{{ $index }}_medical_timeError"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="services_{{ $index }}_note" class="form-label">Ghi
                                                    chú</label>
                                                <textarea class="form-control" id="services_{{ $index }}_note" name="services[{{ $index }}][note]"
                                                    placeholder="Ghi chú dịch vụ" style="height: 42px !important">{{ $service->pivot->note ?? '' }}</textarea>
                                                <div class="message-error" id="services_{{ $index }}_noteError">
                                                </div>
                                            </div>
                                            <div class="col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger"
                                                    onclick="removeServiceRow(this)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="row service-row mb-3" data-index="0">
                                        <div class="col-md-4">
                                            <label for="services_0_medical_service_id" class="form-label">Dịch vụ khám <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control tag-select4" id="services_0_medical_service_id"
                                                name="services[0][medical_service_id]">
                                                <option value="" selected>Chọn dịch vụ</option>
                                                @foreach ($medical_services as $medical_service)
                                                    <option value="{{ $medical_service->id }}">
                                                        {{ $medical_service->name }}
                                                        ({{ number_format($medical_service->price) }} đ)
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="message-error" id="services_0_medical_service_idError"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="services_0_clinic_id" class="form-label">Phòng khám <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control tag-select5" id="services_0_clinic_id"
                                                name="services[0][clinic_id]">
                                                <option value="" selected>Chọn phòng khám</option>
                                                @foreach ($clinics as $clinic)
                                                    <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="message-error" id="services_0_clinic_idError"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="services_0_doctor_id" class="form-label">Bác sĩ <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control tag-select6" id="services_0_doctor_id"
                                                name="services[0][doctor_id]">
                                                <option value="" selected>Chọn bác sĩ</option>
                                                @foreach ($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="message-error" id="services_0_doctor_idError"></div>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="services_0_medical_time" class="form-label">Thời gian khám <span
                                                    class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control"
                                                id="services_0_medical_time" name="services[0][medical_time]" />
                                            <div class="message-error" id="services_0_medical_timeError"></div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="services_0_note" class="form-label">Ghi chú</label>
                                            <textarea class="form-control" id="services_0_note" name="services[0][note]" placeholder="Ghi chú dịch vụ"
                                                style="height: 42px !important"></textarea>
                                            <div class="message-error" id="services_0_noteError"></div>
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger"
                                                onclick="removeServiceRow(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-success mt-2" onclick="addServiceRow()">
                                    <i class="fas fa-plus me-1"></i> Thêm dịch vụ khám
                                </button>
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <label for="symptom" class="form-label">Triệu chứng <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control @error('symptom')
                                'is-invalid'
                            @enderror"
                                id="symptom" placeholder="Triệu chứng" name="symptom"
                                value="{{ $medical_certificate->symptom }}">
                            <div class="message-error" id="symptomError"></div>
                        </div>
                        <div class="mb-3">
                            <label for="diagnosis" class="form-label">Chuẩn đoán ban đầu <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control" id="diagnosis" name="diagnosis" placeholder="Nhập chuẩn đoán ban đầu">{{ $medical_certificate->diagnosis }}</textarea>
                            <div class="message-error" id="diagnosisError"></div>
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
    <script src="{{ asset('admin-assets/js/custom/loadClinic.js') }}"></script>
    <script>
        let serviceIndex = $(".service-row").length;
        const medicalServices = @json($medical_services);
        const clinics = @json($clinics);
        const doctors = @json($doctors);

        function addServiceRow() {
            const container = document.getElementById('service-rows-container');
            const titleDiv = document.createElement('div');
            titleDiv.classList.add('service-title', 'mb-1');
            titleDiv.innerHTML = `<h6>Dịch vụ ${serviceIndex + 1}</h6>`;

            const row = document.createElement('div');
            row.classList.add('row', 'service-row', 'mb-3');
            row.setAttribute('data-index', serviceIndex);

            row.innerHTML = `
        <div class="col-md-4 mt-3">
            <select class="form-control tag-select4" id="services_${serviceIndex}_medical_service_id" name="services[${serviceIndex}][medical_service_id]">
                <option value="" selected>Chọn dịch vụ</option>
                ${medicalServices.map(s => `<option value="${s.id}">${s.name} (${Number(s.price).toLocaleString()} đ)</option>`).join('')}
            </select>
            <div class="message-error" id="services_${serviceIndex}_medical_service_idError"></div>
        </div>
        <div class="col-md-4 mt-3">
            <select class="form-control tag-select5" id="services_${serviceIndex}_clinic_id" name="services[${serviceIndex}][clinic_id]">
                <option value="" selected>Chọn phòng khám</option>
                ${clinics.map(c => `<option value="${c.id}">${c.name}</option>`).join('')}
            </select>
              <div class="message-error" id="services_${serviceIndex}_clinic_idError"></div>
        </div>
        <div class="col-md-4 mt-3">
            <select class="form-control tag-select6" id="services_${serviceIndex}_doctor_id" name="services[${serviceIndex}][doctor_id]">
                <option value="" selected>Chọn bác sĩ</option>
                ${doctors.map(d => `<option value="${d.id}">${d.name}</option>`).join('')}
            </select>
              <div class="message-error" id="services_${serviceIndex}_doctor_idError"></div>
        </div>
        <div class="col-md-5 mt-3">
            <input type="datetime-local" class="form-control" id="services_${serviceIndex}_medical_time" name="services[${serviceIndex}][medical_time]" />
            <div class="message-error" id="services_${serviceIndex}_medical_timeError"></div>
        </div>
        <div class="col-md-6 mt-3">
            <textarea class="form-control" id="services_${serviceIndex}_note" name="services[${serviceIndex}][note]" placeholder="Ghi chú dịch vụ" style="height: 42px !important"></textarea>
              <div class="message-error" id="services_${serviceIndex}_noteError"></div>
        </div>
        <div class="col-md-1 mt-3 d-flex align-items-end">
            <button type="button" class="btn btn-danger" onclick="removeServiceRow(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;

            container.appendChild(titleDiv);
            container.appendChild(row);
            $(`#services_${serviceIndex}_medical_service_id`).select2({
                placeholder: 'Chọn dịch vụ'
            });
            $(`#services_${serviceIndex}_clinic_id`).select2({
                placeholder: 'Chọn phòng khám'
            });
            $(`#services_${serviceIndex}_doctor_id`).select2({
                placeholder: 'Chọn bác sĩ'
            });

            serviceIndex++;
        }


        function removeServiceRow(button) {
            const row = button.closest('.service-row');
            const container = document.getElementById('service-rows-container');
            const titleDiv = row.previousElementSibling;
            if (titleDiv && titleDiv.classList.contains('service-title')) {
                container.removeChild(titleDiv);
            }
            container.removeChild(row);
            serviceIndex--;
        }

        $(document).ready(function() {
            $('.tag-select4').select2({
                placeholder: 'Chọn dịch vụ'
            });
            $('.tag-select5').select2({
                placeholder: 'Chọn phòng khám'
            });
            $('.tag-select6').select2({
                placeholder: 'Chọn bác sĩ'
            });
        });

        $("#serviceForm").on("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            $(".is-invalid").removeClass("is-invalid");
            $(".message-error").text("");

            let certificate_id = $("#serviceForm").data("id");
            let url = route("medical-certificate.service-exam", certificate_id);
            let method = "POST";

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        window.location.href = route("medical-certificate.index");
                    } else {
                        toastr.error(response.message || "Đã xảy ra lỗi");
                    }
                },
                error: function(xhr) {
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let errors = xhr.responseJSON.errors;
                        for (let field in errors) {
                            let error = errors[field][0];
                            let formattedField = field.replace(/\./g, "_");

                            $(`[name="${field}"]`).addClass("is-invalid");
                            $(`#${formattedField}Error`).text(error);
                        }
                    } else {
                        toastr.error("Đã xảy ra lỗi không xác định");
                    }
                },
            });
        });
    </script>
@endsection
