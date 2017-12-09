$(document).ready(function () {

    var $body = $('body');

    $body.on('click', '#search', function () {
        var data = {};
        $('.search').each(function () {
            data[$(this).attr('id')] = $(this).val();
        });

        var str = '';

        for (var item in data) {
            if (data[item] != '')
                str += item + '=' + data[item] + '&';
        }

        location.href = '?' + str;
    });

    $body.on('click', '#export_xml', function () {
        var array = [];
        $('.order_check:checked').each(function () {
            array.push($(this).data('id'));
        });

        if (array.length == 0) {
            swal({
                type: 'error',
                title: 'Помилка!',
                text: 'Ви не позначили жодного замовлення для експотування!'
            });
            return false;
        }

        $.ajax({
            type: 'post',
            url: main_siteUrl + 'orders/export_xml',
            data: {
                ids: array
            },
            success: function (answer) {
                try {
                    var response = JSON.parse(answer);
                    if (response.status === '1') {
                        var link = '<a download href="' + response.file + '">Файл</a>';
                        swal({
                            type: 'success',
                            html: true,
                            title: 'Виконано!',
                            text: 'Ви можете скачати ' + link
                        });
                    }
                } catch (err) {
                    elog(err);
                }
            }
        });
    });

    $body.on('click', '#show_orders', function (event) {
        event.preventDefault();
        var type = $('#type').val();
        var url = route('orders', {type: type});
        var items = $('#items').val();
        if (items !== '')
            url += parameters({items: items});

        window.location.href = url;
    });

    $body.on('click', '.print_button', function () {
        var $this = $(this),
            $print = $($this.data('id'));
        $('.buttons:not(.buttons' + $this.data('id') + ')').hide();

        if ($print.css('display') == 'none')
            $print.show();
        else
            $print.hide();
    });

});