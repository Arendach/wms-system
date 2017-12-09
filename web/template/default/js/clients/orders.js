$(document).ready(function () {
    var $body = $('body');
    $body.on('click', '.remove', function () {
        var order = $(this).attr('data-id');
        var client = $('#client_id').val();

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
                    url: main_siteUrl + 'clients/order_remove',
                    data: {
                        order: order,
                        client: client
                    },
                    success: function (answer) {
                        successHandler(answer);
                    },
                    error: function (answer) {
                        errorHandler(answer)
                    }
                });
            });
    });
    $(document).on('click', '.get_form', get_form);
    $(document).on('click', '#search', search_order);
    $(document).on('click', '#save', save);

    function save(event) {
        event.preventDefault();
        var client = $('#client_id').val();
        var orders = [];
        $('.selected').each(function () {
            orders.push($(this).attr('data-id'));
        });

        $.ajax({
            type: 'post',
            url: main_siteUrl + 'clients/save_orders',
            data: {
                client: client,
                orders: orders
            },
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    }

    function get_form() {
        var form = $(this).attr('data-form');

        $.ajax({
            type: 'post',
            url: main_siteUrl + 'clients/get_form',
            data: {
                form: form
            },
            success: function (a) {
                $('#modal').html(a);
                myModalOpen();
            }
        });
    }

    function search_order(event) {
        event.preventDefault();
        var data = {};
        var client = $('#client_id').val();
        data['client'] = client;
        $('form .search').each(function () {
            if ($(this).val() != '')
                data[$(this).attr('name')] = $(this).val();
        });

        $.ajax({
            type: 'post',
            url: main_siteUrl + 'clients/search_order',
            data: data,
            success: function (a) {
                $('table .order_row').remove();
                if(a.length > 10) {
                    $('table tbody').append(a);
                    $('#save').css('display', 'block');
                } else {
                    $('#save').css('display', 'none');
                    $('table tbody').append('<tr class="order_row"><td colspan="5"><h4 class="centered">Не знайдено, або вже прикріплено! </h4></td></tr>');
                }
            }
        });
    }

    $(document).on('click', '.order_row', function () {
        $(this).toggleClass('selected');
    });

});
