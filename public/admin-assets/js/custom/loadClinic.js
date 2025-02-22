$(document).ready(function () {
    function loadClinics(serviceId) {
        $.ajax({
            url: route("get-clinics-by-service"),
            type: "GET",
            data: { service_id: serviceId },
            success: function (response) {
                let clinicSelect = $("#clinic_id");
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
            },
        });
    }

    $("#medical_service_id").change(function () {
        let serviceId = $(this).val();
        loadClinics(serviceId);
    });

    function loadDoctors(clinicId) {
        $.ajax({
            url: route("get-doctors-by-clinic"),
            type: "GET",
            data: { clinic_id: clinicId },
            success: function (response) {
                let doctorSelect = $("#doctor_id");
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

    $("#clinic_id").change(function () {
        let clinicId = $(this).val();
        loadDoctors(clinicId);
    });
});
