$(document).ready(function () {

    var $body = $('body');

    $('.search_product input').change(function () {
        $('.search_product input').val('');
    });

    $('#search_ser_code').on('keyup', function () {
        var this_ = $(this);
        if (this_.val().length < 3) return false;
        $.ajax({
            url: main_siteUrl + 'ajax/s_products',
            data: {services_code: this_.val()},
            dataType: 'html',
            method: 'post',
            success: function (data) {
                $('.new_product_block .products').html(data);
            }
        });
    });

    $('#search_name').on('keyup', function () {
        var $this = $(this);
        if ($this.val().length < 3) return false;
        $.ajax({
            url: main_siteUrl + 'ajax/s_products',
            data: {name: $this.val()},
            dataType: 'html',
            method: 'post',
            success: function (data) {
                $('.new_product_block .products').html(data);
            }
        });
    });

    $('#categories_pr').change(function () {
        var this_ = $(this);
        if (!this_.val()) {
            $('.new_product_block .products').html('');
            return false;
        }
        $.ajax({
            url: main_siteUrl + 'ajax/s_products',
            data: {category_id: this_.val()},
            dataType: 'html',
            method: 'post',
            success: function (data) {
                $('.new_product_block .products').html(data);
            }
        });
    });

    $('#products').on('change', '[class^=el]', function () {
        var parent = $(this).parents(':eq(2)');
        var amount = parent.find('.el_amount').val();
        var price = parent.find('.el_price').val();
        parent.find('.el_sum').val(price * amount);
    });

    function search_warehouses(city_id) {
        $.ajax({
            type: 'post',
            url: url('/api/search_warehouses'),
            data: {
                city: city_id
            },
            success: function (answer) {
                $('#warehouse').html(answer).removeAttr('disabled');
            }
        });
    }

    $body.on('click', '.clear', function () {
        var $this = $(this);
        $('#' + $this.data('id')).val('');
    });

    $('#city_select').on('change', function () {
        var $selected = $(this);
        var text = $selected.text(), value = $selected.val();

        $('#city_input').val(text);

        search_warehouses(value[0]);

        $('#city').attr('value', value);

        // $('#city_select').html('').parents('.form-group').css('display', 'none');
    });

    $('#city_input').on('focus', function () {
        $('#city_select').parents('.form-group').css('display', 'block');
    });

    $('#city_input').on('keyup', function () {
        if ($('#city_input').val().length > 2) {
            $.ajax({
                type: 'post',
                url: main_siteUrl + 'api/get_city',
                data: {
                    key: '123',
                    str: $('#city_input').val()
                },
                success: function (a) {
                    $('#city_select').html(a);
                }
            });
        }
    });

    $('#coupon').on('keyup', function () {
        if ($('#coupon').val().length > 0) {
            $.ajax({
                type: 'post',
                url: main_siteUrl + 'api/search_coupon',
                data: {
                    key: '123',
                    str: $('#coupon').val()
                },
                success: function (a) {
                    try {
                        var answer = JSON.parse(a);
                        $('#coupon_search').html('');
                        for (var data in answer) {
                            $('#coupon_search').prepend('<option value="' + answer[data]['code'] + '">' + answer[data]['code'] + '(' + answer[data]['name'] + ')</option>');
                        }
                    } catch (err) {
                        console.log('error parse');
                    }
                }
            });
        }
    });

    $('#coupon_search').on('change', function (e) {
        var val = $('#coupon_search :selected').val();
        $('#coupon').val(val);
        $('#coupon_search').html('');
        $('#coupon_search').parents('.form-group').css('display', 'none');
    });

    $('#coupon').on('focus', function () {
        $('#coupon_search').parents('.form-group').css('display', 'block');
    });

});