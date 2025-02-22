$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

document.querySelectorAll(".pay-btn, .pay-advance-btn").forEach((button) => {
    button.addEventListener("click", function (event) {
        event.preventDefault();
        const medical_certificateId = this.getAttribute("data-id");
        const isAdvance = this.classList.contains("pay-advance-btn");

        let url = isAdvance
            ? route("medical-certificate.pay-advance", medical_certificateId)
            : route("medical-certificate.pay", medical_certificateId);

        Swal.fire({
            title: isAdvance
                ? "Xác nhận thanh toán trước?"
                : "Xác nhận thanh toán?",
            text: isAdvance
                ? "Bạn có chắc muốn thanh toán trước cho giấy khám bệnh này?"
                : "Bạn có chắc giấy khám bệnh đã được thanh toán?",
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
