function scrollToTop() {
    event.preventDefault();
    
    const scrollStep = window.scrollY / 12;

    function scrollToTopAnimation() {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        if (scrollTop > 0) {
            window.requestAnimationFrame(scrollToTopAnimation);
            window.scrollTo(0, scrollTop - scrollStep);
        }
    }

    scrollToTopAnimation();
}
