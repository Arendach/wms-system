$(document).ready(function () {

    /**
     * Функція відсилає на сервер відредаговані дані
     */

    $(document).on('click', '.send', function (event) {
        event.preventDefault();
        var data = {};
        $('form input').each(function () {
            data[$(this).attr('name')] = $(this).val();
        });
        update({
            url: 'orders/settings',
            id: data.id,
            data: data
        });
    });

    /**
     * Функція відсилає на сервер нові дані
     */

    $(document).on('click', '.save', function (event) {
        event.preventDefault();
        var data = {};

        $('.form-create input').each(function () {
            data[$(this).attr('name')] = $(this).val();
        });

        create({
            url: 'orders/settings',
            data: data
        });
    });

    /**
     * Функція видаляє пункт
     */

    $(document).on('click', '.remove', function (event) {
        event.preventDefault();
        del({
            url: 'orders/settings',
            id: $(this).attr('data-id'),
            data: {
                form: $(this).attr('data-form')
            }
        });
    });

    /**
     * Функція повертає форму для редагування даних
     */

    $(document).on('click', '.edit', function (event) {
        event.preventDefault();
        get_form({
            url: 'orders/settings',
            type: $(this).attr('data-form'),
            data: {
                id: $(this).attr('data-id')
            }
        });
    });
});