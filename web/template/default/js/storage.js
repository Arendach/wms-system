$(document).ready(function () {

    /**
     * Запрошуємо форму для створення складу
     */

    $(document).on('click', '#add', function () {
        get_form({
            type: 'create',
            url: 'storage',
            summernote: true
        });
    });

    /**
     * Запрошуємо форму для оновлення складу
     */
    $(document).on('click', '.update', function (e) {
        var id = $(this).attr('data-id');
        get_form({
            type: 'update',
            data: {id: id},
            url: 'storage',
            summernote: true
        });
    });

    /**
     * Видаляємо склад
     */

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        del({
            url: 'storage',
            id: id
        });
    });

    /**
     * Створюємо новий склад
     */

    $(document).on('click', '#insert', function (event) {
        event.preventDefault();
        var data = {};
        $.each($('*[name]'), function (index, value) {
            data[$(value).attr('name')] = $(value).val();
        });
        create({
            url: 'storage',
            data: data
        });
    });

    /**
     * Оновлюємо дані про склад
     */

    $(document).on('click', '#save', function (event) {
        event.preventDefault();
        var data = {};
        var id = $('[name=id]').val();
        $.each($('*[name]'), function (index, value) {
            data[$(value).attr('name')] = $(value).val();
        });

        update({
            url: 'storage',
            data: data,
            id: id
        });
    });

});