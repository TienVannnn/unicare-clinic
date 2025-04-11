const toggleBtn = document.getElementById("toggle-search");
const searchWrapper = document.querySelector(".search-wrapper");
const icon = toggleBtn.querySelector("i");

// Toggle khi nhấn vào nút tìm kiếm
toggleBtn.addEventListener("click", function (e) {
    e.stopPropagation(); // Không lan sự kiện ra ngoài
    searchWrapper.classList.toggle("active");

    // Đổi icon
    if (searchWrapper.classList.contains("active")) {
        icon.classList.remove("fa-search");
        icon.classList.add("fa-times");
    } else {
        icon.classList.remove("fa-times");
        icon.classList.add("fa-search");
    }
});

// Khi click ra ngoài thì ẩn ô tìm kiếm
document.addEventListener("click", function (e) {
    if (!searchWrapper.contains(e.target)) {
        searchWrapper.classList.remove("active");
        icon.classList.remove("fa-times");
        icon.classList.add("fa-search");
    }
});
