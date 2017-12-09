<?php $this->inc('/parts/head') ?>

    <h2 class="sub-header"><?= $section ?></h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li class="active"><span>Склади</span></li>
    </ol>

    <div class="right">
        <button id="add" type="button" class="btn btn-primary">Додати</button>
    </div>

    <div class="table-responsive" style="margin-top: 10px">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Назва складу</th>
                <th>Тип складу</th>
                <th>Сортування</th>
                <th style="width: 69px;">Дії</th>
            </tr>
            </thead>
            <tbody>
            <?php if (my_count($storage) > 0) {
                foreach ($storage as $item): ?>
                    <tr>
                        </td>
                        <td><?= $item->name ?></td>
                        <td><span style="color:red;"><?= $item->type ?></span></td>
                        <td><?= $item->sort ?></td>
                        <td class="action-2">
                            <a class="update btn btn-primary btn-xs" href="#" data-id="<?= $item->id ?>"><span
                                        class="glyphicon glyphicon-pencil"></span></a>
                            <a class="delete btn btn-danger btn-xs" href="#" data-id="<?= $item->id ?>"><span
                                        class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                <?php endforeach;
            } else { ?>
                <tr>
                    <td colspan="5" class="centered"><h4>Тут пусто :(</h4></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

<?php $this->inc('/parts/footer'); ?>