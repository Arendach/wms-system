<?php include parts('head'); ?>

<h2 class="sub-header">Мій профіль</h2>

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li class="active"><span>Мій профіль</span></li>
</ol>

<ul>
    <li><a href="<?= route('work_schedule') . parameters(['show' => 'my']) ?>">Мій графік роботи</a></li>
    <li><a href="<?= route('password_update') ?>">Зміна паролю</a></li>
</ul>

<?php include parts('footer'); ?>
