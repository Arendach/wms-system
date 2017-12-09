<?php $this->inc('/parts/head') ?>

    <h2 class="sub-header"><?php echo $section ?></h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('manufacture'); ?>">Виробники</a></li>
        <li class="active"><span>Групи виробників</span></li>
    </ol>

    <div class="right">
        <button id="add" type="button" class="btn btn-primary">Додати</button>
        <button id="deleteSelected" type="button" class="btn btn-danger">Видалити</button>
    </div>

    <div class="table-responsive" style="margin-top: 10px">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 36px;">CH</th>
                <th>Назва</th>
                <th>Сорт</th>
                <th style="width: 69px;">Дія</th>
            </tr>
            </thead>
            <tbody>
            <?php if (my_count($groups) > 0) {
                foreach ($groups as $group): ?>
                    <tr>
                        <td style="width: 36px;">
                            <input type="checkbox" class="delSelected" value="<?= $group->id ?>">
                        </td>
                        <td><?= $group->name ?></td>
                        <td><?= $group->sort ?></td>
                        <td style="width: 69px;">
                            <a class="update btn btn-primary btn-xs" href="#" data-id="<?= $group->id ?>"
                               title="Редагувати"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="delete btn btn-danger btn-xs" href="#" data-id="<?= $group->id ?>"
                               title="Видалити"><span class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                <?php endforeach;
            } else {
                echo '<tr><td class="centered" colspan="4"><h4>Тут пусто :(</h4></td></tr>';
            } ?>
            </tbody>
        </table>
    </div>

<?php $this->inc('/parts/footer') ?>