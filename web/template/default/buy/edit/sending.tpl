<form class="form-horizontal">
    <?php
    // Status
    include t_file('buy/edit/sending/status');
    if ($order->status != 2) {
        // Контактна інформація
        include t_file('buy/edit/sending/contact');

        // Службова інформація
        include t_file('buy/edit/sending/working');

        // Адреса
        include t_file('buy/edit/sending/address');

        // Оплата
        include t_file('buy/edit/sending/pay');

        // Зворотня доставка
        include t_file('buy/edit/sending/return_shipping');
    }
    ?>
</form>
