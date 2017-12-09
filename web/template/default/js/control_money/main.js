$(document).ready(function () {
    /**
     * @type {*|jQuery|HTMLElement}
     */
    var $body = $('body');

    $body.on('click', '.item_update', function () {
        var id = $(this).data('id');

        get_form({
            url: 'control_money',
            type: 'update',
            data: {
                id: id
            }
        });
    });

    $body.on('click', '#create', function () {
        get_form({
            url: 'control_money',
            type: 'create',
            data: {
                id: id
            }
        })
    });
});