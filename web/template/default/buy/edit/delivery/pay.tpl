<div class="row right">
    <div class="col-md-4">
        <h4><b>Оплата</b></h4>
    </div>
</div>

<div class="type_block">

    <!-- Варіант оплати -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="pay_method">Варіант оплати</label>
        <div class="col-md-5">
            <select id="pay_method" class="form-control">
                <?php foreach ($pays as $pay) { ?>
                    <option <?= $order->pay_method == $pay->id ? 'selected' : ''; ?>
                            value="<?= $pay->id ?>"><?= $pay->name ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Предоплата -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="payment_status">Предоплата</label>
        <div class="col-md-5">
            <input id="prepayment" class="form-control" value="<?= $order->prepayment ?>">
        </div>
    </div>

    <!-- Кнопка -->

    <div class="form-group">
        <div class="col-md-4"></div>
        <div class="col-md-5">
            <button class="btn btn-primary" id="update_pay">Оновити дані</button>
        </div>
    </div>

</div>