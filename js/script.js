//animation
document.addEventListener("DOMContentLoaded", function() {
    const shineEffect = document.querySelector(".shine");

    if (shineEffect) {
        setTimeout(() => {
            shineEffect.style.display = "none"; 
        }, 2000); 
    }
});
//slide main
let slideIndex = 0;
const slides = document.querySelectorAll(".slideshow-image");
const totalSlides = slides.length;
let isAnimating = false; // Ngăn chặn spam click gây lỗi

function showSlide(index) {
    if (isAnimating) return; // Ngăn spam click khi animation chưa hoàn tất
    isAnimating = true;

    slides.forEach(slide => slide.classList.remove("active"));
    slides[index].classList.add("active");

    // Chờ hiệu ứng hoàn tất rồi mới cho phép nhấn tiếp
    setTimeout(() => {
        isAnimating = false;
    }, 800); // Cùng thời gian với transition trong CSS
}

function plusSlides(n) {
    slideIndex = (slideIndex + n + totalSlides) % totalSlides;
    showSlide(slideIndex);
}

// Tự động chuyển ảnh sau 3 giây
setInterval(() => plusSlides(1), 3000);

// Hiển thị slide đầu tiên khi tải trang
showSlide(slideIndex);