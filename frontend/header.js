// header.js
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
