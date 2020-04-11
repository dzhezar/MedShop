$(document).ready(function () {
    $('label').each(function () {
        let text = $(this).attr('for');
        if (text.includes('RU')) {
            $(this).parent().appendTo($('#collapseOne').children());
        } else if (text.includes('EN')) {
            $(this).parent().appendTo($('#collapseTwo').children());
        }
    });

    $('.form-group').each(function () {
        let move = true;
        $(this).find('button').each(function () {
            if (($(this).attr('type') === 'submit')) {
                move = false;
            }
        });
        if (move) {
            $(this).prependTo($(this).parent());
        }
    });

    $('.enable-ckeditor').each(function () {
        let textarea = $(this);
        ClassicEditor.create(textarea[0], {language: 'ru'});
    });
});