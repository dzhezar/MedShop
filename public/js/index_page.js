$(document).ready(function () {
    //initialize swiper when document ready
    var swiper = new Swiper('.swiper-container', {
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
        preloadImages: false,
        // Enable lazy loading
        lazy: {
            loadPrevNext: true,
        },
    });
    $('.lazy').Lazy();
    $('.menuOpen').on('click',function () {
        $('body').toggleClass('hidden');
    });
});
