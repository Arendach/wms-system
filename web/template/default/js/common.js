/**
 * Функія повертає GET параметри з URL
 */
function $_GET(key) {
    var s = window.location.search;
    s = s.match(new RegExp(key + '=([^&=]+)'));
    return s ? s[1] : false;
}

/**
 * Дата виду YYYY-MM-DD
 */
function today() {
    var date = new Date();
    var values = [date.getDate(), date.getMonth() + 1];
    for (var id in values)
        values[id] = values[id].toString().replace(/^([0-9])$/, '0$1');
    return date.getFullYear() + '-' + values[0] + '-' + values[1];
}

/**
 * @returns {string}
 */
function genTableRow() {
    var ret = "<tr>";
    for (var i = 0, len = arguments.length; i < len; i++)
        ret += "<td>" + arguments[i] + "</td>";
    ret += "</tr>";

    return ret;
}

/**
 * Validate
 */
function validate() {
    var data = {};
    $('[required]').each(function (index, value) {
        data[$(value).attr('name')] = $(value).val();
    });
}

/**
 * Init
 */
$(document).ready(function () {

    var $body = $('body');

    $('[data-toggle="tooltip"]').tooltip();

    $body.on('click', '#map-signs', function (event) {
        event.preventDefault();
        var left_bar = $('#left_bar');
        var content = $('#content');

        if (left_bar.hasClass('mini-bar')) {
            left_bar.toggleClass('navigation', true);
            left_bar.toggleClass('mini-bar', false);
            $.cookie('left_bar_template_class', 'navigation', {expires: 5});
        } else {
            left_bar.toggleClass('navigation', false);
            left_bar.toggleClass('mini-bar', true);
            $.cookie('left_bar_template_class', 'mini-bar', {expires: 5});
        }

        if (content.hasClass('content-mini')) {
            content.toggleClass('content-big', true);
            content.toggleClass('content-mini', false);
            $.cookie('content_template_class', 'content-big', {expires: 5});
        } else {
            content.toggleClass('content-big', false);
            content.toggleClass('content-mini', true);
            $.cookie('content_template_class', 'content-mini', {expires: 5});

        }
    });

    $body.on('click', '.hiden', function () {
        var id = '#' + $(this).data('id');
        $(id).hide();
    });

    $body.on('click', '#clean', function (event) {
        event.preventDefault();
        $.ajax({
            type: 'post',
            url: url('/api/clean'),
            success: function () {
                alert('Кеш та тимчасові файли вдало видалено!');
            }
        })
    });

});

/**
 * @param str
 * @returns {string|XML|void}
 */
function str_to_int(str) {
    return str.replace(/\D+/g, "");
}

/**
 * @param type
 */
function miniPopUp(type) {
    if (type == 'success')
        $('body').append('<div class="popup"><div class="success"><span class="glyphicon glyphicon-ok ok"></span><span class="text">Виконано!</span></div></div>');
    else if (type == 'error')
        $('body').append('<div class="popup"><div class="error"><span class="glyphicon glyphicon glyphicon-remove x"></span><span class="text">Щось пішло не так!</span></div></div>');
}

/**
 *
 */
function closeMiniPopUp() {
    setTimeout(function () {
        $('.popup').remove();
    }, 5000);
}

/**
 * @returns {*}
 */
function getParameters() {
    var Pattern = /[\?][\w\W]+/;
    var getParameters = document.location.href.match(Pattern);
    return getParameters !== null ? getParameters : '';
}

/**
 * @param type
 * @param description
 */
function log(type, description) {
    $.ajax({
        type: 'post',
        url: main_siteUrl + 'log',
        data: {
            type: type,
            desc: description,
        }
    });
}

/**
 * @param desc
 */
function elog(desc) {
    log('error_in_javascript_file', desc);
}

/**
 * @param str
 * @returns {boolean}
 */
function dd(str) {
    console.log(str);
    return false;
}

/**
 * @param url
 */
function redirect(url) {
    window.location.href = url;
}

/**
 * @param path
 * @returns {*}
 */
function url(path) {
    return my_url + path;
}