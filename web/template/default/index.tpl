<?php include parts('head') ?>
    <h2 class="sub-header"><?= $section ?></h2>

<?php if ($schedules - 1 > 0) { ?>
    <div class="alert alert-warning alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Увага!</strong> У вас за цей місяць не заповнено звітів - <?= $schedules - 1; ?>!<br>
        Звіти можна заповнити за даним
        <a href="<?= route('work_schedule') . parameters(['year' => date('Y'), 'month' => date('m'), 'user' => user()->id]) ?>">
            посиланням
        </a>!
    </div>
<?php } ?>


<?php if ($schedules_month['work_schedules_month'] > 0) { ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Увага!</strong> У вас за минулий місяць не заповнено звітів
        - <?= $schedules_month['work_schedules_month']; ?>!<br>
        Звіти можна заповнити за даним
        <a href="<?= route('work_schedule') . parameters(['year' => $schedules_month['year'], 'month' => $schedules_month['month'], 'user' => user()->id]) ?>">
            посиланням
        </a>!
    </div>
<?php } ?>

<?php include parts('footer'); ?>