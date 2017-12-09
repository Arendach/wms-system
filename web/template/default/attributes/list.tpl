<?php foreach ($attrs as $key => $item) { ?>
    <a href="#" data-value="<?= $item->placeholder; ?>" data-id="<?= $item->id; ?>" data-name="<?= $item->name; ?>"
       class="list-group-item listAttrClick"><?= $item->name; ?></a>
<?php } ?>
