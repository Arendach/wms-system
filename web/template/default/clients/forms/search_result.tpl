<?php foreach ($data as $item) { ?>
    <tr class="order_row" data-id="<?= $item->id; ?>">
        <td><?= $item->id; ?></td>
        <td><?= $item->fio; ?></td>
        <td><?= $item->phone; ?></td>
        <td><?= $item->date; ?></td>
        <td></td>
    </tr>
<?php } ?>