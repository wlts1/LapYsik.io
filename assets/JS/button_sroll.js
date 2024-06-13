document.addEventListener("DOMContentLoaded", function () {
    const backToTopButton = document.getElementById('backToTop');

    window.onscroll = function () {
        if (window.scrollY > 200) {
            backToTopButton.classList.add('show');
        } else {
            backToTopButton.classList.remove('show');
        }
    };

    backToTopButton.onclick = function () {
        window.scrollTo({top: 0, behavior: 'smooth'});
    };
});
