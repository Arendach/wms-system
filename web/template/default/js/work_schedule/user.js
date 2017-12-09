$(document).ready(function () {
    var $body = $('body');
    $body.on('click', '.get_form', function (event) {
        event.preventDefault();
        var data = Data, $this = $(this);
        if ($this.data('form') === 'create_day' || $this.data('form') === 'update_day')
            data.day = $this.data('day');
        data.form = $this.data('form');

        get_form({
            url: 'work_schedule',
            type: data.form,
            data: data
        });
    });

    /**
     *
     */
    $body.on('click', '#update', function (event) {
        event.preventDefault();
        var data = {};
        $('.field').each(function () {
            data[$(this).attr('id')] = $(this).val();
        });

        data.type_update = $(this).data('type');

        var worked = +$('#went_away').val() - (+$('#turn_up').val() + +$('#dinner_break').val());
        if (worked < +$('#work_day').val())
            $('#work_day').val(worked);

        update({
            id: $(this).data('id'),
            data: data,
            url: 'work_schedule'
        });
    });

    $body.on('click', '#create', function (event) {
        event.preventDefault();
        var data = Data;
        $('.field').each(function () {
            data[$(this).attr('id')] = $(this).val();
        });
        data.day = $(this).data('day');

        var worked = +$('#went_away').val() - (+$('#turn_up').val() + +$('#dinner_break').val());
        if (worked < +$('#work_day').val())
            $('#work_day').val(worked);

        create({
            url: 'work_schedule',
            data: data
        });
    });

    $body.on('keyup', '#work_day', function () {
        var worked = +$('#went_away').val() - (+$('#turn_up').val() + +$('#dinner_break').val());
        if (worked < +$('#work_day').val())
            $('#work_day').val(worked);
    });

    $body.on('keyup', '.time', function () {
        var $this = $(this);
        var array = [];
        for (var i = 0; i < 25; i++)
            array.push(i);

        if ($.inArray(+$this.val(), array) === -1)
            $($this.val(0))
    });
});