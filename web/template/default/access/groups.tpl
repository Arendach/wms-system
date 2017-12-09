<?php include parts('head'); ?>

    <h2 class="sub-header"><?= $section; ?></h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li class="active"><span>Групи доступу</span></li>
    </ol>

    <div class="right" style="margin-top: -10px; margin-bottom: 10px;">
        <a href="<?= route('access_group_create'); ?>" class="btn btn-primary">Створити групу</a>
    </div>

    <table class="table table-bordered">
        <thead>
        <th>Група</th>
        <th>Опис</th>
        <th class="action-2">Дія</th>
        </thead>
        <?php if(my_count($groups) > 0){
            foreach ($groups as $item) { ?>
                <tr>
                    <td><?= $item['name']; ?></td>
                    <td><?= $item['description']; ?></td>
                    <td>
                        <a class="btn btn-primary btn-xs" href="<?= route('access_group', ['id' => $item->id]); ?>">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <button data-id="<?= $item->id; ?>" class="delete btn btn-danger btn-xs">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </td>
                </tr>
            <?php }
        } ?>
    </table>

<?php include parts('footer'); ?>