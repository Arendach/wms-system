<div class="form-group right">
    <a href="<?= route('change_type').parameters(['id' => $id, 'type' =>  'self']) ?>" class="btn btn-primary">
        Змінити тип на Самовивіз
    </a>
</div>

<form id="form_order" class="form-horizontal">

    <?php
    include t_file('buy/edit/delivery/status');
    if ($order->status != '4') {
        include t_file('buy/edit/delivery/contacts');
        include t_file('buy/edit/delivery/working');
        include t_file('buy/edit/delivery/address');
        include t_file('buy/edit/delivery/pay');
    }
    ?>

</form>