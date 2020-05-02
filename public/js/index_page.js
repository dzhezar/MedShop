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
    $('.cart-trigger').on('click',function () {
        swiper.allowTouchMove = false;
        swiper.update();
    })
    $('header .cart-wrapper .cart .back_to_shopping, .shadow-filter').on('click', function () {
        swiper.allowTouchMove = true;
        swiper.update();
    })
});
