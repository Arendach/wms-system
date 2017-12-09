<h2 class="sub-header">Контроль витрат</h2>

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li class="active"><span>Витрати</span></li>
</ol>

<?php for ($i = date_parse(START_LIFE)['year']; $i < date_parse(date('Y-m-d h:i:s'))['year'] + 1; $i++) { ?>
    <a href="<?= route('control_money') . parameters(['year' => $i]) ?>"><?= $i; ?></a>
<?php } ?>
