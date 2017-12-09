$(document).ready(function () {
    var $body = $('body');
    $body.on('click', '#submit', function (event) {
        event.preventDefault();
        var id = $(this).data('id');
        var access = [];
        $('input:checked').each(function () {
            var $this = $(this);
            if ($this.val() != '' && $this.val() != 'on')
                access.push($this.val())
        });

        update({
            id: id,
            url: 'access_group',
            data: access
        })
    });


    $body.on('change', '.check_input', function () {
        var $this = $(this);
        var $input_class = '.' + $this.attr('id');
        if (this.checked)
            $($input_class).prop('checked', true);
        else
            $($input_class).prop('checked', false);
    });

    (function () {
        var data = [];
        $('.check_input').each(function () {
            data.push($(this).attr('id'));
        });

        for (var i = 0; i < data.length; i++) {
            var check = true;
            var $class = $('.' + data[i]);
            $class.each(function () {
                if (!this.checked)
                    check = false;
            });

            $('#' + data[i]).prop('checked', check);
        }
    })(jQuery);

    $body.on('click', '#create', function () {
        var data = {};
        data.name = $('#name').val();
        data.description = $('#description').val();
        data.values = [];

        $('.ch_input:checked').each(function () {
            data.values.push($(this).val());
        });

        if (data.name.length === 0) {
            swal({
                type: 'error',
                title: 'Помилка!',
                text: 'Введіть імя!'
            });
            return false;
        }

        if (data.values.length === 0) {
            swal({
                type: 'error',
                title: 'Помилка!',
                text: 'Виберіть хоча б один пункт!'
            });
            return false;
        }

        create({
            url: 'access_group',
            data: data,
            success: function () {
                window.location.href = main_siteUrl + 'access_groups';
            }
        });
    });

    /**
     *
     */
    $body.on('click', '.delete', function () {
        del({
            url: 'access_group',
            id: $(this).data('id')
        });
    });
});