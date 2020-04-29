$(document).ready(function () {
    $('.menuOpen').on('click',function () {
        $('body').toggleClass('hidden');
    });

    $('header .cart-wrapper .cart .back_to_shopping, .shadow-filter').on('click', function () {
        let cart_wrapper = $('.cart-wrapper');
        cart_wrapper.animate({opacity: 0}, 300);
        function qq() {
            cart_wrapper.hide();
        }
        setTimeout(qq, 400)


        if ($('#menuToggle')[0].checked === false) {
            $('body').toggleClass('hidden');
        }
    })
    $('.plus, .minus').on('mousedown', function () {
        $(this).addClass('clicked');
        $(this).on('mouseup', function () {
            $(this).removeClass('clicked')
        })
    })
});
