$(document).ready(function () {
    $('.info span').on('click', function () {
        $(this).toggleClass('rotate');
        console.log($(this).parent().parent().parent().children('.status').fadeToggle());
        $(this).parent().parent().parent().parent().children('.body_wrapper').slideToggle();
    })
});
