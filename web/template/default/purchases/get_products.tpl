<?php foreach ($items as $item) { ?>
    <tr class="product" data-id="<?= $item->id ?>">
        <td><?= $item['name'] ?></td>
        <td><?= $item['count_on_storage'] ?></td>
        <td><input class="form-control price" value="<?= $item['costs'] ?>"></td>
        <td><input class="form-control amount" value="1"></td>
        <td class="action-1">
            <button class="btn btn-danger btn-xs">
                <span class="glyphicon glyphicon-remove delete"></span>
            </button>
        </td>
    </tr>
<?php } ?>