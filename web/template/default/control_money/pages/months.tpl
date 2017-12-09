<h2 class="sub-header">Витрати <?= get('year'); ?></h2>

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="<?= route('control_money'); ?>">Контроль витрат</a></li>
    <li class="active"><span><?= get('year'); ?></span></li>
</ol>

<?php
$start_life = date_parse(START_LIFE);
$start = $start_life['year'] == get('year') ? $start_life['month'] : '0';
for($i = $start; $i < date('m') + 1; $i++) { ?>
    <a href="<?= route('control_money') . parameters(['year' => get('year'), 'month' => $i]) ?>">
        <?= int_to_month($i) ?>
    </a><br>
<?php } ?>
