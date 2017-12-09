$(document).ready(function () {
    /**
     * @type {*|jQuery|HTMLElement}
     */
    var $body = $('body');

    /**
     * Зміна типу зворотньої доставки
     */
    $body.on('change', '#return_shipping_type', function () {
        var selected = $(this).val();

        if (selected === 'documents' || selected == 'other') {
            $('#return_shipping_card_container').hide();
            $('#return_shipping_sum_container').show();
            $('#return_shipping_remittance_type_container').hide();
        } else if (selected == 'remittance') {
            $('#return_shipping_card_container').hide();
            $('#return_shipping_sum_container').show();
            $('#return_shipping_remittance_type_container').show();
        } else {
            $('#return_shipping_card_container').hide();
            $('#return_shipping_sum_container').hide();
            $('#return_shipping_remittance_type_container').hide();
        }

        selected == 'none' ? $('#return_shipping_payer_container').hide() : $('#return_shipping_payer_container').show();

        $('#return_shipping_sum').val('');
    });

    /**
     * Зміна типу грошового переказу
     */
    $body.on('change', '#return_shipping_type_remittance', function () {
        $(this).val() === 'on_the_card' ? $('#return_shipping_card_container').show() : $('#return_shipping_card_container').hide();
    });

    /**
     * Оновлення інформації про зворотню доставку
     */
    $body.on('click', '#update_return_shipping', function (event) {
        event.preventDefault();
        var data = {
            type: $('#return_shipping_type').val(),
            type_remittance: $('#return_shipping_type_remittance').val(),
            sum: $('#return_shipping_sum').val(),
            card: $('#return_shipping_card').val(),
            payer: $('#return_shipping_payer').val(),
            id: id
        };

        $.ajax({
            type: 'post',
            url: url('/orders/update'),
            data: {
                form: 'return_shipping',
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

    $body.on('change', '#form_delivery', function () {
        var selected = $(this).val();
        if(selected == 'imposed'){
            $('#imposed_container').show();
        } else {
            $('#imposed_container').hide();
        }
    });
});