<?php include parts('head'); ?>

<!-- Title -->

<h2 class="sub-header">
    <?= type_parse($type) ?>
</h2>

<!-- Breadcrumbs -->

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index') ?>"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="<?= route('orders_all') ?>">Замовлення</a></li>
    <li><a href="<?= route('orders', ['type' => $type]) ?>"><?= type_parse($type) ?></a></li>
    <li class="active"><span>Нове замовлення</span></li>
</ol>

<!-- Buttons -->

<div class="right">
    <a class="btn btn-<?= $type == 'delivery' ? 'primary' : 'default'; ?>"
       href="<?= route('add_order', ['type' => 'delivery']) ?>">Доставка</a>

    <a class="btn btn-<?= $type == 'shop' ? 'primary' : 'default'; ?>"
       href="<?= route('add_order', ['type' => 'shop']) ?>">Магазин</a>

    <a class="btn btn-<?= $type == 'self' ? 'primary' : 'default'; ?>"
       href="<?= route('add_order', ['type' => 'self']) ?>">Самовивіз</a>

    <a class="btn btn-<?= $type == 'sending' ? 'primary' : 'default'; ?>"
       href="<?= route('add_order', ['type' => 'sending']) ?>">Відправка</a>
</div>

<!-- Content -->

<div class="content-section">
    <?php include t_file('buy/add/main') ?>
</div>

<?php include parts('footer') ?>