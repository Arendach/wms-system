$(document).ready(function () {

    var $body = $('body');

    function check_price() {
        var sum = 0;
        $('.product').each(function () {
            var el = '[data-id=' + $(this).attr('data-id') + '] ';
            var amount = $(el + '.el_amount').val();
            var price = $(el + '.el_price').val();
            $(el + '.el_sum').val(+amount * +price);
            $(el + '.remained').html((+$(el + '.count_on_storage').val() + +$(el + '.amount_in_order').val()) - +amount);
            sum += (+amount * +price);
        });

        $('#sum').val(sum);
        $('#full_sum').val(+sum - +$('#discount').val() + +$('#delivery_cost').val());
    }

    $body.on('keyup', '.count', check_price);

    $body.on('click', '.but', function () {
        $('.new_product_block').toggleClass('none');
    });

    $body.on('click', '#save_price', function (event) {
        event.preventDefault();

        var data = {};
        data.products = [];
        data.data = {};
        $('#list_products .product').each(function () {
            var object = {};
            var $this = $(this);
            object['id'] = $this.data('id');
            object['pto'] = $this.data('pto');
            object.attributes = {};
            $this.find('.product_field').each(function () {
               object[$(this).attr('name')] = $(this).val();
            });
            $this.find('.attributes select').each(function () {
                var key = $(this).attr('data-key');
                object.attributes[key] = $(this).find(':selected').val();
            });
            data.products.push(object);
        });

        data.data.delivery_cost = $('#delivery_cost').val();
        data.data.discount = $('#discount').val();
        data.data.id = id;

        $.ajax({
            type: 'post',
            url: main_siteUrl + 'orders/update',
            data: {
                form: 'products',
                data: data
            },
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('click', '.drop_product', function (event) {
        event.preventDefault();

        var $this = $(this);

        if ($this.data('id') == 'remove') {
            $this.parents('tr').remove();
            check_price();
            return false;
        }

        swal({
                title: "Видалити?",
                text: "Дану дію відмінити буде неможливо!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Так, я хочу видалити",
                closeOnConfirm: false
            },
            function () {
                var data = {};
                data.pto = $this.parents('tr').data('pto');

                $.ajax({
                    type: 'post',
                    url: url('/orders/drop_product'),
                    data: data,
                    success: function (answer) {
                        successHandler(answer, true);
                        $this.parents('tr').remove();
                        check_price();
                    },
                    error: function (answer) {
                        errorHandler(answer);
                    }
                });
            });
    });

    $body.on('click', '#select_products', function () {
        var arr_products = $('select.products').val();
        var has_id = [];
        $.each($('#list_products tr.product'), function (index, value) {
            has_id.push($(value).data('id'));
        });
        $.ajax({
            url: url('/orders/get_product_by_id'),
            data: {
                products: arr_products,
                type: type
            },
            dataType: 'html',
            method: 'post',
            success: function (data) {
                $('#list_products tbody').append(data);
                $('#price').css('display', 'block');
            }
        });
    });

    if ($('.product').length > 0) {
        $('#price').css('display', 'block');
    }

});