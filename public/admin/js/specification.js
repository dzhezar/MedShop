$(document).ready(function () {
    $(document).on('click', '#save_specification', function () {
        let english = $('#specification_add_en').val();
        let russian = $('#specification_add_ru').val();

        if (english === '' || russian === '') {
            alert('Заполните пустые поля');
        } else {
            $.ajax({
                url: "/api/specification/create",
                method: "POST",
                data: {
                    english: english,
                    russian: russian
                }
            }).done(function (specification) {
                alert('Сохранено');
                $('#specification_add_en').val('');
                $('#specification_add_ru').val('');
                $('.specification-select').each(function () {
                    $(this).append($("<option value='" + specification.id + "'>" + specification.name + "</option>"));
                })
            });
        }
    });

    $(document).on('click', '.add-specification-row', function () {
        let row = $('.specification-row:last').clone();
        row.find('input').each(function () {
            $(this).val('');
        });
        row.find('.select2').remove();
        $('#specification-rows').append(row);
        $(this).removeClass('add-specification-row').addClass('remove-specification-row').text('Удалить характеристику');
        $('select').select2();
    });

    $(document).on('click', '.remove-specification-row', function () {
        $(this).parent().parent().remove();
    });

    $(document).on('click', '#product_form_submit', function () {
        let storage = $('#product_form_specifications');
        let array = [];
        $('.specification-row').each(function () {
            let specif = $(this).find($('.specification-select')).val();
            let en = $(this).find('.english-value').val();
            let ru = $(this).find('.russian-value').val();

            let json = {
                specif: specif,
                en: en,
                ru: ru
            };

            array.push(json);
        });

        storage.val(JSON.stringify(array));
    })
});