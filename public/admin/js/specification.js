$(document).ready(function () {
    $(document).on('click', '#save_specification', function () {
        let english = $('#specification_add_en').val();
        let russian = $('#specification_add_ru').val();

        if(english === '' || russian === '') {
            alert('Заполните пустые поля');
        } else {
            $.ajax({
                url: "/api/specification/create",
                method: "POST",
                data: {
                    english: english,
                    russian: russian
                }
            }).done(function(specification) {
                console.log(specification);
                alert('Сохранено');
                $('#specification_add_en').val('');
                $('#specification_add_ru').val('');
            });
        }
    });
});