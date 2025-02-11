$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

const deleteButtons = document.querySelectorAll(".delete-btn");
if (deleteButtons.length > 0) {
    deleteButtons.forEach((button) => {
        button.addEventListener("click", function () {
            event.preventDefault();
            Swal.fire({
                title: "Bạn có chắc?",
                text: "Dữ liệu sẽ không được khôi phục!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Có, xóa nó!",
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Đã xóa!",
                        icon: "success",
                    }).then(() => {
                        this.closest("form").submit();
                    });
                }
            });
        });
    });
}
