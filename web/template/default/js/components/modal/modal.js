/**
 * Відкрити модальне вікно
 */

function myModalOpen() {
    $('.poster').css('z-index', '1001').animate({opacity: 0.8}, 400);
    $('#modal').css('display', 'block').css('z-index', '1002').animate({opacity: 1}, 400);
}

/**
 * Закрити модальне вікно
 */

function myModalClose() {
    $('.poster').css('z-index', '-1').animate({opacity: 0}, 400);
    $('#modal').css('z-index', '1').animate({opacity: 0}, 400);
    setTimeout(function () {
        $('#modal').css('display', 'none');
    }, 400);
}

/**
 * Обробник події (натиснута кнопка закрити)
 */

(function () {
    $(document).on('click', '#modal_close', function(){
        myModalClose();
    });
})(jQuery);
