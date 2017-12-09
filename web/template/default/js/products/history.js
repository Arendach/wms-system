$(document).ready(function () {
    $(function(){
        $('.dropdown_list').click(function(){
            var id = $(this).parents('.dropdown_block').attr('id');
            $("#" + id + " .cities_list").slideToggle('fast');
        });
        $('ul.cities_list li').click(function(){
            var id = $(this).parents('.dropdown_block').attr('id');
            $('#' + id + ' .cities_list').slideUp('fast');
        });
    });
});