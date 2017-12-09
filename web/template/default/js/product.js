$(document).ready(function () {

    var $body = $('body');

    function ggR(name, value) {

        var spanLeft = "<span class='input-group-addon'>" + name + "</span>";
        var spanRight = "<span class='input-group-addon delFromAttrList'>[x]</span>";
        var input = "<input data-name=\"" + name + "\" class=\"form-control attribute\" value='" + value + "' />";

        return "<div class='input-group'>" + spanLeft + input + spanRight + "</div>";
    }

    function changeFinaleSum() {
        var selector_elems = $('.lsSumsInp');
        var sum = 0;
        selector_elems.each(function (index, item) {
            sum += parseFloat(($(item).val() == '') ? 0 : $(item).val());
        });

        return sum;
    }

    function setFinalSum(sum) {
        $('#finaleSum').val(sum);
        $('[name=costs]').val(sum);
    }

    $body.on('click', '.deletable', function () {
        $(this).parent().parent().remove();
        setFinalSum(changeFinaleSum());
    });

    $body.on('click', '.lsComboClick', function (event) {
        event.preventDefault();

        var $this = $(this);
        var id = $this.data('id');
        var name = $this.data('name');
        var price = $this.data('price');

        var li = '<li class="list-group-item justify-content-between combine-items" id="' + id + '">' +
            '<div class="input-group">' +
            '<span class="input-group-addon">' + name + '</span>' +
            '<input data-type="cost" value="' + price + '" class="form-control lsSumsInp combine-field" placeholder="Ціна">' +
            '<input data-type="minus" value="1" class="form-control combine-field" placeholder="Зписувати з складу">' +
            '<span class="input-group-addon deletable">x</span>' +
            '<input data-type="id" class="combine-field" type="hidden" value="' + id + '">' +
            '</div>' +
            '</li>';

        $('#lsGrope').prepend(li);

        setFinalSum(changeFinaleSum());

        $('.lsSumsInp').on('textchange', function () {
            setFinalSum(changeFinaleSum());
        });

        $('#finaleSum').on('textchange', function () {
            var sum = $this.val();
            sum = parseFloat(sum);

            $('[name=costs]').val(sum);
        });
    });

    $body.on('click', '#closeSearchResult', function () {
        $('#attrList').html('');
        $('#search_attribute').val('');
    });

    $body.on('change', '#typeProduct', function () {
        var $wrap = $('.combine-wrap');

        if ($(this).val() == 'combine')
            $wrap.show();
        else
            $wrap.hide();
    });

    $body.on('keyup', '#searchCombine', function () {
        var search = $(this).val();
        $.ajax({
            type: 'post',
            url: main_siteUrl + "products/search",
            data: {
                search: search
            },
            success: function (responce) {
                $('#lsComb').html(responce);
            }
        });
    });

    $body.on('click', '#search', function () {
        var data = {};
        $('[data-action=search]').each(function () {
            data[$(this).data('column')] = $(this).val();
        });

        GET.setObject(data).unset('page').unsetEmpty().go();
    });

    $body.on('click', '.sort', function (event) {
        event.preventDefault();
        GET.set('order_field', $(this).data('field')).set('order_by', $(this).data('by')).go();
    });

    $body.on('click', '.copy', function (event) {
        event.preventDefault();
        var amount = prompt('Ведіть кількість копій!', '1');
        $.ajax({
            type: 'post',
            url: this.href,
            data: {
                id: id,
                amount: amount
            },
            success: function (answer) {
                successHandler(answer, function () {
                    window.location.href = route('products');
                });
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $body.on('keyup', '.lsSumsInp', function () {
        setFinalSum(changeFinaleSum());
    });

    $body.on('keyup', '#finaleSum', function () {
        var sum = $(this).val();
        sum = parseFloat(sum);

        $('[name=price]').val(sum);
    });

    $body.on('click', '#deleteProd', function () {

        var conf = confirm('Всі дані про товар будуть видалені, бажаєте продовжити?');
        if (conf === true) {
            var id = $('[name=id]').val();
            $.ajax({
                url: main_siteUrl + "products/delete",
                method: "post",
                data: {
                    id: id
                },
                dataType: "html",
                success: function (responce) {
                    location.href = main_siteUrl + 'products';
                }
            });
        }
    });

    $body.on('keyup', '#search_attribute', function () {
        var $this = $(this);
        $.ajax({
            url: url('/attribute/search'),
            method: 'POST',
            data: {value: $this.val()},
            success: function (answer) {
                $('#attrList').html(answer);
            }
        });
    });

    $body.on('click', '.listAttrClick', function (e) {
        e.preventDefault();
        var name = $(this).attr('data-name');
        var value = $(this).attr('data-value');
        var input = ggR(name, value);
        var list = $('#attrInputsList');

        $(list).append(input);
    });

    $body.on('click', '.delFromAttrList', function () {
        $(this).parent().remove();
    });

    $body.on('keyup', '.volume-field', function () {
        var sum = 1;
        $('.volume-field').each(function () {
            sum *= +$(this).val();
        });
        $('#volume').val(sum / 1000000);
    });
});