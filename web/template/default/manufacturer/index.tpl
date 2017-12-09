<?php $this->inc('/parts/head') ?>
    <h2 class="sub-header"><?= $section ?></h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('manufacture_group'); ?>">Групи виробників</a></li>
        <li class="active"><span>Виробники</span></li>
    </ol>

    <div class="right">
        <button id="add_manufacturer" type="button" class="btn btn-primary">Додати</button>
        <button id="printMe" type="button" class="btn btn-primary">Друкувати</button>
        <button id="deleteSelected" type="button" class="btn btn-danger">Видалити</button>
    </div>
    <div class="table-responsive" style="margin-top: 10px">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th style="width: 36px;">CH</th>
                <th>Назва</th>
                <th>Групи виробників</th>
                <th>Телефон</th>
                <th>Електронна пошта</th>
                <th>Сортуваня</th>
                <th style="width: 69px;">Дія</th>
            </tr>
            </thead>
            <tbody>
            <?php if (my_count($manufacturers) > 0) {
                foreach ($manufacturers as $key => $manuf): ?>
                    <tr>
                        <td style="width: 36px;"><input type="checkbox" class="delSelected"
                                                        value="<?php echo $manuf->id ?>"></td>
                        <td><?php echo $manuf->name ?></td>
                        <td><?= val($manuf->group_name) ? $manuf->group_name : 'Група не вибрана' ?></td>
                        <td><?= $manuf->phone; ?></td>
                        <td><?= $manuf->email; ?></td>
                        <td><?= $manuf->sort ?></td>
                        <td style="width: 69px;">
                            <a class="updateManufacturer btn btn-primary btn-xs" title="Редагувати" href="#"
                               data-id="<?php echo $manuf->id ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a class="deleteManufacturer btn btn-danger btn-xs " title="Видалити" href="#"
                               data-id="<?php echo $manuf->id ?>"><span class="glyphicon glyphicon-remove"></span></a>
                        </td>
                    </tr>
                <?php endforeach;
            }else{
                echo '<tr><td class="centered" colspan="7"><h4>Тут пусто :(</h4></td></tr>';
            } ?>
            </tbody>
        </table>
    </div>
<?php $this->inc('/parts/footer') ?>