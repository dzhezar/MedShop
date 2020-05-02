$(document).ready(function () {
    $('.sidebar-link').each(function () {
        if(window.location.pathname.includes($(this).attr('href'))) {
            $(this).addClass('active');
        }
    })
});