$(document).ready(function () {
    var $body = $('body');

    $body.on('click', '#update', function (event) {
        event.preventDefault();
        var data = {};
        $('.field').each(function () {
            data[$(this).attr('id')] = $(this).val();
        });

        update({
            url: 'manager',
            id: id,
            data: data
        });
    });

    $body.on('click', '#update_password', function (event) {
        event.preventDefault();

        $.ajax({
            type: 'post',
            url: url('/manager/update_password'),
            id: id,
            data: {
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val(),
                id: id
            },
            success: function (answer) {
                successHandler(answer, true);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('click', '#register', function (event) {
        event.preventDefault();
        var data = {};
        $('.field').each(function () {
            data[$(this).attr('id')] = $(this).val();
        });

        create({
            url: 'managers',
            data: data
        }, function (answer) {
            successHandler(answer, function () {
                redirect(route('managers'));
            })
        });
    });
});