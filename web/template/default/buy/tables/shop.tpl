<table class="table table-bordered orders-table">
    <thead>
    <th>#</th>
    <th>За товари (Повна сума)</th>
    <th>Статус</th>
    <th>Дата</th>
    <th class="action-2">Дія</th>
    </thead>
    <tr class="tr_search">

        <td>
            <input class="search form-control" id="id" value="<?= get('id'); ?>">
        </td>

        <td>
            <input class="search form-control" id="full_sum" value="<?= get('full_sum') ?>">
        </td>

        <td>
            <select id="status" class="search form-control">
                <option value=""></option>
                <?= get_order_statuses($type, get('status')); ?>
            </select>
        </td>

        <td>
            <input type="date" class="search form-control" id="date" value="<?= get('date'); ?>">
        </td>

        <td class="centered">
            <button class="btn btn-primary btn-xs" id="search"><span class="fa fa-search"></span></button>
        </td>

    </tr>
    <?php if (my_count($data) > 0) {
        foreach ($data as $item) { ?>
            <tr id="<?= $item->id; ?>">

                <td>
                    <?= $item->id; ?>
                </td>

                <td>
                    <?= $item->full_sum ?> (<?= $item->full_sum + $item->delivery_cost - $item->discount ?>) грн
                </td>

                <td>
                    <?= get_order_status($item->status, $type); ?>
                </td>

                <td>
                    <?= $item->date; ?>
                </td>

                <td class="action-2 relative">
                    <div class="buttons none" id="print_<?= $item->id ?>">
                        <a target="_blank" href="<?= route('print_order', ['id' => $item->id]) . parameters(['type' => 'invoice']); ?>"
                           class="btn btn-primary">
                            Рахунок-фактура
                        </a>
                        <br>
                        <a target="_blank" href="<?= route('print_order', ['id' => $item->id]) . parameters(['type' => 'sales_invoice']); ?>"
                           class="btn btn-primary">
                            Видаткова накладна
                        </a>
                    </div>
                    <div class="buttons-2">
                        <a class="btn btn-primary btn-xs" href="<?= route('order', ['id' => $item->id]); ?>">
                            <span class="glyphicon glyphicon-eye-open"></span>
                        </a>
                        <a class="btn btn-primary btn-xs edit" href="<?= route('order_update', ['id' => $item->id]); ?>"
                           title="Редагувати">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                    </div>
                    <div class="buttons-2">
                        <a class="btn btn-primary btn-xs" href="<?= route('changes', ['id' => $item->id]); ?>"
                           title="Історія змін">
                            <span class="glyphicon glyphicon-time"></span>
                        </a>
                        <button data-id="#print_<?= $item->id ?>" class="btn btn-primary btn-xs print_button"
                                title="Друкувати">
                            <span class="glyphicon glyphicon-print"></span>
                        </button>
                    </div>
                    <?php if (!empty($item->color)) { ?>
                        <div class="centered">
                            <button class="btn btn-xs" data-toggle="tooltip"
                                    style="background-color: #<?= $item->color; ?>;" title="<?= $item->description; ?>">
                                <span class="glyphicon glyphicon-comment"></span>
                            </button>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    <?php } else { ?>
        <tr>
            <td class="centered" colspan="4"><h4>Тут пусто :(</h4></td>
        </tr>
    <?php } ?>
</table>