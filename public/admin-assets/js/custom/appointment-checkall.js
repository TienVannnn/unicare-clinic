document.addEventListener("DOMContentLoaded", function () {
    const deleteBtn = document.getElementById("delete-selected-btn");
    const selectAllCheckbox = document.getElementById("select-all");
    const appointmentCheckboxes = document.querySelectorAll(
        ".appointment-checkbox"
    );
    const markReadBtn = document.getElementById("mark-read-btn");

    function updateButtonState() {
        const anyChecked = Array.from(appointmentCheckboxes).some(
            (checkbox) => checkbox.checked
        );
        markReadBtn.classList.toggle("d-none", !anyChecked);
        deleteBtn.classList.toggle("d-none", !anyChecked);

        if (anyChecked) {
            const allRead = Array.from(appointmentCheckboxes)
                .filter((checkbox) => checkbox.checked)
                .every((checkbox) => checkbox.dataset.isViewed === "1");

            markReadBtn.innerHTML = allRead
                ? `<i class="fa fa-envelope me-2"></i>Đánh dấu chưa đọc`
                : `<i class="fas fa-envelope-open me-2"></i>Đánh dấu đã đọc`;
        }
    }

    selectAllCheckbox.addEventListener("change", function () {
        appointmentCheckboxes.forEach((checkbox) => {
            checkbox.checked = selectAllCheckbox.checked;
        });
        updateButtonState();
    });

    appointmentCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", updateButtonState);
    });

    deleteBtn.addEventListener("click", function () {
        const selectedIds = [...appointmentCheckboxes]
            .filter((c) => c.checked)
            .map((c) => c.value);

        if (selectedIds.length === 0) return;

        Swal.fire({
            title: `Bạn có chắc muốn xóa ${selectedIds.length} lịch hẹn?`,
            text: "Dữ liệu đã xóa sẽ không thể khôi phục!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Có, xóa ngay!",
            cancelButtonText: "Hủy",
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(route("appointment.bulkDelete"), {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).content,
                    },
                    body: JSON.stringify({
                        ids: selectedIds,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire("Đã xóa!", data.message, "success").then(
                                () => location.reload()
                            );
                        } else {
                            Swal.fire("Lỗi!", data.message, "error");
                        }
                    })
                    .catch(() => {
                        Swal.fire("Lỗi!", "Có lỗi xảy ra khi xóa.", "error");
                    });
            }
        });
    });

    markReadBtn.addEventListener("click", function () {
        const selectedCheckboxes = [...appointmentCheckboxes].filter(
            (c) => c.checked
        );
        const selectedIds = selectedCheckboxes.map((c) => c.value);
        const hasUnread = selectedCheckboxes.some(
            (c) => c.dataset.isViewed === "0"
        );

        if (selectedIds.length === 0) return;

        const routeName = hasUnread
            ? "appointment.markReadAll"
            : "appointment.markUnreadAll";

        fetch(route(routeName), {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: JSON.stringify({
                ids: selectedIds,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire("Thành công!", data.message, "success").then(() =>
                        location.reload()
                    );
                } else {
                    Swal.fire("Lỗi!", data.message, "error");
                }
            })
            .catch(() => {
                Swal.fire("Lỗi!", "Có lỗi xảy ra khi cập nhật.", "error");
            });
    });
});
