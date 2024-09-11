// home_slider.js
document.addEventListener("DOMContentLoaded", function() {
    const slides = document.querySelectorAll(".slider_slider");
    const totalSlides = slides.length;
    let currentIndex = 0;

    const leftArrow = document.querySelector(".left-arrow");
    const rightArrow = document.querySelector(".right-arrow");

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.style.transform = `translateX(${(i - index) * 100}%)`;
        });
    }

    rightArrow.addEventListener("click", function() {
        currentIndex = (currentIndex + 1) % totalSlides;
        showSlide(currentIndex);
    });

    leftArrow.addEventListener("click", function() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        showSlide(currentIndex);
    });

    // Initialize the first slide
    showSlide(currentIndex);
});
