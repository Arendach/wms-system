<?php include parts('modal_head') ?>

    <div class="form-group">
        <label for="name_operation">Назва операції</label>
        <input class="form-control" id="name_operation" value='Закупка по виробнику "<?= $item->manufacturer_name ?>"'>
    </div>

    <div class="form-group">
        <label for="comment">Коментар</label>
        <textarea class="form-control" id="comment"></textarea>
    </div>

    <div class="form-group">
        <button class="btn btn-primary" id="close">Закрити закупку</button>
    </div>


<?php include parts('modal_foot') ?>