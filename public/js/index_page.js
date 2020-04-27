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
    $('.lazy').Lazy();
    $('.menuOpen').on('click',function () {
        $('body').toggleClass('hidden');
    });

    $(document).on('click', '.add_to_cart', function () {
        let this_elem = $(this);
        let id = this_elem.attr('data-id');
        $.ajax({
            method: 'POST',
            url: "/api/cart/add",
            data: {
                id: id
            }
        }).done(function() {
            this_elem.addClass('active');
            $('.cart-trigger').click();
        });
    })
});
