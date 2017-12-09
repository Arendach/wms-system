<?php include parts('head'); ?>
<h2 class="sub-header">Менеджери</h2>

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li class="active"><span>Менеджери</span></li>
</ol>

<div class="right">
    <a href="<?=route('register'); ?>" class="btn btn-primary">Реєструвати</a>
</div>

<div class="container-fluid">

    <?php foreach ($items as $item) { ?>
        <div class="user-block">
            <i class="fa fa-user-circle"></i>
            <a href="<?= route('manager', ['id' => $item->id]) ?>">
                <span class="user-name"> <?= $item->login ?></span>
            </a>

            <div class="buttons">
                <?php if (can()) { ?>
                    <a href="<?= route('manager_edit', ['id' => $item->id]); ?>" class="btn btn-primary btn-xs">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </a>
                <?php } ?>
            </div>
        </div>

    <?php } ?>

</div>

<?php include parts('footer'); ?>
