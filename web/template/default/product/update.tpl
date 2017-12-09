<?php
$volume = is_json_array($product->volume) ? json_decode($product->volume) : [0, 0, 0];
include parts('head');
?>
    <h2 class="sub-header">Редагування товару</h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('products'); ?>">Товари</a></li>
        <li class="active"><span>Редагування товару</span></li>
    </ol>


    <div class="right" style="margin-top: -10px; margin-bottom: 10px">
        <a href="<?= route('copy_product'); ?>" class="btn btn-primary copy">Копіювати</a>
        <?php if ($product->archive == 0) { ?>
            <a href="<?= route('to_archive', ['id' => $product->id]); ?>" class="btn btn-primary">В архів</a>
        <?php } else { ?>
            <a href="<?= route('un_archive', ['id' => $product->id]); ?>" class="btn btn-primary">Вернути з архіву</a>
        <?php } ?>
        <button id="deleteProd" type="button" class="btn btn-danger">Видалити</button>
    </div>

    <form id="form" class="form-horizontal">
        <div class="edit-block">
            <div class="form-group" style="margin-top: 10px">
                <label for="name" class="col-md-4 control-label">Назва</label>
                <div class="col-md-5">
                    <input name="name" value="<?= $product->name; ?>" class="form-control field" id="name">
                </div>
            </div>

            <div class="form-group">
                <label for="articul" class="col-md-4 control-label">Артикул</label>
                <div class="col-md-5">
                    <input value="<?= $product->articul; ?>" name="articul" class="form-control field" id="articul">
                </div>
            </div>

            <div class="form-group">
                <label for="model" class="col-md-4 control-label">Модель</label>
                <div class="col-md-5">
                    <input value="<?= $product->model; ?>" name="model" class="form-control field" id="model">
                </div>
            </div>

            <div class="form-group">
                <label for="identefire_storage" class="col-md-4 control-label">Ідентифікатор для складу</label>
                <div class="col-md-5">
                    <input value="<?= $product->identefire_storage; ?>" name="identefire_storage"
                           class="form-control field" id="identefire_storage">
                </div>
            </div>

            <div class="form-group">
                <label for="manufacturer" class="col-md-4 control-label">Виробник</label>
                <div class="col-md-5">
                    <select id="manufacturer" name="manufacturer" class="form-control field">
                        <?php if (isset($manufacturers)) {
                            foreach ($manufacturers as $m) { ?>
                                <option <?= $m->id == $product->manufacturer ? 'selected' : ''; ?>
                                        value="<?php echo $m->id ?>"><?php echo $m->name ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="storage" class="col-md-4 control-label">Склад</label>
                <div class="col-md-5">
                    <select id="storage" name="storage" class="form-control field">
                        <?php if (isset($storageList)) {
                            foreach ($storageList as $item) { ?>
                                <option <?= $item->id == $product->storage ? 'selected' : ''; ?>
                                        value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                            <?php }
                        } ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="services_code" class="col-md-4 control-label">Сервісний код</label>
                <div class="col-md-5">
                    <input value="<?= $product->services_code; ?>" name="services_code" class="form-control field"
                           id="services_code">
                </div>
            </div>

            <div class="form-group">
                <label for="weight" class="col-md-4 control-label">Вага</label>
                <div class="col-md-5">
                    <input value="<?= $product->weight; ?>" name="weight" class="form-control field" id="weight">
                </div>
            </div>

            <div class="form-group">
                <label for="volume" class="col-md-4 control-label">Об'єм</label>
                <div class="col-md-5">
                    <input style="width: 100px" class="volume-field" value="<?= $volume[0] ?>">
                    <input style="width: 100px" class="volume-field" value="<?= $volume[1] ?>">
                    <input style="width: 100px" class="volume-field" value="<?= $volume[2] ?>">
                    <br>
                    <br>
                    <input id="volume" value="<?= ($volume[0] * $volume[1] * $volume[2]) / 1000000; ?>" class="form-control"
                           disabled>
                </div>
            </div>

            <div class="form-group">
                <label for="procurement_costs" class="col-md-4 control-label">Закупівельна вартість</label>
                <div class="col-md-5">
                    <input value="<?= $product->procurement_costs; ?>" name="procurement_costs"
                           class="form-control field" id="procurement_costs">
                </div>
            </div>

            <div class="form-group">
                <label for="category" class="col-md-4 control-label">Категорія</label>
                <div class="col-md-5">
                    <select name="category" class="form-control field" id="category">
                        <option class="none" selected value="<?= $product->category; ?>">
                            <?= $product->category_name; ?>
                        </option>
                        <?= isset($categories) ? $categories : ''; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="costs" class="col-md-4 control-label">Вартість</label>
                <div class="col-md-5">
                    <input value="<?= $product->costs; ?>" name="costs" class="form-control field" id="costs">
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="col-md-4 control-label">Опис</label>
                <div class="col-md-5">
                    <textarea name="description" class="form-control field"
                              id="description"><?= $product->description; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="sort" class="col-md-4 control-label">Сортування</label>
                <div class="col-md-5">
                    <input name="sort" value="<?= $product->sort; ?>" class="form-control field" id="sort">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-offset-4 col-md-5">
                    <button class="btn btn-primary" id="update-info">Оновити</button>
                </div>
            </div>
        </div>


        <div class="edit-block">
            <div class="form-group">
                <label for="usr" class="col-md-4 control-label">Фото:</label>
                <div class="col-md-5">
                    <input type="file" class="form-control" id="image_upload">
                </div>
            </div>
            <div>
                <div class="thumbnail_img col-md-offset-4 col-md-5" style="margin-bottom: 15px">
                    <?php if (isset($photos) && my_count($photos) > 0) {
                        foreach ($photos as $thumbnail) { ?>
                            <div class="img_wrap">
                                <img src="<?= $thumbnail; ?>" class="img-thumbnail">
                                <span data-src="<?= $thumbnail; ?>" data-id="<?= $product->id ?>"
                                      class="deleteImg delete_image">X</span>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>

        </div>


        <div class="edit-block">
            <div class="form-group">
                <label for="typeProduct" class="col-md-4 control-label">Тип товару</label>
                <div class="col-md-5">
                    <select name="type_product" class="form-control" id="typeProduct">
                        <?php ?>
                        <option value="once">Товар одиничний</option>
                        <option value="combine" <?= isset($isCombine) ? 'selected' : '' ?>>Товар комбінований</option>
                    </select>
                </div>
            </div>

            <div class="combine-wrap <?= isset($isCombine) ? '' : 'none' ?>">
                <div class="form-group combine-prod">
                    <label for="finaleSum" class="col-md-4 control-label">Комбіновані</label>
                    <div class="col-md-5">
                        <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">
                            <span class="glyphicon glyphicon-search"></span>
                        </span>
                            <input id="searchCombine" class="form-control"
                                   placeholder="Пошук товарів для комбінування" aria-describedby="basic-addon1">
                            <span class="input-group-addon" id="closeSearchResult">x</span>
                        </div>

                        <div id="lsComb" class="list-group"></div>

                    </div>
                    <div class="col-md-offset-4 col-md-5">
                        <ul class="list-group" id="lsGrope">
                            <?php if (isset($CombineList)) { ?>
                                <?php print($CombineList) ?>
                            <?php } ?>

                            <li class="list-group-item justify-content-between">Остаточна сума
                                <input name="combine_sum" id="finaleSum" value="<?= $product->costs; ?>">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-4 col-md-5">
                    <button class="btn btn-primary" id="update-type">Оновити</button>
                </div>
            </div>
        </div>

        <div class="edit-block">
            <div class="form-group">
                <label for="usr" class="col-md-4 control-label">Атрибути:</label>

                <div class="col-md-5">
                    <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">
                        <span class="glyphicon glyphicon-search"></span>
                    </span>
                        <input id="search_attribute" class="form-control" placeholder="Пошук атрибутів"
                               aria-describedby="basic-addon1">
                        <span class="input-group-addon" id="closeSearchResult">x</span>
                    </div>

                    <div id="attrList" class="list-group"></div>
                </div>

                <div id="attrInputsList" class="col-md-offset-4 col-md-5">
                    <?php
                    $attributes = json_decode($product->attributes);
                    if (my_count($attributes) > 0) {
                        foreach ($attributes as $key => $value) {
                            foreach ($value as $k => $v) { ?>
                                <div class='input-group'>
                                    <span class="input-group-addon"><?= $key; ?></span>
                                    <input id="usr" value="<?= $v; ?>" class="attribute form-control"
                                           data-name="<?= $key ?>">
                                    <span class="input-group-addon delFromAttrList">[x]</span>
                                </div>
                            <?php }
                        }
                    } ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-4 col-md-5">
                    <button class="btn btn-primary" id="update-attribute">Оновити</button>
                </div>
            </div>
        </div>

    </form>

    <script>
        id = '<?=$product->id;?>';
    </script>
<?php $this->inc('/parts/footer'); ?>