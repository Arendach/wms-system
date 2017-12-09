<?php $this->inc('/parts/head'); ?>

<h2 class="sub-header">Групи постійних клієнтів</h2>

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="<?= route('clients'); ?>">Клієнти</a></li>
    <li class="active"><span>Групи клієнтів</span></li>
</ol>

<div class="right">
    <button style="margin-bottom: 10px" class="btn btn-primary" id="create_group">Нова група</button>
</div>
<table class="table table-bordered" id="group">
    <tr>
        <td class="action-3">ID</td>
        <td>Імя</td>
        <td class="action-2">Сортування</td>
        <td class="action-2">Дія</td>
    </tr>
    <?php if (isset($groups)) {
        foreach ($groups as $group) { ?>
            <tr>
                <td class="action-3"><?=$group->id;?></td>
                <td><?=$group->name;?></td>
                <td class="action-2"><?=$group->sort;?></td>
                <td class="action-2">
                    <button data-toggle="<?=$group->id;?>" class="btn btn-primary btn-xs edit"><span class="glyphicon glyphicon-pencil"></span></button>
                    <button data-toggle="<?=$group->id;?>" class="btn btn-danger btn-xs delete"><span class="glyphicon glyphicon-remove "></span></button>
                </td>
            </tr>
        <?php }
    } ?>
</table>

<?php $this->inc('/parts/footer'); ?>


