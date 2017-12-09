<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Закупка по виробнику: "<?= $data->manufacturer_name ?>"</title>
    <style>
        table {
            font-family: "Lucida Sans Unicode", "Lucida Grande", Sans-Serif;
            font-size: 14px;
            border-collapse: collapse;
            text-align: center;
            width: 100%;
        }

        th, .custom td:first-child {
            background: #AFCDE7;
            color: white;
            padding: 10px 20px;
        }

        th, td {
            border-style: solid;
            border-width: 0 1px 1px 0;
            border-color: white;
        }

        td {
            background: #D8E6F3;
        }

        .custom th:first-child, .custom td:first-child {
            text-align: left;
        }
    </style>
</head>
<body>

<table>
    <tr>
        <th>Дата</th>
        <th>Виробник</th>
        <th>Сума</th>
        <th>Статус оплати</th>
        <th>Тип предзамовлення</th>
    </tr>
    <tr>
        <td><?= date_parse($data->date)['day'] . ' ' . int_to_month(date_parse($data->date)['month']) . ' ' . date_parse($data->date)['year'] ?></td>
        <td><?= $data->manufacturer_name ?></td>
        <td><?= $data->sum ?></td>
        <td>
            <?php if ($data->status == 0)
                echo 'Не оплачено';
            elseif ($data->status == 1)
                echo 'Сплачено частково';
            else
                echo 'Сплачено';
            ?>
        </td>
        <td><?= $data->type == 0 ? 'Потрібно закупити' : 'Прийнято на облік' ?></td>
    </tr>
</table>

<br><br>

<table class="custom">
    <tr>
        <th>Товар</th>
        <th>Кількість на складі(на даний момент)</th>
        <th>Необхідно закупити (одиниць)</th>
        <th>По ціні (грн)</th>
        <th>В сумі (грн)</th>
    </tr>
    <?php foreach ($data->products as $product) { ?>
        <tr>
            <td><?= $product->name ?></td>
            <td><?= $product->count_on_storage ?></td>
            <td><?= $product->amount ?></td>
            <td><?= $product->price ?></td>
            <td><?= $product->price * $product->amount ?></td>
        </tr>
    <?php } ?>
</table>

</body>
</html>