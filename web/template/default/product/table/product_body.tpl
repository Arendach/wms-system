<?php if (isset($empty_search) && $empty_search == true) { ?>
    <tr>
        <td colspan="10"><?php echo $search_not_found ?></td>
    </tr>
<?php } ?>

<?php if (isset($products) && my_count($products) > 0) {
    foreach ($products as $prod) { ?>
        <tr>
            <td><?= $prod->name ?></td>
            <td><?= $prod->count_on_storage ?></td>
            <td><?= $prod->type_product == 'combine' ? 'Комбінований' : 'Одиничний' ?></td>
            <td><?= $prod->category_name ?></td>
            <td><?= $prod->manufacturer_name ?></td>
            <td><?= $prod->storage_name ?></td>
            <td><?= $prod->articul ?></td>
            <td><?= $prod->identefire_storage ?></td>
            <td><?= $prod->costs ?></td>
            <td class="action-2">
                <a class="btn btn-primary btn-xs" href="<?= route('product_update', ['id' => $prod->id]) ?>">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a class="btn btn-primary btn-xs" href="<?= route('history_product', ['id' => $prod->id]) ?>">
                    <span class="glyphicon glyphicon-time"></span>
                </a>
            </td>
        </tr>
    <?php } ?>
<?php } else { ?>
    <tr>
        <td colspan="10" class="centered"><h4 class="text-muted">Нічого не знайдено :(</h4></td>
    </tr>
<?php } ?>