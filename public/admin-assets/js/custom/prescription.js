let rowIndex = $(".medicine-row").length;

function addRow() {
    const newRow = `
        <div class="row medicine-row">
            <div class="col-md-3 mb-2">
                <label for="medicines_${rowIndex}_medicine" class="form-label">Tên thuốc <span class="text-danger">*</span></label>
                <select class="form-control tag-select3" id="medicines_${rowIndex}_medicine" name="medicines[${rowIndex}][medicine]">
                    <option value="" selected></option>
                    ${getMedicineOptions()}
                </select>
                <div class="message-error" id="medicines_${rowIndex}_medicineError"></div>
            </div>
            <div class="col-md-2 mb-2">
                <label for="medicines_${rowIndex}_quantity" class="form-label">Số lượng <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="medicines_${rowIndex}_quantity" name="medicines[${rowIndex}][quantity]" placeholder="Nhập số lượng">
                <div class="message-error" id="medicines_${rowIndex}_quantityError"></div>
            </div>
            <div class="col-md-5">
                <label for="medicines_${rowIndex}_dosage" class="form-label">Cách dùng <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="medicines_${rowIndex}_dosage" name="medicines[${rowIndex}][dosage]" placeholder="Nhập cách dùng">
                <div class="message-error" id="medicines_${rowIndex}_dosageError"></div>
            </div>
            <div class="col-md-2 col-lg-2">
                <label for="" class="form-label w-100">Thao tác</label>
                <button type="button" class="btn btn-danger form-control w-auto" onclick="removeRow(this)">
                    <i class="far fa-times-circle me-1"></i>Xóa
                </button>
            </div>
        </div>
    `;

    $(".medicine-row:last").after(newRow);
    $(".tag-select3").select2({
        placeholder: "Chọn thuốc",
    });
    rowIndex++;
}
function getMedicineOptions() {
    let options = '<option value="" selected>Chọn thuốc</option>';
    medicines.forEach((medicine) => {
        const quantity = medicine.batch_quantity_remaining || 0;
        const unit = medicine.base_unit || "";
        options += `<option value="${medicine.id}" data-quantity="${quantity}">
                        ${medicine.name} (${quantity} ${unit} còn lại)
                    </option>`;
    });
    return options;
}

function removeRow(button) {
    $(button).closest(".medicine-row").remove();
    rowIndex--;
}

$(function () {
    $(".tag-select").select2({
        placeholder: "Chọn bệnh nhân",
    });
    $(".tag-select2").select2({
        placeholder: "Chọn giấy khám bệnh",
    });
    $(".tag-select3").select2({
        placeholder: "Chọn thuốc",
    });
});

$(document).ready(function () {
    $("#prescriptionForm").on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        $(".is-invalid").removeClass("is-invalid");
        $(".message-error").text("");

        let prescription_id = $("#prescriptionForm").data("id");
        let url = prescription_id
            ? route("prescription.update", prescription_id)
            : route("prescription.store");
        let method = prescription_id ? "POST" : "POST";

        if (prescription_id) {
            formData.append("_method", "PUT");
        }

        $.ajax({
            url: url,
            method: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    window.location.href = route("prescription.index");
                } else {
                    toastr.error(response.message, "Lỗi");
                }
            },
            error: function (xhr) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        let error = errors[field][0];
                        let formattedField = field.replace(/\./g, "_");

                        $(`[name="${field}"]`).addClass("is-invalid");
                        $(`[id="${formattedField}Error"]`).text(error);
                    }
                }
            },
        });
    });

    $(document).ready(function () {
        function loadPatient(medicalCertificateId) {
            $.ajax({
                url: route("medical-certificate.get-patient"),
                type: "GET",
                data: { id: medicalCertificateId },
                success: function (response) {
                    let patient = $(".patient-info");
                    let gender = response.patient.gender == 1 ? "Nam" : "Nữ";
                    let dob = formatDate(response.patient.dob);
                    patient.text(
                        response.patient.name +
                            " | Giới tính: " +
                            gender +
                            " | Ngày sinh: " +
                            dob
                    );
                },
                error: function (xhr) {
                    console.error(
                        "Lỗi khi lấy thông tin bệnh nhân:",
                        xhr.responseText
                    );
                },
            });
        }

        $("#medical_certificate_id").change(function () {
            let medicalCertificateId = $(this).val();
            loadPatient(medicalCertificateId);
        });

        let existingMedicalCertificateId = $("#medical_certificate_id").val();
        if (existingMedicalCertificateId) {
            loadPatient(existingMedicalCertificateId);
        }
    });

    function formatDate(dateString) {
        if (!dateString) return "Không có dữ liệu";

        let date = new Date(dateString);
        if (isNaN(date.getTime())) return "Ngày không hợp lệ";

        let day = String(date.getDate()).padStart(2, "0");
        let month = String(date.getMonth() + 1).padStart(2, "0");
        let year = date.getFullYear();

        return `${day}/${month}/${year}`;
    }

    $(document).on("change", ".tag-select3", function () {
        const selectedOption = $(this).find("option:selected");
        const quantity = selectedOption.data("quantity");
        const row = $(this).closest(".medicine-row");
        const quantityInput = row.find('input[type="number"]');
        if (quantity) {
            quantityInput.attr("max", quantity);
            quantityInput.attr("placeholder", `Tối đa ${quantity}`);
        } else {
            quantityInput.removeAttr("max");
            quantityInput.attr("placeholder", "Nhập số lượng");
        }
    });
    $(document).on("input", 'input[type="number"]', function () {
        const max = parseInt($(this).attr("max"));
        const val = parseInt($(this).val());

        if (max && val > max) {
            $(this).val(max);
            toastr.warning(`Số lượng không được vượt quá ${max}`);
        }
    });
    $(document).ready(function () {
        $(document).on("change", 'select[name^="medicines["]', function () {
            const selectedMedicineId = $(this).val();
            const row = $(this).closest(".medicine-row");
            const quantityInput = row.find('input[name$="[quantity]"]');

            if (!selectedMedicineId) {
                quantityInput.attr("placeholder", "Nhập số lượng");
                return;
            }

            fetch(`/admin/medicines/${selectedMedicineId}/latest-batch`)
                .then((response) => response.json())
                .then((data) => {
                    if (data.exists) {
                        const remaining = data.batch.total_quantity;
                        quantityInput.attr(
                            "placeholder",
                            `Tối đa: ${remaining}`
                        );
                        quantityInput.attr("max", remaining);
                    } else {
                        quantityInput.attr("placeholder", "Không có lô thuốc");
                        quantityInput.removeAttr("max");
                    }
                })
                .catch((error) => {
                    console.error("Lỗi khi lấy thông tin lô thuốc:", error);
                    quantityInput.removeAttr("max");
                });
        });
    });
});
