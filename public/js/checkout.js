$(document).ready(function () {
    console.log($('form#qq').serialize());

    $(document).on('keyup', '.search', function () {
        let type = $(this).attr('data-type');
        let value = $(this).val();
        let arr = {};
        arr[type] = value;
        if(value.length >= 2) {
            $.ajax({
                method: 'POST',
                url: "/api/search",
                data: JSON.stringify(arr),
                dataType: "json"
            }).done(function(data) {
                data.forEach(function (item) {
                    console.log(item.display_name);
                });
            });
        }
    });
});