$(document).ready(function () {
    function loadClinics(serviceId, index) {
        $.ajax({
            url: route("get-clinics-by-service"),
            type: "GET",
            data: { service_id: serviceId },
            success: function (response) {
                let clinicSelect = $(`#services_${index}_clinic_id`);
                clinicSelect
                    .empty()
                    .append('<option value="">Chọn phòng khám</option>');

                if (response.length > 0) {
                    response.forEach(function (clinic) {
                        clinicSelect.append(
                            `<option value="${clinic.id}">${clinic.name}</option>`
                        );
                    });
                }
                clinicSelect.trigger("change");
            },
        });
    }
    function loadDoctors(clinicId, index) {
        $.ajax({
            url: route("get-doctors-by-clinic"),
            type: "GET",
            data: { clinic_id: clinicId },
            success: function (response) {
                let doctorSelect = $(`#services_${index}_doctor_id`);
                doctorSelect
                    .empty()
                    .append('<option value="">Chọn bác sĩ</option>');

                if (response.length > 0) {
                    response.forEach(function (doctor) {
                        doctorSelect.append(
                            `<option value="${doctor.id}">${doctor.name}</option>`
                        );
                    });
                }
            },
        });
    }

    $(document).on(
        "change",
        'select[id^="services_"][id$="_medical_service_id"]',
        function () {
            let idParts = this.id.split("_");
            let index = idParts[1];
            let serviceId = $(this).val();
            if (serviceId) {
                loadClinics(serviceId, index);
            } else {
                $(`#services_${index}_clinic_id`)
                    .empty()
                    .append('<option value="">Chọn phòng khám</option>')
                    .trigger("change");
                $(`#services_${index}_doctor_id`)
                    .empty()
                    .append('<option value="">Chọn bác sĩ</option>');
            }
        }
    );

    $(document).on(
        "change",
        'select[id^="services_"][id$="_clinic_id"]',
        function () {
            let idParts = this.id.split("_");
            let index = idParts[1];
            let clinicId = $(this).val();
            if (clinicId) {
                loadDoctors(clinicId, index);
            } else {
                $(`#services_${index}_doctor_id`)
                    .empty()
                    .append('<option value="">Chọn bác sĩ</option>');
            }
        }
    );
});
