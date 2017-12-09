<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?= style('components/bootstrap/bootstrap') ?>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .table-container {
            width: 90%;
            margin: 5%;
        }

        span.b_line {
            text-decoration: underline;
        }

        .centered {
            text-align: center;
        }

        .inline {
            display: inline;
        }

        .small {
            font-size: 11px;
        }

    </style>
    <title>Товарний чек</title>
</head>
<body>
<div class="table-container">
    <table class="table table-bordered">
        <tr>
            <td colspan="1" class="centered">
                <h1>Товарний чек</h1>
            </td>

            <td colspan="1" class="centered small">
                Дата виписки рахунку: <?= date('Y-m-d h:i:s'); ?>
                <br>
                Менеджер: <?= user()->login ?>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="centered">
                Портал феєрверків, повітряних кульок та подарунків - SkyFire.com.ua
                <hr>
                063-247-91-35, 063-478-01-78
            </td>
        </tr>
        <tr>
            <td colspan="1" class="centered" style="padding: 10px">
                № Замовлення: <h3 class="inline"><?= $id ?></h3>
            </td>
            <td colspan="1" class="centered" style="padding: 10px">
                Номер картки:
                <span class="b_line">&emsp;</span>
                <span class="b_line">&emsp;</span>
                <span class="b_line">&emsp;</span>
                <span class="b_line">&emsp;</span>
                <span class="b_line">&emsp;</span>
                <span class="b_line">&emsp;</span>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="centered">
                <h1>Інформація по доставці</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                Дата: <?= $order->date_delivery ?>
            </td>
            <td style="padding: 5px">
                <?php if ($type == 'delivery') { ?>
                    Від-до: <b><?= string_to_time($order->time_with) ?> - <?= string_to_time($order->time_to) ?></b>
                <?php } else { ?>
                    Транспортна компанія: <b><?= $order->delivery_name ?></b>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                Отримувач: <?= $order->fio ?>
            </td>
            <td style="padding: 5px">
                Місто: <?= $order->city ?>
            </td>
        </tr>
        <tr>
            <td style="padding: 5px">
                Телефон: <?= $order->phone ?>
            </td>
            <td style="padding: 5px">
                <?php if ($type == 'delivery') { ?>
                    Район: <?= $region ?>
                <?php } else { ?>
                    Склад: <?= $order->warehouse; ?>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <?php if ($order->phone2 != '') { ?>
                <td style="padding: 5px">
                    Додатковий телефон: 1234567890
                </td>
            <?php } ?>
            <td colspan="<?= $order->phone2 == '' ? '2' : '1' ?>" style="padding: 5px">
                <?php if ($type == 'delivery') {
                    echo $street_type . ': ' . $street ?>
                <?php } else {
                    echo 'Адреса: ' . $order->address;
                } ?>
            </td>
        </tr>

        <?php if ($order->comment_address != '') { ?>
            <tr>
                <td colspan="2">
                    <b><?= $order->comment_address ?></b>
                </td>
            </tr>
        <?php } ?>

        <?php if ($type == 'sending') { ?>
            <tr>
                <td>
                    <b>Доставку оплачує: <?= $order->pay_delivery == 'sender' ? 'Відправник' : 'Отримувач' ?></b>
                </td>
                <td>
                    <b>Форма оплати: <?= $order->form_delivery == 'imposed' ? 'Готівкова' : 'Безготівкова' ?></b>
                </td>
            </tr>
            <?php if ($pay->type == 'remittance') { ?>
                <tr>
                    <td>
                        <b>Грошовий переказ: <?= number_format($pay->sum, 2) ?></b>
                    </td>
                    <td>
                        <b>Платник грошового переказу: <?= $pay->payer == 'sender' ? 'Відправник' : 'Отримувач' ?></b>
                    </td>
                </tr>
            <?php } ?>
        <?php } ?>

    </table>
</div>
<div class="table-container">
    <table class="table table-bordered">
        <tr>
            <td colspan="<?= $type == 'sending' ? '6' : '5' ?>" class="centered">
                <h1>Товари</h1>
            </td>
        </tr>

        <tr>
            <td colspan="1">
                Товар
            </td>
            <td colspan="1">
                Ідентифікатор складу
            </td>
            <td colspan="1">
                <b>Кількість</b>
            </td>
            <td colspan="1">
                <b>Номер місця</b>
            </td>
            <td colspan="1">
                Ціна одного
            </td>
            <td colspan="1">
                В сумі
            </td>
        </tr>

        <?php foreach ($products as $product) { ?>
            <tr>
                <td colspan="1">
                    <?= $product->name ?>
                </td>
                <td colspan="1">
                    <?= $product->identefire_storage ?>
                </td>
                <td colspan="1">
                    <b><?= $product->amount ?></b>
                </td>
                <td colspan="1">
                    <b><?= $product->place ?></b>
                </td>
                <td colspan="1">
                    <?= number_format($product->price, 2) ?>
                </td>
                <td colspan="1">
                    <?= number_format($product->sum, 2) ?>
                </td>
            </tr>
        <?php } ?>

        <tr>
            <td colspan="<?= $type == 'sending' ? '4' : '3' ?>"></td>
            <td colspan="1"><b>Доставка</b></td>
            <td colspan="1"><?= number_format($order->delivery_cost, 2) ?></td>
        </tr>
        <tr>
            <td colspan="<?= $type == 'sending' ? '4' : '3' ?>"></td>
            <td colspan="1"><b>Знижка</b></td>
            <td colspan="1"><?= number_format($order->discount, 2) ?></td>
        </tr>
        <tr>
            <td colspan="<?= $type == 'sending' ? '4' : '3' ?>"></td>
            <td colspan="1"><b>Сума</b></td>
            <td colspan="1"><b><?= number_format($sum, 2) ?></b></td>
        </tr>
        <?php if ($order->comment != '') { ?>
            <tr>
                <td colspan="<?= $type == 'sending' ? '6' : '5' ?>">
                    <?= $order->comment ?>
                </td>
            </tr>
        <?php } ?>

        <?php if ($order->type == 'sending') { ?>
            <tr>
                <td colspan="6">
                    <?php foreach ($places as $place_id => $place) { ?>
                        Місце <?= $place_id ?>: Вага - <?= $place->weight ?> кг., Об'єм - <?= $place->volume ?> м<sup>3</sup>.<br>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
</body>
</html>