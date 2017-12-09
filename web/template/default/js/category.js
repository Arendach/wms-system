$(function () {
    $(".get_form").click(function () {
        var form = $(this).attr('data-form');
        if (form == 'update')
            var id = $(this).attr('data-id');
        else
            var id = false;
        $.ajax({
            type: 'post',
            data: {
                form: form,
                id: id
            },
            url: main_siteUrl + 'category/get_form',
            success: function (response) {
                $('#modal').html(response);
                myModalOpen();
            }
        });
    });

    $(document).on('click', '.send', function (event) {
        var form = $(this).attr('id')
        handler(event, form)
    });

    function handler(event, form) {
        event.preventDefault()
        var data = {};

        $('form .field').each(function () {
            var t = $(this);
            var name = t.attr('name');
            var value = t.val();
            data[name] = value;
        });
        $.ajax({
            type: 'post',
            url: main_siteUrl + 'category/' + form,
            data: data,
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    }

    $('.delete').click(function (event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        swal({
                title: "Видалити?",
                text: "Дану дію відмінити буде неможливо",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Так, я хочу видалити",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    type: 'post',
                    url: main_siteUrl + 'category/delete',
                    data: {
                        id: id
                    },
                    success: function (answer) {
                        successHandler(answer);
                    },
                    error: function (answer) {
                        errorHandler(answer);
                    }
                });
            });
    });

    $('#deleteSelected').click(function () {

        var selected = [];

        $('.delSelected:checked').each(function () {
            selected.push($(this).val());
        });

        if (selected.length < 1) {
            swal({
                text: 'Не відмічено категорії, які необхідно видалити!',
                type: 'error',
                title: 'Помилка!'
            });            return false;
        }

        swal({
                title: "Видалити?",
                text: "Дану дію відмінити буде неможливо",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Так, я хочу видалити",
                closeOnConfirm: false
            },
            function () {
                $.ajax({
                    url: main_siteUrl + 'category/deleteSelected',
                    method: "POST",
                    data: {ids: selected},
                    dataType: "html",
                    success: function (answer) {
                        successHandler(answer);
                    },
                    error: function (answer) {
                       successHandler(answer);
                    }
                });
            });
    });
});