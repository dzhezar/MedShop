$(document).ready(function () {
    $(document).on('click', '.place_order', function () {
        alert('preloader');
        $.ajax({
            method: 'POST',
            url: "/api/checkout",
            data: $('form#checkout').serialize(),
            dataType: "json",
            success: function(data) {
                window.location.href='/paypal/pay/'+data.hash;
            },
            error: function (jqXHR) {
                $('.form-error').remove();
                let data = JSON.parse(jqXHR.responseText);
                if(jqXHR.status === 422) {
                    Object.keys(data).forEach(function (item) {
                        let input = $(`input[name=${item}]`);
                        input.after($(`<span class="form-error">${data[item]}</span>`));
                    });
                }
            }
        });
    })

    // let delays = '';
    // $(document).on('keyup', '.search', function () {
    //     clearTimeout(delays);
    //     let elem = $(this);
    //     delays = setTimeout(function () {
    //         let type = elem.attr('data-type');
    //         let value = elem.val();
    //         let arr = {};
    //         arr[type] = value;
    //         if(value.length >= 2) {
    //             $.ajax({
    //                 method: 'POST',
    //                 url: "/api/search",
    //                 data: JSON.stringify(arr),
    //                 dataType: "json"
    //             }).done(function(data) {
    //                 let ul = $('<ul class="search-results"></ul>');
    //                 let found = data.length > 0;
    //                 data.forEach(function (item) {
    //                     if(item.display_name.includes('United States')) {
    //                         ul.append(`<li style="cursor: pointer" class="choose-result">${item.display_name}</li>`);
    //                     }
    //                 });
    //
    //                 elem.parent().find('.search-results').remove();
    //
    //                 if(!found) {
    //                     ul.append(`<li>No results found</li>`);
    //                 }
    //
    //                 elem.parent().append(ul);
    //
    //             });
    //         }
    //     },500);
    // });
    //
    // $(document).on('focusout', '.search', function () {
    //     setTimeout(function () {
    //         $(this).parent().find('.search-results').remove();
    //
    //     }, 100);
    // })
    //
    // $(document).on('click', '.choose-result', function () {
    //     let text = $(this).text();
    //     $(this).parent().parent().find('input').val(text);
    //     $(this).parent().remove();
    // });

    function initPaypal() {
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '0.01'
                        },
                    }]
                });
            },
            onApprove: function(data) {
                console.log(data);
                return fetch('/api/paypal/callback', {
                    method: 'post',
                    headers: {
                        'content-type': 'application/json'
                    },
                    body: JSON.stringify({
                        orderID: data.orderID
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(details) {
                    alert('Authorization created for ' + details.payer_given_name);
                });
            }
        }).render('#paypal-button-container');
    }
});