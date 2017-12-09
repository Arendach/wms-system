/**
 * Вивести форму на екран в вигляді попапа
 */
function get_form(data) {
    if (data.data === undefined)
        data.data = {};
    $.ajax({
        type: "post",
        url: main_siteUrl + data.url + '/get_form',
        data: {
            form: data.type,
            data: data.data
        },
        dataType: "html",
        success: function (a) {
            $('#modal').html(a);
            myModalOpen();
            if (data.summernote !== undefined && data.summernote === true) {
                $('.summernote').summernote({
                    height: 150
                });
            }
        },
        error: function (answer) {
            errorHandler(answer);
        }
    });
}

/**
 * Видалити елемент
 * @param data
 */
function del(data) {
    if (data.data === undefined)
        data.data = {};

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
                type: "post",
                url: main_siteUrl + data.url + '/delete',
                data: {
                    id: data.id,
                    data: data.data
                },
                success: function (answer) {
                    successHandler(answer);
                },
                error: function (answer) {
                    errorHandler(answer);
                }
            });
        });
}

/**
 * Оновити форму
 * @param data
 */
function update(data) {
    if (data.data === undefined)
        data.data = {};
    $.ajax({
        type: "post",
        url: main_siteUrl + data.url + "/update",
        data: {
            data: data.data,
            id: data.id
        },
        dataType: "html",
        success: function (answer) {
            successHandler(answer);
        },
        error: function (answer) {
            errorHandler(answer);
        }
    });
}

/**
 * Створити елемент
 * @param data
 */
function create(data, success) {
    if (data.data === undefined)
        data.data = {};
    if (success === undefined)
        success = function (answer) {
            successHandler(answer);
        };

    $.ajax({
        type: "post",
        url: main_siteUrl + data.url + "/create",
        data: data.data,
        dataType: "html",
        success: success,
        error: function (answer) {
            errorHandler(answer);
        }
    });
}

/**
 * Повідомлення про помилку в вигляді попапа
 * @param err
 */
function error_popup(err) {
    var e = err === undefined ? 'Сталась помилка!' : err;
    swal({
        type: 'error',
        text: e,
        title: 'Помилка'
    });
}


/**
 * Повідомлення про вдале виконання дії в вигляді попапа
 * @param err
 */
function success_popup(err) {
    var e = err === undefined ? 'Вдало виконано!' : err;
    swal({
        type: 'success',
        text: e,
        title: 'Виконано'
    });
}

function errorHandler(response) {
    try {
        var answer = JSON.parse(response.responseText);
        var message = answer.message !== undefined ? answer.message : 'Невідома помилка!';
        swal({
            type: 'error',
            text: message,
            title: 'Помилка',
            html: true
        });
    } catch (err) {
        elog(response);
        swal({
            type: 'error',
            text: response.responseText,
            title: 'Помилка',
            html: true
        });
    }
}

function successHandler(response, func) {
    try {
        if (func === undefined) {
            func = function () {
                location.reload();
            };
        } else if(func === true) {
            func = function () {
                swal.close();
            };
        }

        var answer = JSON.parse(response);
        var message = answer.hasOwnProperty('message') ? answer.message : 'Всі дані збережено!';
        swal({
            type: 'success',
            text: message,
            title: 'Виконано',
            closeOnConfirm: false
        }, func);

    } catch (err) {
        elog(response);
        swal({
            type: 'error',
            text: response,
            title: 'Помилка',
            html: true
        });
    }
}

/**
 * Обробка відповіді від сервера
 * Якщо статус == '1' - повідомлення про виконання дії || повідомлення про помилку
 * @param a
 */
function answerHandler(a) {
    try {
        var answer = JSON.parse(a);
        if (answer.status == '1')
            var text = answer.hasOwnProperty('message') ? answer.message : 'Всі дані збережено!';
        else
            var text = answer.hasOwnProperty('message') ? answer.message : 'Дані не збережено!';

        if (answer.status == '1') {
            swal({
                type: 'success',
                text: text,
                title: 'Виконано'
            });
        } else {
            swal({
                type: 'error',
                text: text,
                title: 'Помилка'
            });
        }
    } catch (err) {
        elog(a);
        swal({
            type: 'error',
            text: a,
            title: 'Помилка',
            html: true
        });
    }
}
