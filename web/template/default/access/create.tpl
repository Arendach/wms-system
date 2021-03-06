<?php include parts('head'); ?>

    <h2 class="sub-header"><?= $section; ?></h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('access_groups'); ?>">Групи доступу</a></li>
        <li class="active"><span><?= $section; ?></span></li>
    </ol>

    <div class="form-group">
        <label for="name">Імя</label>
        <input id="name" class="form-control">
    </div>


    <div class="form-group">
        <label for="description">Опис</label>
        <input id="description" class="form-control">
    </div>

<?php if (my_count($access) > 0) {
    foreach ($access as $k => $item) { ?>
        <h4><input type="checkbox" id="<?= md5($k); ?>" class="check_input"> <?= $k ?></h4>
        <div style="margin-left: 30px">
            <?php foreach ($item as $item2) { ?>
                <input class="<?= md5($k) ?> ch_input" type="checkbox" value="<?= $item2['access'] ?>">
                <span>
                    <?= $item2['name'] ?>
                    <?php if (!empty($item2['description'])) { ?>
                        <span class="hint" title="<?= $item2['description'] ?>" data-toggle="tooltip">?</span>
                    <?php } ?>
                </span>
                <br>
            <?php } ?>
        </div>
    <?php }
} ?>

    <div class="form-group" style="margin-top: 20px">
        <button id="create" class="btn btn-primary">Зберегти</button>
    </div>

<?php include parts('footer'); ?>