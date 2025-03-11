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
