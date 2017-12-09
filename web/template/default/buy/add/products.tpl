
<!-- Пошук товарів -->

<div class="new_product_block form-group">
    <div class="search_product">
        <div class="col-md-4">
            <input id="search_ser_code" placeholder="Сервісний код" class="form-control input-md">
        </div>
        <div class="col-md-4">
            <select id="categories_pr" class="col-md-4 form-control">
                <option value="0"></option>
                <?= $categories ?>
            </select>
        </div>
        <div class="col-md-4">
            <input id="search_name" placeholder="Назва" class="form-control input-md"/>
        </div>
        <div class="col-md-12">
            <select class="products form-control" multiple></select>
        </div>
    </div>
    <button class="btn btn-primary" id="select_products">Вибрати</button>
</div>

<!-- Таблиця товарів -->

<div class="products-order">
    <table id="list_products" class="table table-bordered">
        <thead>
        <th>Назва товару</th>
        <th>Ідентифікатор складу</th>
        <th>Артикул</th>
        <th>Кількість</th>
        <th>Вартість</th>
        <th>Сума</th>
        <th>Аттрибути</th>
        <?= $type == 'sending' ? '<th>Номер місця</th>' : '' ?>
        <th>Дії</th>
        </thead>
        <tbody></tbody>
    </table>
</div>