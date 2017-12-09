<?php
use Web\Tools\HTML;
?>

<?php include parts('head') ?>

<!-- Title -->

<h2 class="sub-header"><?= $section ?></h2>

<!-- Breadcrumbs -->

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <?php if ($archive === true) { ?>
        <li><a href="<?= route('products'); ?>">Товари</a></li>
        <li class="active"><span>Архів товарів</span></li>
    <?php } else { ?>
        <li><a href="<?= route('products_archive'); ?>">Архів товарів</a></li>
        <li class="active"><span>Товари</span></li>
    <?php } ?>
</ol>

<!-- Add buttton -->

<div class="right" style="margin-bottom: 10px">
    <a href="<?= route('add_product') ?>" class="btn btn-primary">Додати</a>
</div>

<!-- Table -->

<div class="table-responsive">
    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead class="head-center">
        <tr>
            <th>Назва <br><br>
                <input data-action="search" data-column="products-name" class="form-control"
                       value="<?= get('products-name'); ?>">
            </th>
            <th>
                <a class="sort" data-by="<?= HTML::order_by('count_on_storage') ?>" data-field="count_on_storage" href="#">Кількість на складі  <?= HTML::order_by_sym('count_on_storage') ?></a><br><br>
                <input data-action="search" data-column="products-count_on_storage" class="form-control"
                       value="<?= get('products-count_on_storage'); ?>"></th>
            <th>Тип товару<br><br>
                <select data-action="search" data-column="products-type_product" class="form-control">
                    <option value=""></option>
                    <option <?= get('products-type_product') == 'combine' ? 'selected' : '' ?> value="combine">
                        Комбіновані
                    </option>
                    <option <?= get('products-type_product') == 'once' ? 'selected' : '' ?> value="once">
                        Одиничні
                    </option>
                </select>
            </th>
            <th>Категорія<br><br>
                <input data-action="search" data-column="categories-name" class="form-control"
                       value="<?= get('categories-name'); ?>"></th>
            <th>Виробник<br><br>
                <input data-action="search" data-column="manufacturers-name" class="form-control"
                       value="<?= get('manufacturers-name'); ?>"></th>
            <th>
                Склад <br><br>
                <select data-action="search" data-column="products-storage" class="form-control">
                    <option value=""></option>
                    <?php foreach ($storage as $item) { ?>
                        <option <?= get('products-storage') == $item->id ? 'selected' : '' ?>
                                value="<?= $item->id ?>"><?= $item->name ?></option>
                    <?php } ?>
                </select>

            </th>
            <th>Артикул <br><br>
                <input data-action="search" data-column="products-articul" class="form-control"
                       value="<?= get('products-articul'); ?>"></th>
            <th>Ідентифікатор складу <br><br>
                <input data-action="search" data-column="products-identefire_storage" class="form-control"
                       value="<?= get('products-identefire_storage'); ?>"></th>
            <th>
                <a class="sort" data-by="<?= HTML::order_by('costs') ?>" data-field="costs" href="#">Ціна <?= HTML::order_by_sym('costs') ?> </a><br><br>

                <input data-action="search" data-column="products-costs" class="form-control"
                       value="<?= get('products-costs'); ?>"></th>
            <th>Дія
                <br><br>
                <button class="btn btn-primary" id="search"><span class="glyphicon glyphicon-search"></span>
                </button>
            </th>
        </tr>
        </thead>
        <tbody id="tableProduct">
        <?php include t_file('product/table/product_body') ?>
        </tbody>

    </table>
</div>

<!-- Paginate -->

<div class="centered">
    <?php include parts('paginate') ?>
</div>

<?php include parts('footer') ?>
