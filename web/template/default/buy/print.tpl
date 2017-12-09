<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>Замовлення</title>
    <?= style($link_css) ?>
</head>
<body>
<div style="page-break-after: always;">
    <h1>Товарний чек</h1>
    <div class="div1">
        <table width="100%">
            <tr>
                <td>
                    www.Vozdushno.com.ua<br/>
                    Телефон 044-578-01-41<br/>
                    zakaz@skyfire.kiev.ua<br/>
                </td>
                <td align="right" valign="top">
                    <table>
                        <tr>
                            <td><b>Дата виписки рахунку:</b></td>
                            <td><?= date('Y-m-d h:i:s'); ?></td>
                        </tr>
                        <tr>
                            <td><h2>№ Замовлення:</h2></td>
                            <td><h2><?= $order->id; ?></h2></td>
                        </tr>
                        <tr>
                            <td><h2>Номер картки:</h2></td>
                            <td><h2><?= $order->coupon ?></h2></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <table class="address">
        <tr class="heading">
            <td><b>Інформація по замовленню</b></td>
        </tr>
        <tr>
            <td>
                <h3><?= $order->fio . ' ' . $order->phone; ?>
                    <br>
                    <?= $order->address; ?>
                    <br>
                    <?= $order->city ?>
                </h3>
                <div>Дата: <?= $order->date_delivery; ?></div>
                <div>Проміжок часу: з <?= $order->time_with . ' до ' . $order->time_to; ?></div>
                <div>Район: <?= $order->region; ?></div>
            </td>
        </tr>
        <tr>
            <td><h3>Номер телефона: <?= $order->phone; ?></h3></td>
        </tr>
    </table>
    <table class="product">
        <tr class="heading">
            <td><b>Товар</b></td>
            <td><b>Ідентифікатор складу</b></td>
            <td align="right"><b>Кількість</b></td>
            <td align="right"><b>Ціна за одиницю</b></td>
            <td align="right"><b>Всього</b></td>
        </tr>
        <?php $products_cost = 0;
        foreach ($products as $item) :
        $products_cost += $item['amount'] * $item['price']; ?>
        <tr>
            <td><?= $item['name']; ?>               </td>
            <td><?= $item['identefire_storage'] ?></td>
            <td align="right"><?= $item['amount'] ?></td>
            <td align="right"><?= $item['price'] ?></td>
            <td align="right"><?= $item['amount'] * $item['price']; ?></td>
        </tr>
        <?php endforeach; ?>

    </table>

    <table class="product">
        <tr>
            <td align="right" width="80%"><h4>За товари</h4></td>
            <td align="right"><h4><?= $products_cost; ?> грн.</h4></td>
        </tr>
        <tr>
            <td align="right" width="80%"><h4>Доставка</h4></td>
            <td align="right"><h4><?= $order->delivery_cost; ?> грн.</h4></td>
        </tr>
        <tr>
            <td align="right" width="80%"><h4>Знижка</h4></td>
            <td align="right"><h4><?= $order->discount; ?> грн</h4></td>
        </tr>
        <tr>
            <td align="right" width="80%"><h4>В загальному</h4></td>
            <td align="right"><h4><?= $products_cost + $order->delivery_cost - $order->discount; ?> грн.</h4></td>
        </tr>
    </table>
    <table class="product">
        <tr class="heading">
            <td><b>Коментар до замовлення</b></td>
        </tr>
        <tr>
            <td><?= $order->comment; ?></td>
        </tr>
    </table>
</div>
</body>
</html>