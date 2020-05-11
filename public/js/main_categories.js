$(document).ready(function () {
    $('.arrow_right').on('click',function () {
        $(this).toggleClass('rotate');
        let qq = $(this).parent().parent().find('.subcategories_wrapper');
        qq.slideToggle();
        qq.css('display','flex');
    })
});
$.fn.animateRotate = function(angle, duration, easing, complete) {
    return this.each(function() {
        var $elem = $(this);

        $({deg: 0}).animate({deg: angle}, {
            duration: duration,
            easing: easing,
            step: function(now) {
                $elem.css({
                    transform: 'rotate(' + now + 'deg)'
                });
            },
            complete: complete || $.noop
        });
    });
};

