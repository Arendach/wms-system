<?php $this->inc('/parts/head'); ?>
    <h2 class="sub-header">Замовлення</h2>
    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('clients'); ?>">Клієнти</a></li>
        <li class="active"><span>Замовлення</span></li>
    </ol>
    <div class="right" style="margin-bottom: 10px">
        <button data-form="add_order" class="btn btn-primary get_form"><span class="glyphicon glyphicon-plus"></span>
            Прикріпити замовлення
        </button>
    </div>

    <table class="table table-bordered">
        <tr>
            <th># Замовлення</th>
            <th>ПІБ</th>
            <th>Телефон</th>
            <th>Адреса</th>
            <th>Сума</th>
            <th>Статус</th>
            <th>Дата</th>
            <th>Дія</th>
        </tr>
        <?php if (my_count($orders) > 0) {
            $statistic['sum'] = 0;
            foreach ($orders as $item) {
                $statistic['sum'] += $item['full_sum'];
                ?>
                <tr>
                    <td><?= $item['id']; ?></td>
                    <td><?= $item['fio']; ?></td>
                    <td><?= $item['phone']; ?></td>
                    <td><?php echo val($item['city']) . ' ' . val($item['region_name']) . ' ' . val($item['address']); ?></td>
                    <td><?= $item['full_sum']; ?> грн</td>
                    <td>
                        <?= get_order_status($item['id'], $item['type']) ?>
                    </td>
                    <td><?= $item['date']; ?></td>
                    <td class="action-2">
                        <a href="<?= route('order', ['id' => $item['id']]); ?>" title="Детальніше"
                           class="btn btn-primary btn-xs"><span
                                    class="glyphicon glyphicon-eye-open"></span></a>
                        <button class="btn btn-danger btn-xs remove" data-id="<?= $item['id'] ?>" title="Видалити"><span
                                    class="glyphicon glyphicon-remove"></span></button>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="8">
                    Всього замовлень - <span class="text-primary"><?= count($orders); ?></span>, на суму <span
                            class="text-primary"><?= $statistic['sum'] ?> грн.</span>
                </td>
            </tr>
        <?php } else { ?>
            <tr>
                <td class="centered" colspan="8"><h4>Тут пусто :(</h4></td>
            </tr>
        <?php } ?>
    </table>

    <input type="hidden" id="client_id" value="<?= $client_id ?>">
<?php $this->inc('/parts/footer'); ?>