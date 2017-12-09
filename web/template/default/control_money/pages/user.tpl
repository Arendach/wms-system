<h2 class="sub-header"><?= user($head->user)->login; ?></h2>

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="<?= route('control_money'); ?>">Контроль витрат</a></li>
    <li><a href="<?= route('control_money') . parameters(['year' => get('year')]); ?>"><?= get('year') ?></a></li>
    <li><a href="<?= route('control_money') . parameters(['year' => get('year'), 'month' => get('monyh')]); ?>"><?= int_to_month(get('month')) ?></a></li>
    <li class="active"><span><?= user($head->user)->login; ?></span></li>
</ol>

<div class="right">
    <button class="btn btn-primary" id="create" style="margin: -10px 0 10px">
        Закрити операцію
    </button>
</div>

<table class="table table-bordered">
    <tr>
        <td><b>Загальний прибуток</b></td>
        <td><b>Загальні витрати</b></td>
        <td><b>На початок місяця</b></td>
        <td><b>На руках</b></td>
        <td><b>Дія</b></td>
    </tr>
    <tr>
        <td>1000 грн</td>
        <td>200 грн</td>
        <td>100 грн</td>
        <td>200 грн</td>
        <td class="action-1">
            <button class="btn btn-xs btn-primary"><span class="glyphicon glyphicon-pencil"></span></button>
        </td>
    </tr>
</table>

<table class="table table-bordered">
    <tr>
        <td class="centered"><b>День</b></td>
        <td class="centered"><b>Назва операції</b></td>
        <td class="centered" colspan="<?= my_count($profits_fields) ?>"><b>Дохід</b></td>
        <td class="centered" colspan="<?= my_count($spending_fields) ?>"><b>Витрати</b></td>
        <td class="centered"><b>Дія</b></td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <?php foreach ($profits_fields as $field) { ?>
            <td><?= $field ?></td>
        <?php } ?>
        <?php foreach ($spending_fields as $field) { ?>
            <td><?= $field ?></td>
        <?php } ?>
        <td></td>
    </tr>

    <?php foreach ($body as $item) { ?>
        <tr>
            <td><?= $item->day; ?></td>
            <td><?= $item->name_operation; ?></td>
            <?php foreach (json_decode($item->profits) as $value) { ?>
                <td><?= $value ?></td>
            <?php } ?>

            <?php foreach (json_decode($item->spending) as $value) { ?>
                <td><?= $value ?></td>
            <?php } ?>
            <td class="action-1">
                <button class="btn btn-xs btn-primary item_update" data-id="<?= $item->id ?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </button>
            </td>
        </tr>
    <?php } ?>
</table>