<?php foreach ($options as $item) { ?>
    <a href="#" data-id="<?php echo $item->id ?>" class="list-group-item lsComboClick"
       data-name="<?php echo $item->name ?>" data-price="<?php echo $item->costs ?>"><?php echo $item->name ?></a>
<?php } ?>