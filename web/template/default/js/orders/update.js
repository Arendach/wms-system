$(document).ready(function () {

    /**
     * @type {*|jQuery|HTMLElement}
     */
    var $body = $('body');

    /**
     * @param form
     * @param data
     */
    function update(form, data) {
        $.ajax({
            type: 'post',
            url: url('/orders/update'),
            data: {
                form: form,
                data: data
            },
            success: function (answer) {
                successHandler(answer, true);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    }

    /**
     * Update Contact
     */
    $body.on('click', '#update_contact', function (event) {
        event.preventDefault();
        var data = {
            id: id,
            fio: $('#fio').val(),
            phone: $('#phone').val(),
            phone2: $('#phone2').val(),
            email: $('#email').val()
        };

        update('contact', data);
    });

    /**
     * Update Working Info
     */
    $body.on('click', '#update_working', function (event) {
        event.preventDefault();
        var data = {
            id: id,
            hint: $('#hint').val(),
            delivery: $('#delivery').val(),
            date_delivery: $('#date_delivery').val(),
            courier: $('#courier').val(),
            coupon: $('#coupon').val(),
            comment: $('#comment').val(),
            time_with: $('#time_with').val(),
            time_to: $('#time_to').val()
        };

        update('working', data);
    });

    /**
     * Update Status
     */
    $body.on('click', '#update_status', function (event) {
        event.preventDefault();
        var data = {
            id: id,
            status: $('#status').val()
        };

        update('status', data);
    });

    /**
     * Update Address
     */
    $body.on('click', '#update_address', function (event) {
        event.preventDefault();
        var data = {
            id: id,
            city: $('#city').val(),
            street: $('#street').val(),
            warehouse: $('#warehouse').val(),
            address: $('#address').val(),
            region: $('#region').val()
        };

        update('address', data);
    });

    /**
     * Update Pay
     */
    $body.on('click', '#update_pay', function (event) {
        event.preventDefault();
        var data = {
            id: id,
            form_delivery: $('#form_delivery').val(),
            pay_delivery: $('#pay_delivery').val(),
            payment_status: $('#payment_status').val(),
            imposed: $('#imposed').val(),
            prepayment: $('#prepayment').val(),
            pay_method: $('#pay_method').val(),
        };

        update('pay', data);
    });

});