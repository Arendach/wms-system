<h2 class="sub-header">Звіти <?= int_to_month(get('month')) . ' ' . get('year'); ?> </h2>

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="<?= route('control_money'); ?>">Звіти</a></li>
    <li><a href="<?= route('control_money') . parameters(['year' => get('year')]); ?>"><?= get('year') ?></a></li>
    <li class="active"><span><?= int_to_month(get('month')); ?></span></li>
</ol>

<div class="right">
    <a href="<?= route('control_money') . parameters([
        'year' => get('year'),
        'month' => get('month'),
        'user' => user()->id
    ]) ?>" class="btn btn-primary">Мій звіт</a>
</div>

<?php foreach ($users as $user) {
    $parameters = ['year' => get('year'), 'month' => get('month'), 'user' => $user->id]; ?>
    <a href="<?= route('control_money') . parameters($parameters); ?>"><?= $user->login; ?></a><br>
<?php } ?>