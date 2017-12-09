<?php $css = [style('purchases')]; ?>
<?php include parts('head'); ?>

    <h2 class="sub-header">Закупки</h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li class="active"><span>Закупки</span></li>
    </ol>

    <div class="relative">
        <div class="btn-group">
            <a href="<?= route('purchases') ?>" class="btn btn-<?= get('view') == false ? 'primary' : 'default' ?>">Відкриті</a>
            <a href="<?= route('purchases') . parameters(['view' => 'all']) ?>"
               class="btn btn-<?= get('view') == 'all' ? 'primary' : 'default' ?>">Всі</a>
            <a href="<?= route('purchases') . parameters(['view' => 'close']) ?>"
               class="btn btn-<?= get('view') == 'close' ? 'primary' : 'default' ?>">Закриті</a>
        </div>
        <a href="<?= route('purchases_create') ?>" class="btn btn-primary create" title="Створити нове замовлення">
            Створити
        </a>
    </div>

    <h4>Сума <span class="label label-default"><?= $sum ?>грн</span></h4>

    <table class="table table-bordered">
        <tr>
            <th>Дата</th>
            <th>Виробник</th>
            <th>Сума</th>
            <th>Оплата</th>
            <th>Тип предзамовлення</th>
            <th class="action-2">Дії</th>
        </tr>

        <tr>
            <td>
                <input type="date" class="filter"
                    <?= get('date_with') ? 'value="' . get('date_with') . '"' : '' ?> data-column="date_with">
                <input type="date" class="filter"
                    <?= get('date_to') ? 'value="' . get('date_to') . '"' : '' ?> data-column="date_to">
            </td>

            <td>
                <select class="form-control filter" data-column="manufacturer">
                    <option value=""></option>
                    <?php foreach ($manufacturers as $manufacturer) { ?>
                        <option <?= $manufacturer->id == get('manufacturer') ? 'selected' : '' ?>
                                value="<?= $manufacturer->id ?>"><?= $manufacturer->name ?></option>
                    <?php } ?>
                </select>
            </td>

            <td></td>

            <td>
                <select class="filter form-control" data-column="status">
                    <option value=""></option>
                    <option <?= get('status') === '0' ? 'selected' : '' ?> value="0">Не оплачено</option>
                    <option <?= get('status') === '1' ? 'selected' : '' ?> value="1">Оплачено частково</option>
                    <option <?= get('status') === '2' ? 'selected' : '' ?> value="2">Оплачено</option>
                </select>
            </td>

            <td>
                <select class="filter form-control" data-column="type">
                    <option value=""></option>
                    <option <?= get('type') === '0' ? 'selected' : '' ?> value="0">Потрібно закупити</option>
                    <option <?= get('type') === '1' ? 'selected' : '' ?> value="1">Прийнято на облік</option>
                </select>
            </td>

            <td>
                <button class="btn btn-primary btn-xs" id="filter">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </td>
        </tr>

        <?php foreach ($items as $item) { ?>
            <tr>
                <td><?= $item->date ?></td>
                <td><?= $item->manufacturer_name ?></td>
                <td><?= $item->sum ?></td>
                <td>
                    <?php if ($item->status == 0)
                        echo 'Не оплачено';
                    elseif ($item->status == 1)
                        echo 'Сплачено частково';
                    else
                        echo 'Сплачено'; ?>
                </td>
                <td><?= $item->type == 0 ? 'Потрібно закупити' : 'Прийнято на облік' ?></td>
                <td>
                    <?php if ($item->close) { ?>
                        <button class="btn btn-danger btn-xs">
                            <span class="glyphicon glyphicon-lock"></span>
                        </button>
                    <?php } else { ?>
                        <a href="<?= route('purchases_update', ['id' => $item->id]) ?>" class="btn btn-primary btn-xs">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                    <?php } ?>

                    <a href="<?= route('purchases_print', ['id' => $item->id]) ?>" class="btn btn-primary btn-xs">
                        <span class="glyphicon glyphicon-print"></span>
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>


<?php include parts('footer'); ?>