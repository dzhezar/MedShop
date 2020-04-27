$(document).ready(function () {
    $('.menuOpen').on('click',function () {
        $('body').toggleClass('hidden');
    });

    $('.cart-trigger').on('click',function () {
        let cart_wrapper = $('.cart-wrapper');
        cart_wrapper.css('display','flex');
        cart_wrapper.animate({opacity: 1}, 300);
        $('.cart-wrapper .cart').animate({  textIndent: 0 /* или любое другое не очень-то нужное здесь свойство */ }, {
            step: function(now, fx) {
                $(this).css('transform','translateX(0)');
            },
            duration: 'slow'
        }, 'ease-in');
        $()
        if ($('#menuToggle')[0].checked === false) {
            $('body').toggleClass('hidden');
        }
    })
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
