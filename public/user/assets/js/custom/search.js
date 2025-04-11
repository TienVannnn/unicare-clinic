const toggleBtn = document.getElementById("toggle-search");
const searchWrapper = document.querySelector(".search-wrapper");
const icon = toggleBtn.querySelector("i");

toggleBtn.addEventListener("click", function (e) {
    e.stopPropagation();
    searchWrapper.classList.toggle("active");

    if (searchWrapper.classList.contains("active")) {
        icon.classList.remove("fa-search");
        icon.classList.add("fa-times");
    } else {
        icon.classList.remove("fa-times");
        icon.classList.add("fa-search");
    }
});

document.addEventListener("click", function (e) {
    if (!searchWrapper.contains(e.target)) {
        searchWrapper.classList.remove("active");
        icon.classList.remove("fa-times");
        icon.classList.add("fa-search");
    }
});
