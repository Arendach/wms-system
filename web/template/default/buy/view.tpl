<?php include parts('head') ?>

    <h2 class="sub-header">Замовлення: <?= type_parse($type); ?></h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('orders_all'); ?>">Замовлення</a></li>
        <li class="active"><span><?= type_parse($type); ?></span></li>
    </ol>

    <div class="content-section">
        <?php if ($type == 'sending') { ?>
            <button class="btn btn-success" id="export_xml" style="position: absolute;top: 180px;right: 21px;">
                Експортувати XML
            </button>
        <?php } ?>
        <div class="btn-group" style="margin: -5px 0 15px">
            <a href="<?= route('orders', ['type' => 'delivery']) ?>"
               class="<?= $type == 'delivery' ? 'btn-primary' : '' ?> btn btn-default type-btn">
                Доставка
            </a>
            <a href="<?= route('orders', ['type' => 'shop']) ?>"
               class="<?= $type == 'shop' ? 'btn-primary' : '' ?> btn btn-default type-btn">
                Магазин
            </a>
            <a href="<?= route('orders', ['type' => 'self']) ?>"
               class="<?= $type == 'self' ? 'btn-primary' : '' ?> btn btn-default type-btn">
                Самовивіз
            </a>
            <a href="<?= route('orders', ['type' => 'sending']) ?>"
               class="<?= $type == 'sending' ? 'btn-primary' : '' ?> btn btn-default type-btn">
                Відправка
            </a>
        </div>
        <?= $content ?>
        <div class="centered">
            <?php if (isset($paginate)) include parts('paginate') ?>
        </div>

    </div>

<?php include parts('footer') ?>