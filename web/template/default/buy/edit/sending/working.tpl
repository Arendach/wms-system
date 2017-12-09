<div class="row right">
    <div class="col-md-4">
        <h4><b>Службова інформація</b></h4>
    </div>
</div>

<div class="type_block">

    <!-- Підказка -->

    <div class="form-group">
        <label for="hint" class="col-md-4 control-label">Підказка</label>
        <div class="col-md-5">
            <select id="hint" class="form-control">
                <option value="0"></option>
                <?php foreach ($hints as $hint) { ?>
                <option <?= $order->hint == $hint->id ? 'selected' : ''; ?>
                        value="<?= $hint->id; ?>"><?= $hint->description; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Доставка -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="delivery">Транспортна компанія</label>
        <div class="col-md-5">
            <select id="delivery" class="form-control">
                <?php foreach ($deliveries as $delivery) { ?>
                <option <?= $order->delivery == $delivery->id ? 'selected' : ''; ?>
                        value="<?= $delivery->id ?>"><?= $delivery->name ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Дата доставки -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="date_delivery">
            Дата доставки <span class="text-danger">*</span>
        </label>
        <div class="col-md-5">
            <input id="date_delivery" type="date" class="form-control" required value="<?= $order->date_delivery ?>">
        </div>
    </div>

    <!-- Вибір курьєра -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="courier">Курєр</label>
        <div class="col-md-5">
            <select id="courier" class="form-control">
                <?php foreach ($couriers as $courier) { ?>
                <option <?= $order->courier == $courier->id ? 'selected' : ''; ?>
                        value="<?= $courier->id ?>"><?= $courier->name ?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Номер дисконтної картки -->

    <div class="form-group">
        <label for="coupon" class="col-md-4 control-label">Номер дисконтної картки</label>
        <div class="col-md-5">
            <input placeholder="Введіть 3 символи" id="coupon" class="form-control" value="<?= $order->coupon; ?>">
        </div>
    </div>

    <!-- Пошук купонів -->

    <div class="form-group none" id="coupon_search_container">
        <label class="col-md-4 control-label" for="coupon_search"></label>
        <div class="col-md-5">
            <select id="coupon_search" class="form-control" multiple></select>
            <span class="btn btn-danger btn-xs hiden close_multiple" data-id="coupon_search_container">X</span>
        </div>
    </div>

    <!-- Коментар до замовлення -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="comment">Коментар до замовлення</label>
        <div class="col-md-5">
            <textarea class="form-control" id="comment"><?= $order->comment; ?></textarea>
        </div>
    </div>

    <!-- Кнопка -->

    <div class="form-group">
        <div class="col-md-4"></div>
        <div class="col-md-5">
            <button class="btn btn-primary" id="update_working">Оновити дані</button>
        </div>
    </div>

</div>