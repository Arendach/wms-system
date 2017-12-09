<form class="form-horizontal">
    <?php
    // Контактна інформація
    include t_file('buy/add/sending/contact');

    // Службова інформація
    include t_file('buy/add/sending/working');

    // Адреса
    include t_file('buy/add/sending/address');

    // Оплата
    include t_file('buy/add/sending/pay');

    // Зворотня доставка
    include t_file('buy/add/sending/return_shipping');

    ?>
</form>
