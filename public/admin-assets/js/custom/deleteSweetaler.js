$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const deleteButtons = document.querySelectorAll(".delete-btn");
if (deleteButtons.length > 0) {
    deleteButtons.forEach((button) => {
        button.addEventListener("click", function (event) {
            event.preventDefault();
            Swal.fire({
                title: "Bạn có chắc xóa dữ liệu này?",
                text: "Dữ liệu sẽ không được khôi phục!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có, xóa nó!",
                cancelButtonText: "Hủy",
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = this.closest("form");

                    fetch(form.action, {
                        method: "DELETE",
                        body: new FormData(form),
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                        },
                    })
                        .then((response) => response.json())
                        .then((data) => {
                            if (data.success) {
                                Swal.fire(
                                    "Đã xóa!",
                                    data.message,
                                    "success"
                                ).then(() => location.reload());
                            } else {
                                Swal.fire("Lỗi!", data.message, "error");
                            }
                        })
                        .catch(() => {
                            Swal.fire(
                                "Lỗi!",
                                "Có lỗi xảy ra khi xóa.",
                                "error"
                            );
                        });
                }
            });
        });
    });
}
