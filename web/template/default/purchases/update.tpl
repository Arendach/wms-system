<?php include parts('head'); ?>

    <h2 class="sub-header">Закупки</h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('purchases'); ?>">Закупки</a></li>
        <li class="active"><span>Редагування</span></li>
    </ol>

    <div class="type_block">
        <div class="form-group">
            <label for="status">Статус оплати</label>
            <select id="status" class="form-control">
                <option <?= $purchases->status == 0 ? 'selected' : '' ?> value="0">Не оплачено</option>
                <option <?= $purchases->status == 1 ? 'selected' : '' ?> value="1">Оплачено частково</option>
                <option <?= $purchases->status == 2 ? 'selected' : '' ?> value="2">Оплачено</option>
            </select>
        </div>

        <div class="form-group<?= $purchases->status != 1 ? ' none' : '' ?>" id="prepayment_container">
            <label for="prepayment">Предоплата</label>
            <input class="form-control" id="prepayment" value="<?= $purchases->prepayment ?>">
        </div>

        <div class="form-group">
            <label for="type">Тип предзамовлення</label>
            <select id="type" class="form-control">
                <option <?= $purchases->type == 0 ? 'selected' : '' ?> value="0">Потрібно закупити</option>
                <option <?= $purchases->type == 1 ? 'selected' : '' ?> value="1">Прийнято на облік</option>
            </select>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" id="update_info">Зберегти</button>
        </div>
    </div>

    <br>

<?php include t_file('purchases/add_product') ?>

    <div class="type_block">
        <table class="table table-bordered" style="background-color: #fff">
            <thead>
            <th>Назва товару</th>
            <th>Кількість на складі</th>
            <th>Ціна</th>
            <th>Кількість</th>
            <th class="action-1"></th>
            </thead>
            <tbody>
            <?php foreach ($items as $item) { ?>
                <tr class="product" data-id="<?= $item['product_id'] ?>">
                    <td><?= $item['name'] ?></td>
                    <td><?= $item['count_on_storage'] ?></td>
                    <td><input class="form-control price" value="<?= $item['price'] ?>"></td>
                    <td><input class="form-control amount" <?= $purchases->type == 1 ? 'disabled' : '' ?>
                               value="<?= $item['amount'] ?>"></td>
                    <td class="action-1">
                        <button class="btn btn-danger btn-xs">
                            <span class="glyphicon glyphicon-remove delete"></span>
                        </button>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <div class="form-group">
            <label for="sum">Сума</label>
            <input type="text" class="form-control" id="sum" value="<?= $purchases->sum ?>">
        </div>

        <div class="form-group">
            <label for="comment">Коментар</label>
            <textarea class="form-control" id="comment"><?= $purchases->comment ?></textarea>
        </div>

        <div class="form-group">
            <button class="btn btn-primary" id="update">Зберегти</button>
        </div>
    </div>

<?php include parts('footer'); ?>