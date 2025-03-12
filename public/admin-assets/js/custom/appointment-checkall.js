document.addEventListener("DOMContentLoaded", function () {
    const selectAllCheckbox = document.getElementById("select-all");
    const checkboxes = document.querySelectorAll(".appointment-checkbox");
    const deleteBtn = document.getElementById("delete-selected-btn");
    const markReadBtn = document.getElementById("mark-read-btn");

    function updateButtons() {
        const checkedCount = document.querySelectorAll(
            ".appointment-checkbox:checked"
        ).length;
        if (checkedCount > 0) {
            deleteBtn.classList.remove("d-none");
            markReadBtn.classList.remove("d-none");
        } else {
            deleteBtn.classList.add("d-none");
            markReadBtn.classList.add("d-none");
        }
    }

    selectAllCheckbox.addEventListener("change", function () {
        checkboxes.forEach((checkbox) => {
            checkbox.checked = this.checked;
        });
        updateButtons();
    });

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", updateButtons);
    });

    deleteBtn.addEventListener("click", function () {
        const selectedIds = [...checkboxes]
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
        const selectedIds = [...checkboxes]
            .filter((c) => c.checked)
            .map((c) => c.value);

        if (selectedIds.length === 0) return;

        fetch(route("appointment.markReadAll"), {
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
