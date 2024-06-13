var headerLine = document.getElementById('header_line');

function getScrollPosition() {
    return window.pageYOffset || document.documentElement.scrollTop;
}

function checkScrollPosition() {
    if (getScrollPosition() > 0) {
        headerLine.classList.add('scrolled');
    } else {
        headerLine.classList.remove('scrolled');
    }
}

window.addEventListener('scroll', checkScrollPosition);

checkScrollPosition();
