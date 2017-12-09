$(document).ready(function () {

    var $body = $('body');

    $body.on('click', '#create', function (event) {
        event.preventDefault();
        var data = {};
        var images = [];
        var combine = [];
        var attribute = {};

        $('[data-type=field]').each(function () {
            var $this = $(this);
            data[$this.attr('name')] = $this.val();
        });

        $('.img-thumbnail').each(function () {
            images.push($(this).attr('src'));
        });

        if (data.type_product === 'combine') {
            $('.combine-items').each(function () {
                var combine_object = {};
                var id = $(this).attr('id');
                $('#' + id + ' .combine-field').each(function () {
                    combine_object[$(this).attr('data-type')] = $(this).val();
                });
                combine.push(combine_object);
            });
        }

        $('input.attribute').each(function () {
            var name = $(this).attr('data-name');
            if (Array.isArray(attribute[name])) {
                attribute[name].push($(this).val());
            } else {
                attribute[name] = [];
                attribute[name].push($(this).val());
            }
        });

        data.volume = [];
        $('.volume-field').each(function () {
            data.volume.push($(this).val());
        });

        $.ajax({
            type: 'post',
            url: main_siteUrl + 'products/save',
            data: {
                data: data,
                images: images,
                combine: combine,
                attribute: attribute
            },
            success: function () {
                swal({
                    type: 'success',
                    title: 'Виконано!',
                    text: 'Товар вдало створено!',
                    closeOnConfirm: false
                }, function () {
                    window.location.href = main_siteUrl + 'products'
                });
            },
            error: function (answer) {
                errorHandler(answer);
            }
        })
    });

    /**
     * @type {*|jQuery|HTMLElement}
     */
    button = $('#image_upload');
    new AjaxUpload(button, {
        action: main_siteUrl + 'products/new_upload_image',
        name: 'image_upload',
        onComplete: function (file, a) {
            try {
                var answer = JSON.parse(a);
                if (answer.status == '1') {
                    $('.thumbnail_img').append(
                        '<div class="img_wrap">' +
                        '<img src="' + answer.url + '" class="img-thumbnail" height="200px">' +
                        '<span data-path="' + answer.url + '" class="deleteImg">X</span>' +
                        '</div>');
                }
            } catch (err) {

            }
        }
    });

    /**
     *
     */
    $body.on('click', '.deleteImg', function () {
        var path = $(this).attr('data-path');
        var me = $(this);
        $.ajax({
            type: 'post',
            url: main_siteUrl + 'delete_temp_file',
            data: {
                path: path
            },
            success: function (a) {
                try {
                    var answer = JSON.parse(a);
                    if (answer.status == '1') {
                        me.parent().remove();
                        miniPopUp('success');
                    } else {
                        miniPopUp('error');
                    }
                    closeMiniPopUp();
                } catch (err) {
                    errorHandler(answer);
                }
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    /**
     *
     */
    $body.on('change', '#product_category', function () {
        var $this = $(this);

        $.ajax({
            type: 'post',
            url: url('/products/get_service_code'),
            data: {
                id: $this.val()
            },
            success: function (answer) {
                var response = JSON.parse(answer);
                $('#services_code').val(response.message);
                $('#services_code_container').show();
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });


});