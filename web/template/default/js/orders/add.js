$(document).ready(function () {

    var $body = $('body');

    function check_form() {
        var success_form = true;
        $.each($('#form_order [required]'), function (index, value) {
            if (!$(value).val()) {
                $(value).focus();
                success_form = false;
                return false;
            }
        });
        return success_form;
    }

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

    function get_data() {
        var data = {};
        $('.field').each(function () {
            data[$(this).attr('id')] = $(this).val();
        });
        return data;
    }

    function get_products() {
        var data = [];
        $('.product').each(function () {
            var object = {};
            var $this = $(this);
            object['id'] = $this.data('id');
            object['amount'] = $this.find('.el_amount').val();
            object['price'] = $this.find('.el_price').val();
            object['place'] = $this.find('.place').val();
            var attributes = object['attributes'] = {};
            $this.find('.attributes select').each(function () {
                var $select = $(this);
                attributes[$select.data('key')] = $select.find(':selected').val();
            });
            data.push(object);
        });
        return data;
    }

    $body.on('keyup', '.count', check_price);

    $body.on('click', '[href="#products"]', check_form);

    $body.on('click', '#select_products', function () {
        var arr_products = $('select.products').val();
        $.ajax({
            url: main_siteUrl + 'orders/get_product_by_id',
            data: {products: arr_products, type: type},
            dataType: 'html',
            method: 'post',
            success: function (data) {
                $('#list_products tbody').append(data);
            }
        });
    });

    $body.on('click', '#create', function (event) {
        event.preventDefault();

        if (!check_form()) return false;

        var data = {};

        data.data = get_data();
        data.data.type = type;
        data.products = get_products();

        $.ajax({
            type: 'post',
            url: url('/orders/create'),
            data: data,
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });

        return false;
    });

    $body.on('click', '.drop_product', function () {
        $(this).parents('tr').remove();
        check_price();
    });

    $body.on('change', '#delivery', function () {
        if ($(this).val() == 'НоваПошта') {
            $('#address_container').html(' <div class="form-group">\n' +
                '            <label class="col-md-4 control-label" for="city_input">Місто <span class="text-danger">*</span></label>\n' +
                '            <div class="col-md-5">\n' +
                '                <div class="input-group">\n' +
                '                    <input class="form-control" placeholder="Введіть 3 символи" id="city_input">\n' +
                '                    <span class="input-group-addon pointer clear" data-id="city_input">X</span>\n' +
                '                </div>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '\n' +
                '        <input type="hidden" id="city" class="form-control field">\n' +
                '        \n' +
                '        <div class="form-group none" id="city_select_container">\n' +
                '            <label class="col-md-4 control-label" for="city_select"></label>\n' +
                '            <div class="col-md-5">\n' +
                '                <select id="city_select" class="form-control" multiple></select>\n' +
                '                <span class="btn btn-danger btn-xs hiden close_multiple" data-id="city_select_container">X</span>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '        \n' +
                '        <div class="form-group">\n' +
                '            <label class="col-md-4 control-label" for="warehouse">\n' +
                '                Відділення <span class="text-danger">*</span>\n' +
                '            </label>\n' +
                '            <div class="col-md-5">\n' +
                '                <select disabled id="warehouse" class="form-control field"></select>\n' +
                '            </div>\n' +
                '        </div>\n' +
                '        \n' +
                '        <div class="form-group none">\n' +
                '            <label class="col-md-4 control-label" for="warehouse_search"></label>\n' +
                '            <div class="col-md-5">\n' +
                '                <select id="warehouse_search" name="warehouse_search" class="form-control" multiple></select>\n' +
                '            </div>\n' +
                '        </div>');
        } else {
            $('#address_container').html('<div class="form-group">\n' +
                '    <label class="col-md-4 control-label" for="city">Місто <span class="text-danger">*</span></label>\n' +
                '    <div class="col-md-5">\n' +
                '        <input class="form-control field" id="city">\n' +
                '    </div>\n' +
                '</div>\n' +
                '\n' +
                '<div class="form-group">\n' +
                '    <label class="col-md-4 control-label" for="warehouse">\n' +
                '        Відділення <span class="text-danger">*</span>\n' +
                '    </label>\n' +
                '    <div class="col-md-5">\n' +
                '        <input id="warehouse" class="form-control field">\n' +
                '    </div>\n' +
                '</div>');
        }
    });

});
