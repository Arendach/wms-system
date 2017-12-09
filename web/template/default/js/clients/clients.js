$(document).ready(function () {
    var $body = $('body');

    $body.on('click', '.edit', function () {
        var id = $(this).attr('data-toggle');
        get_form({
            url: 'clients',
            data: {id: id},
            type: 'edit',
            summernote: true
        });
    });


    $body.on('click', '#edit_client', function (event) {
        event.preventDefault();
        var data = $('form').serializeJSON();
        update({
            id: id,
            data: data,
            url: 'clients'
        })
    });

    $body.on('click', '#create_form', function () {
        get_form({
            type: 'create',
            url: 'clients',
            summernote: true
        });
    });

    $body.on('click', '#create_client', function (event) {
        event.preventDefault();
        $.ajax({
            type: 'post',
            url: main_siteUrl + 'clients/create',
            data: $('form').serializeJSON(),
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                answerHandler(answer);
            }
        });
    });

    $body.on('click', '.delete', function () {
        var id = $(this).attr('data-toggle');
        del({
            id: id,
            url: 'clients'
        });
        return false;
    });
});