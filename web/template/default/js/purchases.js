$(document).ready(function () {
    var $body = $('body');

    function search(data) {
        $.ajax({
            type: 'post',
            url: url('/purchases/search_products'),
            data: data,
            success: function (answer) {
                $('#place_for_search').html(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        })
    }

    function check_sum() {
        var sum = 0;
        $('.product').each(function () {
            sum += (+$(this).find('.amount').val() * +$(this).find('.price').val());
        });
        $('#sum').val(sum);
    }

    function not() {
        var not = [];
        $('.product').each(function () {
            not.push($(this).data('id'));
        });
        return not;
    }

    function close_purchase() {
        $.ajax({
            type: 'post',
            url: url('/purchases/close_form'),
            data: {
                id: id
            },
            success: function (answer) {
                $('#modal').html(answer);
                myModalOpen();
            },
            error: function (answer) {
                errorHandler(answer);
            }
        })
    }

    $body.on('change', '#manufacturer', function () {
        redirect('/purchases/create?manufacturer=' + $(this).val());
    });

    $body.on('click', '[data-name=id]', function () {
        var $tr = $(this).parents('tr');

        if ($tr.hasClass('active-row'))
            $tr.removeClass('active-row');
        else
            $tr.addClass('active-row');
    });

    $body.on('click', '#update', function () {
        var data = {};
        data.products = [];
        data.sum = $('#sum').val();
        data.comment = $('#comment').val();

        $('.product').each(function () {
            var object = {};
            object.id = $(this).data('id');
            object.amount = $(this).find('.amount').val();
            object.price = $(this).find('.price').val();
            data.products.push(object);
        });

        update({
            url: 'purchases',
            data: data,
            id: id
        });
    });

    $body.on('change', '#status', function () {
        $(this).val() == 1 ? $('#prepayment_container').show() : $('#prepayment_container').hide();
    });

    $body.on('click', '#update_info', function () {
        var $prepayment = $('#prepayment').val(),
            $status = $('#status').val(),
            $type = $('#type').val();

        if ($status == 2 && $type == 1) {
            close_purchase();
            return false;
        }

        $.ajax({
            type: 'post',
            url: url('/purchases/update_info'),
            data: {
                id: id,
                data: {
                    prepayment: $prepayment,
                    status: $status,
                    type: $type
                }
            },
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('click', '#create', function () {
        var data = {};
        data.products = [];
        data.manufacturer_id = manufacturer;
        data.sum = $('#sum').val();
        data.comment = $('#comment').val();

        $('.product').each(function () {
            var object = {};
            object.id = $(this).data('id');
            object.price = $(this).find('.price').val();
            object.amount = $(this).find('.amount').val();
            data.products.push(object);
        });

        create({
            url: 'purchases',
            data: data
        }, function () {
            redirect('/purchases');
        });
    });

    $body.on('click', '#close', function () {
        var data = {
            id: id,
            comment: $('#comment').val(),
            name_operation: $('#name_operation').val()
        };

        $.ajax({
            type: 'post',
            url: url('/purchases/close'),
            data: data,
            success: function (answer) {
                successHandler(answer, function () {
                    redirect('/purchases');
                });
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('click', '#filter', function () {
        var data = {};

        $('.filter').each(function () {
            data[$(this).data('column')] = $(this).val();
        });

        GET.setObject(data).unsetEmpty().go();
    });

    $body.on('change', '#categories_pr', function () {
        var id = $(this).val();

        search({
            manufacturer: manufacturer,
            field: 'category',
            data: id,
            not: not()
        });
    });

    $body.on('keyup', '#search_ser_code', function () {
        var data = $(this).val();

        if (data.length < 3) return false;

        search({
            manufacturer: manufacturer,
            field: 'service_code',
            data: data,
            not: not()
        });
    });

    $body.on('keyup', '#search_name', function () {
        var data = $(this).val();

        if (data.length < 3) return false;

        search({
            manufacturer: manufacturer,
            field: 'name',
            data: data,
            not: not()
        });
    });

    $body.on('click', '.product-item', function () {
        var $this = $(this);
        if ($this.hasClass('active-product')) {
            $this.removeClass('active-product');
        } else {
            $this.addClass('active-product');
        }
    });

    $body.on('click', '#select_products', function () {
        var products = [];
        $('.active-product').each(function () {
            products.push($(this).data('id'));
            $(this).remove();
        });

        $.ajax({
            type: 'post',
            url: url('/purchases/get_products'),
            data: {
                products: products
            },
            success: function (answer) {
                $('table tbody').prepend(answer);
                check_sum();
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('keyup', '.price, .amount', check_sum);

    $body.on('click', '.delete', function () {
        $(this).parents('tr').remove();
        check_sum();
    });
});