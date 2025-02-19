$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

document.querySelectorAll(".pay-btn").forEach((button) => {
    button.addEventListener("click", function (event) {
        event.preventDefault();
        const prescriptionId = this.getAttribute("data-id");
        let url = route("prescription.pay", prescriptionId);
        Swal.fire({
            title: "Xác nhận thanh toán?",
            text: "Bạn có chắc đơn thuốc đã được thanh toán?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#28a745",
            cancelButtonColor: "#d33",
            confirmButtonText: "Có, thanh toán!",
            cancelButtonText: "Hủy",
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify({}),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire(
                                "Thành công!",
                                data.message,
                                "success"
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire("Lỗi!", data.message, "error");
                        }
                    })
                    .catch(() => {
                        Swal.fire(
                            "Lỗi!",
                            "Có lỗi xảy ra khi thanh toán.",
                            "error"
                        );
                    });
            }
        });
    });
});
