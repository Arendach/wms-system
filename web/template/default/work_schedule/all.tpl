<?php $this->inc('/parts/head') ?>
    <h2 class="sub-header"><?= isset($section) ? $section : '' ?></h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li class="active"><span>Звіти</span></li>
    </ol>

<?php for ($i = date_parse(START_LIFE)['year']; $i < date_parse(date('Y-m-d h:i:s'))['year'] + 1; $i++) { ?>
    <a href="<?= route('work_schedule') . parameters(['year' => $i]) ?>"><?= $i; ?></a>
<?php } ?>


<?php $this->inc('/parts/footer') ?>