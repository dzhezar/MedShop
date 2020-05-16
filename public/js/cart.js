$(document).ready(function () {
    function renderCart(toggle = true) {
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
        if ($('#menuToggle')[0].checked === false && toggle) {
            $('body').toggleClass('hidden');
        }
        $.ajax({
            method: 'POST',
            url: "/api/cart/all",
            data: {
                language: language
            }
        }).done(function(cart) {
            $('.cart_list').html('');
            cart.products.forEach(function (product) {
                let item = $(`<div class="item">
                    <img src="${product.image}">
                    <div class="info">
                        <a href="/${language}/product/${product.slug}" class="name">${product.title}</a>
                        <div class="price">
                            <div class="quantity" data-id="${product.id}">
                                <span class="minus">-</span><span class="number">${product.cartAmount}</span><span class="plus">+</span>
                            </div>
                            <div class="final_price">$${product.price}</div>
                        </div>
                        <div class="delete" data-id="${product.id}">✕</div>
                    </div>
                </div>`);
                $('.cart_list').append(item);
                $(`.controls[data-id="${product.id}"]`).children('.product-amount').text(product.cartAmount);
            });
            $('.total').children('span').text(`$${cart.total.toFixed(2)}`);
            $('.lds-dual-ring').hide();
        });
    }


    $('.cart-trigger').on('click',function () {
        renderCart();
    })


    $(document).on('click', '.plus', function () {
        let id = $(this).parent().attr('data-id');
        let toggle = $(this).hasClass('toggle');

        $.ajax({
            method: 'POST',
            url: "/api/cart/add",
            data: {
                id: id
            }
        }).done(function() {
            renderCart(toggle);
        });
    });

    $(document).on('click', '.minus', function () {
        let id = $(this).parent().attr('data-id');

        $.ajax({
            method: 'POST',
            url: "/api/cart/minus",
            data: {
                id: id
            }
        }).done(function(data) {
            renderCart(false);
            if(data.removed === true) {
                $(`.add_to_cart[data-id="${id}"]`).removeClass('active');
            }
        });
    });

    $(document).on('click', '.delete', function () {
        let id = $(this).attr('data-id');

        $.ajax({
            method: 'POST',
            url: "/api/cart/remove",
            data: {
                id: id
            }
        }).done(function() {
            renderCart(false);
            $(`.add_to_cart[data-id=${id}]`).removeClass('active');
        });
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
            if(this_elem.hasClass('open-cart')) {
                $('.cart-trigger').click();
            }
        });
    })
});
