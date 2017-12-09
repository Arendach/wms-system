<?php if (isset($attributes) && my_count($attributes) > 0) {
    foreach ($attributes as $attribute) { ?>
        <tr>
            <td><?= $attribute->name ?></td>
            <td><?= $attribute->placeholder ?></td>
            <td class="action-2">
                <a href="#" class="edit btn btn-primary btn-xs" data-id='<?= $attribute->id ?>' title="Редагувати">
                    <span class="glyphicon glyphicon-pencil"></span>
                </a>
                <a href="#" class="delete btn btn-danger btn-xs" data-id="<?= $attribute->id ?>" title="Видалити">
                    <span class="glyphicon glyphicon-remove"></span>
                </a>
            </td>
        </tr>
    <?php }
} else { ?>
    <tr>
        <td class="centered" colspan="3">
            <h4>Тут пусто :(</h4>
        </td>
    </tr>
<?php } ?>
