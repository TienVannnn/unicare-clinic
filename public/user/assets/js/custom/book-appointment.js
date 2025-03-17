document
    .getElementById("book-appointment-form")
    .addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch(this.action, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                Accept: "application/json",
            },
            body: formData,
        })
            .then((response) => {
                if (response.status === 422) {
                    return response.json().then((data) => {
                        displayErrors(data.errors);
                    });
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    toastr.success(data.message, "Thành công");
                    clearErrors();
                }
            })
            .catch((error) => {
                // console.error("Lỗi:", error);
                // toastr.error("Có lỗi xảy ra. Vui lòng thử lại!", "Thất bại");
            });
    });

function displayErrors(errors) {
    clearErrors();

    for (const [field, messages] of Object.entries(errors)) {
        const input = document.querySelector(`[name="${field}"]`);
        const errorContainer = document.createElement("div");
        errorContainer.classList.add("message-error");
        errorContainer.innerText = messages[0];

        if (input) {
            input.classList.add("is-invalid");
            input.parentNode.appendChild(errorContainer);
        }
    }
}

function clearErrors() {
    document.querySelectorAll(".is-invalid").forEach((element) => {
        element.classList.remove("is-invalid");
    });
    document.querySelectorAll(".message-error").forEach((element) => {
        element.remove();
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const departmentSelect = document.querySelector(
        'select[name="department_id"]'
    );
    const doctorSelect = document.querySelector('select[name="doctor_id"]');

    departmentSelect.addEventListener("change", function () {
        const departmentId = this.value;
        if (departmentId) {
            fetch(`/get-doctors/${departmentId}`)
                .then((response) => response.json())
                .then((data) => {
                    doctorSelect.innerHTML =
                        '<option value="" selected>Chọn bác sĩ</option>';
                    data.forEach((doctor) => {
                        doctorSelect.innerHTML += `<option value="${doctor.id}">${doctor.name}</option>`;
                    });
                })
                .catch((error) =>
                    console.error("Error fetching doctors:", error)
                );
        } else {
            doctorSelect.innerHTML =
                '<option value="" selected>Chọn bác sĩ</option>';
        }
    });
});
