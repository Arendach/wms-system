<form id="form_order" class="form-horizontal">

    <div class="row right">
        <div class="col-md-4">
            <h4><b>Статус</b></h4>
        </div>
    </div>

    <!-- STATUS -->

    <div class="type_block">

        <div class="form-group">
            <label for="status" class="control-label col-md-4">Статус</label>
            <div class="col-md-5">
                <select id="status" class="form-control field">
                    <?= get_order_statuses('shop', $order->status); ?>
                </select>
            </div>
        </div>

        <!-- Button -->

        <div class="form-group">
            <div class="col-md-offset-4 col-md-5">
                <button class="btn btn-primary" id="update_status">Оновити дані</button>
            </div>
        </div>

    </div>

    <div class="row right">
        <div class="col-md-4">
            <h4><b>Основна інформація</b></h4>
        </div>
    </div>

    <div class="type_block">

        <!-- Дата доставки -->

        <div class="form-group">
            <label class="col-md-4 control-label" for="date_delivery">Дата доставки <span
                        class="text-danger">*</span></label>
            <div class="col-md-5">
                <input id="date_delivery" type="date" class="form-control" required
                       value="<?= $order->date_delivery; ?>">
            </div>
        </div>


        <!-- Button -->

        <div class="form-group">
            <div class="col-md-offset-4 col-md-5">
                <button class="btn btn-primary" id="update_working">Оновити дані</button>
            </div>
        </div>

    </div>

    <div class="row right">
        <div class="col-md-4">
            <h4><b>Адреса</b></h4>
        </div>
    </div>

    <div class="type_block">

        <!-- Адреса -->

        <div class="form-group">
            <label class="col-md-4 control-label" for="address">Адреса</label>
            <div class="col-md-5">
                <input id="address" class="form-control" value="<?= $order->address; ?>">
            </div>
        </div>

        <!-- Button -->

        <div class="form-group">
            <div class="col-md-offset-4 col-md-5">
                <button class="btn btn-primary" id="update_address">Оновити дані</button>
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
                            <option <?= $pay->id == $order->pay_method ? 'selected' : '' ?>
                                    value="<?= $pay->id ?>"><?= $pay->name ?></option>
                        <?php }
                    } ?>
                </select>
            </div>
        </div>

        <!-- Button -->

        <div class="form-group">
            <div class="col-md-offset-4 col-md-5">
                <button class="btn btn-primary" id="update_pay">Оновити дані</button>
            </div>
        </div>


    </div>

</form>