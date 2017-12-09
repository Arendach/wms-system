<?php $this->inc('/parts/head') ?>
    <div class="row">
        <div class="col-md-12">

            <div class="placeForError"></div>

            <!--<div class="pull-right">
                <a href="products" class="btn btn-primary">Історія товару</a>
                <a href="products" class="btn btn-primary">Роздрукувати СЕРВІСНИЙ КОД</a>
                <a href="products" class="btn btn-primary">Фільтр</a>
                <a href="products/add" class="btn btn-primary">Додати</a>
                <button id="deleteSelected" type="button" class="btn btn-danger">Видалити</button>
                <a href="products/toarhive" class="btn btn-primary">В архів</a>
            </div>-->
        </div>
    </div>
    <h2 class="sub-header"><?php echo $section ?></h2>
<?php foreach ($histories as $history) { ?>
    <?php $data = json_decode($history->data); ?>
    <?php if ($history->type == 'edit_product') { ?>
        <div class="dropdown_block" id="<?= $history->id ?>">
            <div class="dropdown_list">
                <div class="btn"><span class="caret sym"></span></div>
                <div class="parent">20<?= date('y-m-d h:i', $history->date); ?> <span class="update_product_change">Обновлення інформації про продукт</span>
                </div>
            </div>
            <ul class="cities_list">
                <?php if (isset($data->name)) { ?>
                    <li><span class="text-primary">Імя: </span> <?= $data->name; ?> </li> <?php } ?>
                <?php if (isset($data->articul)) { ?>
                    <li><span class="text-primary">Артикул: </span> <?= $data->articul; ?> </li> <?php } ?>
                <?php if (isset($data->description)) { ?>
                    <li><span class="text-primary">Опис: </span> <?= $data->description; ?> </li> <?php } ?>
                <?php if (isset($data->model)) { ?>
                    <li><span class="text-primary">Модель: </span> <?= $data->model; ?> </li> <?php } ?>
                <?php if (isset($data->identifire_storage)) { ?>
                    <li><span class="text-primary">Ідентифікатор складу: </span> <?= $data->identifire_storage; ?>
                    </li> <?php } ?>
                <?php if (isset($data->services_code)) { ?>
                    <li><span class="text-primary">Сервісний код: </span> <?= $data->services_code; ?> </li> <?php } ?>
                <?php if (isset($data->procurement_costs)) { ?>
                    <li><span class="text-primary">Закупівельна вартість: </span> <?= $data->procurement_costs; ?>
                    </li> <?php } ?>
                <?php if (isset($data->type_product)) { ?>
                    <li><span class="text-primary">Тип товару: </span> <?= $data->type_product; ?> </li> <?php } ?>
                <?php if (isset($data->count_on_storage)) { ?>
                    <li><span class="text-primary">Кількість на складі: </span> <?= $data->count_on_storage; ?>
                    </li> <?php } ?>
                <?php if (isset($data->costs)) { ?>
                    <li><span class="text-primary">Ціна: </span> <?= $data->costs; ?> </li> <?php } ?>
                <?php if (isset($data->attr_id)) { ?>
                    <li><span class="text-primary">Аттрибути: </span> <?= $data->attr_id; ?> </li> <?php } ?>
                <?php if (isset($data->storage)) { ?>
                    <li><span class="text-primary">Склад: </span> <?= $data->storage; ?> </li> <?php } ?>
                <?php if (isset($data->main_image)) { ?>
                    <li><span class="text-primary">Головне зображення: </span> <?= $data->main_image; ?>
                    </li> <?php } ?>
                <?php if (isset($data->images)) { ?>
                    <li><span class="text-primary">Інші зображення: </span>
                        <?php foreach ($data->images as $image) {
                            if (file_exists(UPLOADEDIR . $image)) { ?>
                                <a href="<?= UPLOADEDIR . $image; ?>"><img src="<?= UPLOADEDIR . $image; ?>"
                                                                           width="50px" alt=""></a>
                            <?php } else { ?>
                                <span class="text-danger">Файл видалений</span>
                            <?php }
                        } ?>
                    </li> <?php } ?>
                <?php if (isset($data->price)) { ?>
                    <li><span class="text-primary">Ціна: </span> <?= $data->price; ?> </li> <?php } ?>
                <?php if (isset($data->sort)) { ?>
                    <li><span class="text-primary">Сортувати: </span> <?= $data->sort; ?> </li> <?php } ?>
                <?php if (isset($data->archive)) { ?>
                    <li><span class="text-primary">Архівування: </span> <?= $data->archive; ?> </li> <?php } ?>
            </ul>
        </div>
    <?php } elseif ($history->type == 'add_photo') { ?>
        <div class="dropdown_block" id="<?= $history->id ?>">
            <div class="dropdown_list">
                <div class="btn"><span class="caret sym"></span></div>
                <div class="parent">20<?= date('y-m-d h:i', $history->date); ?> <span class="update_product_change">Додано нове фото</span>
                </div>
            </div>
            <ul class="cities_list">
                <?php if (file_exists(UPLOADEDIR . $history->data)) { ?>
                    <li><a href="<?= UPLOADIMGDIR . $history->data; ?>"><img src="<?= UPLOADIMGDIR . $history->data; ?>"
                                                                             height="150px" alt=""></a></li>
                <?php } else { ?>
                    <li><span class="text-primary">Файл: </span><?= basename($history->data); ?> <span
                                class="text-danger">видалений</span></li>
                <?php } ?>
            </ul>
        </div>
    <?php } elseif ($history->type == 'add_to_order') { ?>
        <?php $data = json_decode($history->data); ?>
        <div class="dropdown_block" id="<?= $history->id ?>">
            <div class="dropdown_list">
                <div class="btn"><span class="caret sym"></span></div>
                <div class="parent"><?= $history->date; ?> <span class="update_product_change">Товар додано до замовлення</span>
                </div>
            </div>
            <ul class="cities_list">
                <li><span class="text-success"><?= $data->amount; ?></span> одиниць товару додано в замовлення
                    <a href="<?= SITE; ?>/orders/edit/<?= $data->order; ?>"><span
                                class="text-primary">№<?= $data->order; ?></span></a></li>
            </ul>
        </div>
    <?php } elseif ($history->type == 'edit_in_order'){
        $data = json_decode($history->data);
    } ?>
<?php } ?>
<?php $this->inc('/parts/footer') ?>