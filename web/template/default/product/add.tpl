<?php $this->inc('/parts/head') ?>
    <h2 class="sub-header"><?= isset($section) ? $section : '' ?></h2>
    <form class="form-horizontal">

        <div class="form-group">
            <label for="inputName" class="col-md-4 control-label">Назва</label>
            <div class="col-md-5">
                <input data-type="field" name="name" value="<?= isset($name) ? $name : '' ?>" class="form-control"
                       id="inputName">
            </div>
        </div>

        <div class="form-group">
            <label for="articul" class="col-md-4 control-label">Артикул</label>
            <div class="col-md-5">
                <input data-type="field" name="articul" class="form-control" id="inputName">
            </div>
        </div>

        <div class="form-group">
            <label for="inputName" class="col-md-4 control-label">Модель</label>
            <div class="col-md-5">
                <input data-type="field" name="model" class="form-control" id="inputName">
            </div>
        </div>

        <div class="form-group">
            <label for="inputName" class="col-md-4 control-label">Ідентифікатор для складу</label>
            <div class="col-md-5">
                <input data-type="field" name="identefire_storage" class="form-control" id="inputName">
            </div>
        </div>

        <div class="form-group">
            <label for="manufacturer" class="col-md-4 control-label">Виробник</label>
            <div class="col-md-5">
                <select data-type="field" id="manufacturer" name="manufacturer" class="form-control">
                    <?php if (isset($manufacturers)) {
                        foreach ($manufacturers as $m) { ?>
                            <option value="<?php echo $m->id ?>"><?php echo $m->name ?></option>
                        <?php }
                    } ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="storage" class="col-md-4 control-label">Cклад</label>
            <div class="col-md-5">
                <select data-type="field" id="storage" name="storage" class="form-control">
                    <?php if (isset($storageList)) {
                        foreach ($storageList as $stor) { ?>
                            <option value="<?php print($stor->id) ?>"><?php print($stor->name) ?></option>
                        <?php }
                    } ?>
                    <option value="0" class="none"></option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="weight" class="col-md-4 control-label">Вага</label>
            <div class="col-md-5">
                <input data-type="field" name="weight" value="0" class="form-control" id="weight">
            </div>
        </div>

        <div class="form-group">
            <label for="volume" class="col-md-4 control-label">Об'єм</label>
            <div class="col-md-5">
                <input style="width: 100px" class="volume-field" value="0">
                <input style="width: 100px" class="volume-field" value="0">
                <input style="width: 100px" class="volume-field" value="0">
                <br>
                <br>
                <input id="volume" value="" class="form-control" disabled>
            </div>
        </div>

        <div class="form-group">
            <label for="procurement_costs" class="col-md-4 control-label">Закупівельна вартість</label>
            <div class="col-md-5">
                <input data-type="field" name="procurement_costs" class="form-control" id="procurement_costs">
            </div>
        </div>

        <div class="form-group">
            <label for="product_category" class="col-md-4 control-label">Категорії продуктів</label>
            <div class="col-md-5">
                <select data-type="field" id="product_category" name="category" class="form-control">
                    <option value="" class="none"></option>
                    <?= isset($categories) ? $categories : '' ?>
                </select>
            </div>
        </div>

        <div id="services_code_container" class="form-group" style="display: none">
            <label for="services_code" class="col-md-4 control-label">Сервісний код</label>
            <div class="col-md-5">
                <input disabled data-type="field" name="services_code" class="form-control" id="services_code">
            </div>
        </div>

        <div class="form-group">
            <label for="typeProduct" class="col-md-4 control-label">Тип товару</label>
            <div class="col-md-5">
                <select data-type="field" name="type_product" class="form-control" id="typeProduct">
                    <option value="once">Товар одиничний</option>
                    <option value="combine">Товар комбінований</option>
                </select>
            </div>
        </div>

        <div class="combine-wrap hideMe">
            <div class="form-group combine-prod">
                <label for="" class="col-md-4 control-label">Комбіновані</label>
                <div class="col-sm-5">

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
                <label for="finaleSum" class="col-md-4 control-label"></label>
                <div class="col-md-5">
                    <ul class="list-group" id="lsGrope">
                        <li class="list-group-item justify-content-between">Остаточна сума
                            <input id="finaleSum" value="0">
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="costs" class="col-md-4 control-label">Вартість</label>
            <div class="col-md-5">
                <input data-type="field" name="costs" class="form-control" id="costs">
            </div>
        </div>

        <div class="form-group">
            <div class="thumbnail_img col-sm-offset-4 col-md-5">
                <?php if (isset($images) && my_count($images) > 0) {
                    foreach ($images as $item) { ?>
                        <div class="img_wrap">
                            <img src="<?= $item; ?>" class="img-thumbnail">
                            <span data-path="<?= $item; ?>" class="deleteImg">X</span>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <label for="usr" class="col-md-4 control-label">IMG:</label>
            <div class="col-md-5">
                <input type="file" name="image_upload" class="form-control" id="image_upload">
            </div>
        </div>

        <div class="form-group">
            <label for="search_attribute" class="col-md-4 control-label">Атрибути:</label>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon1">
                        <span class="glyphicon glyphicon-search"></span>
                    </span>
                    <input data-column="" id="search_attribute" class="form-control" placeholder="Пошук атрибутів"
                           aria-describedby="basic-addon1">
                    <span class="input-group-addon" id="closeSearchResult">x</span>
                </div>

                <div id="attrList" class="list-group"></div>
            </div>
            <div id="attrInputsList" class="col-sm-offset-4 col-md-5"></div>
        </div>

        <div class="form-group">
            <label for="sort" class="col-md-4 control-label">Сортування</label>
            <div class="col-md-5">
                <input data-type="field" name="sort" class="form-control"
                       id="sort" placeholder="Порядок Сортування">
            </div>
        </div>

        <div class="form-group">
            <label for="description" class="col-md-4 control-label">Опис</label>
            <div class="col-md-5">
                <textarea data-type="field" name="description" class="form-control"
                          id="description"></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-md-5">
                <button id="create" class="btn btn-primary">Створити</button>
            </div>
        </div>

    </form>
<?php $this->inc('/parts/footer') ?>