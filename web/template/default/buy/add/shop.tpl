<!-- Основна інформація -->


<div class="row right">
    <div class="col-md-4">
        <h4><b>Основна інформація</b></h4>
    </div>
</div>

<div class="type_block">

    <div class="form-group">
        <label class="col-md-4 control-label" for="date_delivery">
            Дата доставки <span class="text-danger">*</span>
        </label>
        <div class="col-md-5">
            <input value="<?= date('Y-m-d') ?>" id="date_delivery" type="date" class="form-control field" required>
        </div>
    </div>

</div>


<!-- Адреса -->


<div class="row right">
    <div class="col-md-4">
        <h4><b>Адреса</b></h4>
    </div>
</div>

<div class="type_block">

    <div class="form-group">
        <label class="col-md-4 control-label" for="address">Адреса</label>
        <div class="col-md-5">
            <input id="address" class="form-control field" value="<?= $address ?>">
        </div>
    </div>

</div>

<!-- Оплата -->

<div class="row right">
    <div class="col-md-4">
        <h4><b>Варіант оплати</b></h4>
    </div>
</div>

<div class="type_block">

    <!-- Варіант оплати -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="pay_method">
            Варіант оплати <span class="text-danger">*</span>
        </label>
        <div class="col-md-5">
            <select required id="pay_method" class="form-control field">
                <?php if (isset($pays)) {
                    foreach ($pays as $pay) { ?>
                        <option value="<?= $pay->id ?>"><?= $pay->name ?></option>
                    <?php }
                } ?>
            </select>
        </div>
    </div>

</div>