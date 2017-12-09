$(document).ready(function () {
    $(document).on('click', '#addAttribute', function (event) {
        event.preventDefault();
        get_form({
            type: 'create',
            url: 'attribute'
        });
    });

    $(document).on('click', '#save', function (event) {
        event.preventDefault();
        var data = {};
        $('input[name]').each(function (index, value) {
            data[$(value).attr('name')] = $(value).val();
        });
        create({
            url: 'attribute',
            data: data
        });
    });

    $(document).on('click', '.delete', function () {
        var id = $(this).attr('data-id');
        del({
            url: 'attribute',
            id: id
        });
    });

    $(document).on('click', '.edit', function () {
        var id = $(this).attr('data-id');
        get_form({
            url: 'attribute',
            type: 'update',
            data: {
                id:id
            }
        });
    });

    $(document).on('click', '#update', function (event) {
        event.preventDefault();
        var id = $(this).attr('data-id');
        var data = {};
        $('.field').each(function () {
            data[$(this).attr('name')] = $(this).val();
        });

        update({
            url: 'attribute',
            id: id,
            data: data
        });
    });
});
