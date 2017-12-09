$(document).ready(function () {
    button = $('#image_upload');
    new AjaxUpload(button, {
        action: main_siteUrl + 'products/upload_image',
        name: 'image_upload',
        data: {
            id: id
        },
        onComplete: function (file, a) {
            try {
                var answer = JSON.parse(a);
                if (answer.status == '1') {
                    $('.thumbnail_img').append(
                        '<div class="img_wrap">' +
                        '<img src="' + answer.url + '" class="img-thumbnail" height="200px">' +
                        '<span data-path="' + answer.url + '" class="deleteImg">X</span>' +
                        '</div>');
                    swal({
                        title: "Виконано",
                        type: "success",
                        text: answer.message
                    });
                } else {
                    swal({
                        title: "Помилка",
                        type: "error",
                        text: answer.message
                    });
                }
            } catch (err) {
                swal({
                    title: "Невідома помилка!",
                    type: "error"
                });
            }
        }
    });

    $(document).on('click', '.delete_image', function () {
        var src = $(this).attr('data-src');
        var me = $(this).parent();

        swal({
            title: "Дійсно видалити?",
            text: "Відмінити дію буде неможливо!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Видалити!",
            closeOnConfirm: false,
            html: false
        }, function () {
            $.ajax({
                type: 'post',
                url: main_siteUrl + 'delete_temp_file',
                data: {
                    path: src
                },
                success: function (a) {
                    try {
                        var answer = JSON.parse(a);
                        if (answer.status == '1') {
                            swal({
                                title: "Виконано",
                                type: "success",
                                text: answer.message
                            });
                            me.remove();
                        } else {
                            swal({
                                title: "Помилка",
                                type: "error",
                                text: answer.message
                            });
                        }
                    } catch (err) {
                        swal({
                            title: "Невідома помилка!",
                            type: "error"
                        });
                    }
                }
            });
        });
    });

    $(document).on('click', '#update-attribute', function (event) {
        event.preventDefault();
        var attribute = {};

        $('input.attribute').each(function () {
            var name = $(this).attr('data-name');
            if (Array.isArray(attribute[name])) {
                attribute[name].push($(this).val());
            } else {
                attribute[name] = [];
                attribute[name].push($(this).val());
            }
        });

        $.ajax({
           type: 'post',
           url: main_siteUrl + 'products/update',
           data: {
               id: id,
               method: 'attribute',
               data: attribute
           },
            success: function (answer) {
                try {
                    var response = JSON.parse(answer);
                    swal({
                        type: 'success',
                        text: response.message,
                        title: 'Виконано!'
                    });
                }catch (err) {
                    swal({
                        type: 'error',
                        text: 'Невідома помилка!',
                        title: 'Помилка!'
                    });
                }
            },
            error: function (answer) {
                try{
                    var response = JSON.parse(answer.responseText);
                    swal({
                        type: 'error',
                        text: response.message,
                        title: 'Помилка!'
                    });
                } catch (err) {
                    swal({
                        type: 'error',
                        text: 'Невідома помилка!',
                        title: 'Помилка!'
                    });
                }
            }
        });
    });

    $(document).on('click', '#update-type', function (event) {
        event.preventDefault();
        var combine = [];
        var me = $('#typeProduct').val();
        var costs = $('[name=costs]').val();
        costs = parseFloat(costs);

        if (me == 'combine') {
            $('.combine-items').each(function () {
                var combine_object = {};
                var id = $(this).attr('id');
                $('#' + id + ' .combine-field').each(function () {
                    combine_object[$(this).attr('data-type')] = $(this).val();
                });
                combine.push(combine_object);
            });
        }

        $.ajax({
           type: 'post',
           url: main_siteUrl + 'products/update',
           data: {
               id: id,
               method: 'type',
               data: {
                   type: me,
                   array: combine,
                   costs: costs
               }
           },
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $(document).on('click', '#update-info', function (event) {
        event.preventDefault();
        var data = {};
        $('.field').each(function () {
            data[$(this).attr('name')] = $(this).val();
        });

        data.volume = [];
        $('.volume-field').each(function () {
            data.volume.push($(this).val());
        });

        $.ajax({
            type: 'post',
            url: main_siteUrl + 'products/update',
            data: {
                method: 'info',
                id: id,
                data: data
            },
            success: function (answer) {
                try {
                    var response = JSON.parse(answer);
                    swal({
                        type: 'success',
                        text: response.message,
                        title: 'Виконано!'
                    });
                }catch (err) {
                    swal({
                        type: 'error',
                        text: 'Невідома помилка!',
                        title: 'Помилка!'
                    });
                }
            },
            error: function (answer) {
                try{
                    var response = JSON.parse(answer.responseText);
                    swal({
                        type: 'error',
                        text: response.message,
                        title: 'Помилка!'
                    });
                } catch (err) {
                    swal({
                        type: 'error',
                        text: 'Невідома помилка!',
                        title: 'Помилка!'
                    });
                }
            }
        });
    });
});
