// testimonials_slider.js
document.addEventListener('DOMContentLoaded', function() {
    let slides = document.querySelectorAll(".testimonials-slide");
    let index = 0;

    function nextSlide() {
        slides[index].classList.remove("active");
        index = (index + 1) % slides.length;
        slides[index].classList.add("active");
    }

    function prevSlide() {
        slides[index].classList.remove("active");
        index = (index - 1 + slides.length) % slides.length;
        slides[index].classList.add("active");
    }

    // Add event listeners to your next and previous buttons if you have them
    document.querySelector('.next-slide').addEventListener('click', nextSlide);
    document.querySelector('.prev-slide').addEventListener('click', prevSlide);
});
