document.getElementById("avatar-input").addEventListener("change", function () {
    const formData = new FormData(document.getElementById("avatar-form"));
    fetch(route("admin.change-avatar"), {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]')
                .value,
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                document.getElementById("user-avatar").src = data.avatar_url;
                toastr.success(
                    "Ảnh đại diện đã được cập nhật thành công!",
                    "Thành công"
                );
            } else {
                toastr.error("Lỗi khi cập nhật ảnh đại diện", "Lỗi");
            }
        })
        .catch((error) => {
            console.error("Error:", error);
            alert("Đã xảy ra lỗi. Vui lòng thử lại.");
        });
});
