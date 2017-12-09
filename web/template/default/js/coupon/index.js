$(document).ready(function () {
    var $body = $('body');

    /**
     *
     */
    $body.on('click', '.edit', function (event) {
        event.preventDefault();
        var $this = $(this);
        var id = $this.attr('data-id');
        get_form({
            url: 'coupon',
            type: 'edit',
            data: {
                id: id
            }
        });
    });

    /**
     *
     */
    $body.on('click', '.delete', function (event) {
        event.preventDefault();
        var $this = $(this);
        var id = $this.attr('data-id');
        del({
            url: 'coupons',
            id: id
        });
    });

    /**
     *
     */
    $body.on('click', '.create', function (event) {
        event.preventDefault();
        get_form({
            url: 'coupon',
            type: 'create'
        });
    });

    /**
     *
     */
    $body.on('change', '#type_coupon', function (event) {
        event.preventDefault();

        var form = $(this).val() === '1' ? 'cumulative' : 'stationary';

        $.ajax({
            type: 'post',
            url: main_siteUrl + 'coupon/get_form',
            data: {
                form: form
            },
            success: function (a) {
                $('#for-form').html(a);
            }

        });
    });

    $body.on('click', '#update', function (event) {
        event.preventDefault();
        var type = $('#type').val();
        var data = {};
        $('.field').each(function () {
            data[$(this).attr('id')] = $(this).val();
        });

        if (type == 0) {
            data.type = 'stationary';
        } else {
            data.type = 'cumulative';
            data.cumulative = [];
            $('.rows').each(function () {
                var id = $(this).attr('id');
                var obj = {};
                $('#' + id + ' .cumulative').each(function () {
                    obj[$(this).attr('name')] = $(this).val();
                });
                data.cumulative.push(obj);
            });
        }
        update({
            url: 'coupons',
            data: data,
            id: $('#id').val()
        });
    });

    $body.on('mouseenter', '[data-toggle="tooltip"]', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    $body.on('click', '#create', function (event) {
        event.preventDefault();
        var $type = $('#type_coupon');
        var data = {};
        $('.field').each(function () {
            data[$(this).attr('id')] = $(this).val();
        });
        if ($type.val() == '') {
            swal({
                type: 'error',
                text: 'Виберіть тип купона!',
                title: 'Помилка!'
            });
            return false;
        } else if ($type.val() == 1) {
            data.cumulative = [];
            $('.rows').each(function () {
                var id = $(this).attr('id');
                var obj = {};
                $('#' + id + ' .field2').each(function () {
                    obj[$(this).attr('name')] = $(this).val();
                });
                data.cumulative.push(obj);
            });
        }
        create({
            url: 'coupons',
            data: data
        });
    });

    /**
     *
     */
    $body.on('click', '.plus', function (event) {
        event.preventDefault();
        var $last_child = $('#asd > tbody > tr:last-child');
        if ($last_child.attr('id') !== undefined) {
            var id = 'row' + (+str_to_int($last_child.attr('id')) + 1);
        } else {
            var id = 'row1';
        }

        $('#asd > tbody').append(' <tr class="rows" id="' + id + '">' +
            '            <td><input class="field2" name="sum"></td>' +
            '            <td>' +
            '                <select name="operator" class="field2">' +
            '                    <option value="0"><</option>' +
            '                    <option value="1">=</option>' +
            '                    <option value="2">></option>' +
            '                </select>' +
            '            </td>' +
            '            <td>' +
            '                <input class="field2" name="discount">' +
            '            </td>' +
            '            <td>' +
            '                <select class="field2" name="type">' +
            '                    <option value="0">%</option>' +
            '                    <option value="1">грн</option>' +
            '                </select>' +
            '            </td>' +
            '            <td>' +
            '                <button class="del_row btn btn-danger btn-xs del">' +
            '                    <span class="glyphicon glyphicon-remove"></span>' +
            '                </button>' +
            '            </td>' +
            '        </tr>');
    });

    /**
     *
     */
    $body.on('click', '#delete', function (event) {
        event.preventDefault();
        var array = [];
        $('.select_coupons:checked').each(function () {
            array.push($(this).val());
        });
        del({
            url: 'coupons',
            id: array
        });
    });

    $body.on('click', '.del_row', function (event) {
        event.preventDefault();
        var $parent = $(this).parents('.rows');
        $parent.remove();
    });
});
