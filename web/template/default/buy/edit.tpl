<?php include parts('head') ?>

<!-- Title -->

<h2 class="sub-header">
    Редагування замовлення
</h2>

<!-- Breadcrumbs -->

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="<?= route('orders_all'); ?>">Замовлення</a></li>
    <li><a href="<?= route('orders', ['type' => $type]); ?>"><?= type_parse($type); ?></a></li>
    <li class="active"><span>Редагування</span></li>
</ol>

<!-- Tab-Navigation -->

<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#main">Основна інформація</a></li>
    <li><a data-toggle="tab" href="#products">Товари</a></li>
</ul>

<!-- Tab-Content -->

<div class="tab-content" style="margin-top: 15px;">
    <div id="main" class="tab-pane fade in active">
        <?php include t_file('buy/edit/' . $type) ?>
    </div>
    <div id="products" class="tab-pane fade">
        <?php include t_file('buy/edit/products') ?>
    </div>
</div>

<?php include parts('footer') ?>