<?php include parts('head'); ?>

<h2 class="sub-header">Графік <?= $data->login . ' за ' . int_to_month($data->month) . ' ' . $data->year; ?></h2>

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="<?= route('work_schedule'); ?>">Графік роботи</a></li>
    <li><a href="<?= route('work_schedule') . parameters(['year' => get('year')]); ?>"><?= get('year') ?></a></li>
    <li><a href="<?= route('work_schedule') . parameters(['year' => get('year'), 'month' => get('month')]); ?>">
            <?= int_to_month($data->month) ?>
        </a></li>
    <li class="active"><span><?= $data->login ?></span></li>
</ol>

<?php if (can()) { ?>
    <table class="table-bordered table">
        <tr>
            <td>Коефіціент</td>
            <td>Днів</td>
            <td>Ставка за місяць</td>
            <td>Ставка за день</td>
            <td>Ставка за годину</td>
            <td>За машину</td>
            <td>Бонус</td>
            <td>Штраф</td>
            <td>Зарплата</td>
            <td>Дія</td>
        </tr>
        <tr>
            <td><?= $data->coefficient; ?></td>
            <td>
                Робочих: <?= $workday ?><br>
                Вихідних: <?= $day_off ?>
            </td>
            <td><?= $data->price_month; ?> грн</td>
            <td><?= round($data->price_month / $workday, 2); ?> грн</td>
            <td><?= round($data->price_month / $workday / 8, 2); ?> грн</td>
            <td><?= $data->for_car; ?> грн</td>
            <td><?= $bonus; ?> грн</td>
            <td><?= $data->fine; ?> грн</td>
            <td><?= $salary; ?> грн</td>
            <td>
                <button class="btn btn-primary btn-xs get_form" data-form="edit_head">
                    <span class="glyphicon glyphicon-pencil"></span>
                </button>
            </td>
        </tr>
    </table>
<?php } ?>


<table class="table table-bordered">
    <tr>
        <td>Число</td>
        <td>День</td>
        <td>Роб/Вих</td>
        <td>Вихід на роботу</td>
        <td>Вихід додому</td>
        <td>Пропрацював</td>
        <td>Робочий день</td>
        <td>Обід</td>
        <td>Перевиконання</td>
        <?php if (can() || user()->id == $data->user) { ?>
            <td>Дія</td>
        <?php } ?>
    </tr>
    <?php for ($i = 1; $i < day_in_month($data->month, $data->year) + 1; $i++) {
        $date = $data->year . '-' . $data->month . '-' . $i;
        $color = (date_to_day($date) == 'Неділя' || date_to_day($date) == 'Субота') ? '#f00' : '#2FAC7C';
        if (isset($schedules[$i])) {
            $item = $schedules[$i];
            ?>

            <tr style="background-color: rgba(0,255,0,.2)">
                <td><?= $i; ?></td>
                <td style="color: <?= $color ?>"><?= date_to_day($date); ?></td>
                <td><?= $item->type == true ? 'Робочий' : 'Вихідний'; ?></td>
                <td><?= $item->turn_up; ?></td>
                <td><?= $item->went_away; ?></td>
                <td>
                    <?php $item->worked = $item->went_away - $item->turn_up - $item->dinner_break;
                    if ($item->worked == $item->work_day)
                        echo '<span style="color:#00f">' . $item->worked . ' год</span>';
                    elseif ($item->worked > $item->work_day)
                        echo '<span style="color:#0f0">' . $item->worked . ' год</span>';
                    elseif ($item->worked < $item->work_day)
                        echo '<span style="color:#f00">' . $item->worked . ' год</span>';
                    ?>
                </td>
                <td><?= $item->work_day; ?></td>
                <td><?= $item->dinner_break; ?></td>
                <td>
                    <?= $item->worked - $item->work_day > 0 ? $item->worked - $item->work_day . ' год' : '0'; ?>
                </td>
                <?php if (can() || user()->id == $data->user) { ?>
                    <td>
                        <button data-form="update_day" data-day="<?= $i; ?>" class="btn btn-primary btn-xs get_form">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                    </td>
                <?php } ?>
            </tr>
        <?php } else { ?>
            <tr style="background-color: rgba(255,0,0,.2)">
                <td><?= $i; ?></td>
                <td style="color: <?= $color ?>"><?= date_to_day($date); ?></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <?php if (can() || user()->id == $data->user) { ?>
                    <td>
                        <?php if (get('month') == date('m') && $i > date('d')) { ?>
                            <button class="btn btn-danger btn-xs">
                                <span class="glyphicon glyphicon-lock"></span>
                            </button>
                        <?php } else { ?>
                            <button data-form="create_day" data-day="<?= $i; ?>"
                                             class="btn btn-primary btn-xs get_form">
                                <span class="glyphicon glyphicon-pencil"></span>
                            </button>
                        <?php } ?>
                    </td>
                <?php } ?>
            </tr>
        <?php }
    } ?>
</table>
<?php include parts('footer'); ?>
