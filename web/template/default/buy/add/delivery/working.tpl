<div class="row right">
    <div class="col-md-4">
        <h4><b>Службова інформація</b></h4>
    </div>
</div>

<div class="type_block">

    <!-- Підказка -->

    <div class="form-group">
        <label for="hints" class="col-md-4 control-label">Підказка</label>
        <div class="col-md-5">
            <select id="hint" class="form-control field">
                <option value="0"></option>
                <?php if (isset($hints)) {
                    foreach ($hints as $hint) { ?>
                        <option value="<?= $hint->id; ?>"><?= $hint->description; ?></option>
                    <?php }
                } ?>
            </select>
        </div>
    </div>

    <!-- Дата доставки -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="date_delivery">
            Дата доставки <span class="text-danger">*</span>
        </label>
        <div class="col-md-5">
            <input value="<?= date('Y-m-d') ?>" id="date_delivery" type="date" class="form-control field" required>
        </div>
    </div>

    <!-- Градація по часу доставки -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="time_with">Градація по часу доставки</label>
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon">Від</span>
                <input id="time_with" class="form-control field">
            </div>

        </div>
    </div>

    <!-- Градація по часу доставки -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="time_to"></label>
        <div class="col-md-5">
            <div class="input-group">
                <span class="input-group-addon">ДО</span>
                <input id="time_to" class="form-control field">
            </div>
        </div>
    </div>

    <!-- Вибір курьєра -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="courier">Вибір курьєра</label>
        <div class="col-md-5">
            <select id="courier" class="form-control field">
                <?php if (isset($couriers)) {
                    foreach ($couriers as $courier) { ?>
                        <option value="<?= $courier->id ?>"><?= $courier->name ?></option>
                    <?php }
                } ?>
            </select>
        </div>
    </div>

    <!-- Номер дисконтної картки -->

    <div class="form-group">
        <label for="coupon" class="col-md-4 control-label">Номер дисконтної картки</label>
        <div class="col-md-5">
            <input id="coupon" class="form-control field">
        </div>
    </div>

    <!-- Номер дисконтної картки -->

    <div class="form-group none">
        <label class="col-md-4 control-label" for="coupon_search"></label>
        <div class="col-md-5">
            <select id="coupon_search" name="coupon_search" class="form-control" multiple></select>
        </div>
    </div>

    <!-- Коментар до замовлення -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="comment">Коментар до замовлення</label>
        <div class="col-md-5">
            <textarea class="form-control field" id="comment"></textarea>
        </div>
    </div>


</div>