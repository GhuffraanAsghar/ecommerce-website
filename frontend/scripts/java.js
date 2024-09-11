document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');

    function fixedNavbar() {
        header.classList.toggle('scrolled', window.pageYOffset > 0);
    }

    fixedNavbar(); // Call it once on load
    window.addEventListener('scroll', fixedNavbar);

    let menuBtn = document.querySelector('#menu-btn');
    let userBtn = document.querySelector('#user-btn');

    menuBtn.addEventListener('click', function() {
        const nav = document.querySelector('.navbar');
        nav.classList.toggle('active');
    });

    userBtn.addEventListener('click', function() {
        let userBox = document.querySelector('.user-box');
        userBox.classList.toggle('active');
    });

    // Close the user box if clicked outside
    document.addEventListener('click', function(event) {
        if (!userBtn.contains(event.target) && !document.querySelector('.user-box').contains(event.target)) {
            document.querySelector('.user-box').classList.remove('active');
        }
    });
});






/*-----------home section script----------*/
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


let slides =
  document.querySelectorAll(".testimonials-slide");
  let index = 0;

  function nextSlide(){
    slides[index].classList.remove("active");
    index = (index + 1) % slides.length;
    slides[index].classList.add("active");
  }
  function prevSlide(){
    slides[index].classList.remove("active");
    index = (index - 1 + slides.length) % slides.length;
    slides[index].classList.add("active");
  }
  