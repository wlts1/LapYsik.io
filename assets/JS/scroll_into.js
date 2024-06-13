document.addEventListener("DOMContentLoaded", function () {
    const aboutShopButton = document.getElementById('aboutShopButton');
    const historyBlock = document.getElementById('history');
    const headerHeight = 100;

    aboutShopButton.addEventListener('click', function (event) {
        event.preventDefault();

        const yOffset = -50;
        const y = historyBlock.getBoundingClientRect().top + window.pageYOffset + yOffset - headerHeight;

        window.scrollTo({ top: y, behavior: 'smooth' });

        const scrollableContainer = document.querySelector('.history');
        const additionalOffset = 20;
        scrollableContainer.style.paddingTop = `${additionalOffset}px`;
    });
});
