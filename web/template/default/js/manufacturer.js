$(document).ready(function () {
    $(document).on('click', '#add_manufacturer', function () {
        $.ajax({
            type: "post",
            url: main_siteUrl + 'manufacturer/showAdd',
            success: function (response) {
                $('#modal').html(response);
                myModalOpen();
                $('.summernote').summernote({
                    height: 150
                });
            }
        });
    });

    $(document).on('click', '#save', function (event) {
        event.preventDefault();
        var data = {};
        $.each($('*[name]'), function (index, value) {
            data[$(value).attr('name')] = $(value).val();
        });

        $.ajax({
            type: "post",
            url: main_siteUrl + 'manufacturer/add',
            data: data,
            dataType: "html",
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $(document).on('click', '#deleteSelected', function () {
        var selected = [];
        $('.delSelected:checked').each(function () {
            selected.push($(this).val());
        });

        if (selected.length < 1) {
            swal({
                text: 'Не відмічено категорії, які необхідно видалити!',
                type: 'error',
                title: 'Помилка!'
            });
            return false;
        }

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
                    url: main_siteUrl + 'manufacturer/delete',
                    method: "POST",
                    data: {
                        id: selected
                    },
                    success: function (answer) {
                        successHandler(answer);
                    },
                    error: function (answer) {
                        errorHandler(answer);
                    }
                });
            });
    });

    $(document).on('click', '.deleteManufacturer', function (event) {
        event.preventDefault();
        var id = $(this).attr('data-id');

        del({
            url: 'manufacturer',
            id: id
        });
    });

    $(document).on('click', '.updateManufacturer', function (e) {
        var id = $(this).attr('data-id');

        $.ajax({
            type: "post",
            url: main_siteUrl + 'manufacturer/update',
            data: {
                id: id
            },
            dataType: "html",
            success: function (a) {
                $('#modal').html(a);
                $('#summernote').summernote({
                    height: 150
                });
                myModalOpen();
            }
        });
    });

    $(document).on('click', '#saveManufacturer', function (event) {
        event.preventDefault();
        var data = {};
        $.each($('*[name]'), function (index, value) {
            data[$(value).attr('name')] = $(value).val();
        });

        $.ajax({
            type: "post",
            url: main_siteUrl + "manufacturer/save",
            data: data,
            dataType: "html",
            success: function (answer) {
                successHandler(answer);
            },
            error: function (answer) {
                errorHandler(answer);
            }
        });
    });

    $(document).on('click', '#printMe', function () {

        var selected = [];
        $('.delSelected:checked').each(function () {
            selected.push($(this).val());
        });

        if (selected.length < 1) {
            alert('Не відмічено що треба друкувати!');
            return false;
        }

        $.ajax({
            type: "post",
            url: main_siteUrl + "manufacturer/print",
            data: {
                ids: selected
            },
            dataType: "html",
            success: function (response) {
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = response;
                window.print();
                document.body.innerHTML = originalContents;
            }
        });
    });
});