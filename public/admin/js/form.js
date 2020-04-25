$(document).ready(function () {
    $('label').each(function () {
        let text = $(this).attr('for');
        if (text.includes('RU')) {
            $(this).parent().prependTo($('#collapseOne').children());
        } else if (text.includes('EN')) {
            $(this).parent().prependTo($('#collapseTwo').children());
        }
    });

    $('select').select2();

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


    Object.keys(tooltips).forEach(function (key) {
        $("label[for='" + key + "']").not('.custom-file-label').after($('<i style="padding-left: 10px" data-toggle="tooltip" data-html="true" class="far fa-question-circle"></i>').attr('title', tooltips[key]));
    });

    $('[data-toggle="tooltip"]').tooltip();

    $('.enable-ckeditor').each(function () {
        let textarea = $(this);
        ClassicEditor.create(textarea[0], {language: 'ru'});
    });

    $('#preloader').hide();
});