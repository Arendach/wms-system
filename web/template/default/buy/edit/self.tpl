<div class="form-group right">
    <a href="<?= route('change_type').parameters(['id' => $id, 'type' =>  'delivery']) ?>" class="btn btn-primary">
        Змінити тип на Доставка
    </a>
</div>


<form id="form_order" class="form-horizontal">
    <?php
    include t_file('buy/edit/self/status');
    if ($order->status != '4') {
        include t_file('buy/edit/self/contact');
        include t_file('buy/edit/self/working');
        include t_file('buy/edit/self/address');
    }
    ?>
</form>