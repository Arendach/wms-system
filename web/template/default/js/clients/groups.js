$(document).ready(function () {
    var $body = $('body');
    $body.on('click', '#create_group', function () {
        get_form({
            type: 'create',
            url: 'clients_group'
        });
    });

    $body.on('click', '.submit', function (event) {
        event.preventDefault();
        var name = $('#name').val();
        var sort = $('#sort').val();
        $.ajax({
            type: 'post',
            url: main_siteUrl + 'clients_group/create',
            data: {
                name: name,
                sort: sort
            },
            success: function (a) {
                try {
                    var answer = JSON.parse(a);
                    if (answer.status == '1') {
                        $('form').trigger('reset');
                        myModalClose('modal');
                        $('#group').append('' +
                            '<tr>' +
                            '<td class="action-2">' + answer.id + '</td>' +
                            '<td>' + name + '</td>' +
                            '<td class="action-2">' + sort + '</td>' +
                            '<td class="action-2">' +
                            '<button data-toggle="' + answer.id + '" class="btn btn-primary btn-xs edit"><span class="glyphicon glyphicon-pencil"></span></button>&nbsp;' +
                            '<button data-toggle="' + answer.id + '" class="btn btn-danger btn-xs delete"><span class="glyphicon glyphicon-remove"></span></button>' +
                            '</td>' +
                            '</tr>');
                        success_popup();
                    } else {
                        error_popup('Групу постійних користувачів не створено!');
                    }
                } catch (err) {
                    error_popup(err);
                }
            }
        });
    });

    $body.on('click', '.edit', function () {
        var id = $(this).attr('data-toggle');

        get_form({
            url: 'clients_group',
            type: 'update',
            data: {
                id: id
            }
        });
    });

    $body.on('click', '#esubmit', function (event) {
        event.preventDefault();
        var id = $(this).attr('data-toggle');
        var name = $('#ename').val();
        var sort = $('#esort').val();

        $.ajax({
            type: 'post',
            url: main_siteUrl + 'clients_group/edit',
            data: {
                id: id,
                name: name,
                sort: sort
            },
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('click', '.delete', function () {
        var id = $(this).attr('data-toggle');
        del({
            id: id,
            url: 'clients_group'
        });
    });
});