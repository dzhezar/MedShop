$(document).ready(function () {
    $('.menuOpen').on('click',function () {
        $('body').toggleClass('hidden');
    });
    $('.cart-trigger').on('click',function () {
        $('.cart-wrapper').css('display','flex');
        $('body').addClass('hidden');
    })
    $('header .cart-wrapper .cart .back_to_shopping, .shadow-filter').on('click', function () {
        $('.cart-wrapper').hide();
        $('body').removeClass('hidden');
    })
    $('.plus, .minus').on('mousedown', function () {
        $(this).addClass('clicked');
        $(this).on('mouseup', function () {
            $(this).removeClass('clicked')
        })
    })
});
