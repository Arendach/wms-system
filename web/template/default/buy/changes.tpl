<?php include parts('head') ?>

<!-- Title -->

<h2 class="sub-header"><?= isset($section) ? $section : ''; ?></h2>

<!-- Breadcrumbs -->

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="<?= route('orders_all'); ?>">Замовлення</a></li>
    <li><a href="<?= route('orders', ['type' => $order->type]); ?>"><?= type_parse($order->type); ?></a></li>
    <li><a href="<?= route('order', ['id' => $order->id]); ?>">Замовлення #<?= $order->id ?></a></li>
    <li class="active"><span>Істрорія змін</span></li>
</ol>

<!-- Content -->

<div class="panel-group" id="accordion">
    <?php
    $i = 0;
    foreach ($changes as $item) {
        if (is_file(t_file('buy/changes/' . $item->type)))
            include t_file('buy/changes/' . $item->type);
        $i++;
    }
    ?>
</div>

<?php include parts('footer') ?>
