$(document).ready(function () {

    /**
     * Получаємо форму для створення групи
     */

    $(document).on('click', '#add', function () {
        $.ajax({
            type: "post",
            url: main_siteUrl + "manufacture_groups/get_form",
            data: {
                form: 'create'
            },
            dataType: "html",
            success: function (a) {
                $('#modal').html(a);
                myModalOpen();
            }
        });
    });

    /**
     * Створюмо групу
     */

    $(document).on('click', '#insert', function (event) {
        event.preventDefault();
        var data = {};

        $.each($('*[name]'), function (index, value) {
            data[$(value).attr('name')] = $(value).val();
        });

        $.ajax({
            type: "post",
            url: main_siteUrl + "manufacture_groups/create",
            data: data,
            dataType: "html",
            success: function (a) {
                rHandler(a);
            }
        });
    });

    /**
     * Видаляємо позначені групи
     */

    $(document).on('click', '#deleteSelected', function () {
        var selected = [];
        $('.delSelected:checked').each(function () {
            selected.push($(this).val());
        });

        if (selected.length < 1) {
            swal({
                text: 'Не відмічено категорії, які необхідно видалити!',
                type: 'error',
                title: 'Помилка!'
            });
            return false;
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
                    type: "post",
                    url: main_siteUrl + "manufacture_groups/delete",
                    data: {
                        id: selected
                    },
                    dataType: "html",

                    success: function (a) {
                        rHandler(a);
                    }
                });
            });
    });

    /**
     * Видаляємо групу
     */

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
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
                    type: "post",
                    url: main_siteUrl + "manufacture_groups/delete",
                    data: {
                        id: id
                    },
                    dataType: "html",
                    success: function (a) {
                        rHandler(a);
                    }
                });
            });
    });

    /**
     * Получаємо форму для оновлення
     */

    $(document).on('click', '.update', function (e) {
        var id = $(this).attr('data-id');
        $.ajax({
            type: "post",
            url: main_siteUrl + "manufacture_groups/get_form",
            data: {
                form: 'update',
                id: id
            },
            dataType: "html",
            success: function (a) {
                $('#modal').html(a);
                myModalOpen();
            }
        });
    });

    /**
     * Зберігаємо оновлені дані
     */

    $(document).on('click', '#save', function (event) {
        event.preventDefault();
        var data = {};
        $.each($('*[name]'), function (index, value) {
            data[$(value).attr('name')] = $(value).val();
        });

        $.ajax({
            type: "post",
            url: main_siteUrl + "manufacture_groups/update",
            data: data,
            dataType: "html",
            success: function (a) {
                rHandler(a);
            }
        });
    });
})
;