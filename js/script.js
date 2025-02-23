document.addEventListener("DOMContentLoaded", function() {
    const shineEffect = document.querySelector(".shine");

    if (shineEffect) {
        setTimeout(() => {
            shineEffect.style.display = "none"; // Ẩn đi sau khi chạy xong
        }, 2000); // Thời gian = thời gian của animation (2s)
    }
});