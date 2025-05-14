$(function () {
    $(".tag-select").select2({
        placeholder: "Chọn vai trò",
    });
    $(".tag-select2").select2({
        placeholder: "Chọn phòng ban",
    });
    $(".tag-select3").select2({
        placeholder: "Chọn chuyên khoa",
    });

    function loadClinicsByDepartment(departmentId, selectedClinicId = null) {
        if (departmentId) {
            const url = route("admin.getClinicsByDepartment", departmentId);
            $.ajax({
                url: url,
                type: "GET",
                success: function (data) {
                    $("#clinic").empty();
                    $("#clinic").append(
                        '<option value="">Chọn phòng khám</option>'
                    );

                    $.each(data, function (index, clinic) {
                        let rolesText = "";
                        if (
                            clinic.role_summary &&
                            Object.keys(clinic.role_summary).length > 0
                        ) {
                            rolesText = Object.entries(clinic.role_summary)
                                .map(([role, count]) => `${role}: ${count}`)
                                .join(", ");
                        } else {
                            rolesText = "Không có nhân viên";
                        }

                        const isSelected =
                            selectedClinicId && selectedClinicId == clinic.id
                                ? "selected"
                                : "";

                        $("#clinic").append(
                            `<option value="${clinic.id}" ${isSelected}>
                                ${clinic.clinic_code} - ${clinic.name} (${rolesText})
                            </option>`
                        );
                    });

                    $("#clinic").trigger("change");
                },
            });
        } else {
            $("#clinic")
                .empty()
                .append('<option value="">Chọn phòng khám</option>');
        }
    }

    $("#department").on("change", function () {
        const departmentId = $(this).val();
        loadClinicsByDepartment(departmentId);
    });

    const initialDepartmentId = $("#department").val();
    const initialClinicId = $("#clinic").data("selected");
    if (initialDepartmentId) {
        loadClinicsByDepartment(initialDepartmentId, initialClinicId);
    }
});
