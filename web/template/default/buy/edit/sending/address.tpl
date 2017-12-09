<div class="row right">
    <div class="col-md-4">
        <h4><b>Адреса</b></h4>
    </div>
</div>

<div class="type_block">

    <?php if ($order->logistic_name == 'НоваПошта') { ?>

        <!-- Місто -->

        <div class="form-group">
            <label class="col-md-4 control-label" for="city_input">Місто <span class="text-danger">*</span></label>
            <div class="col-md-5">
                <div class="input-group">
                    <input class="form-control" placeholder="Введіть 3 символи" id="city_input" required
                           value="<?= $order->city_name ?>">
                    <span class="input-group-addon pointer clear" data-id="city_input">X</span>
                </div>
            </div>
        </div>

        <input type="hidden" id="city" name="city" class="form-control field" value="<?= $order->city; ?>">

        <div class="form-group none" id="city_select_container">
            <label class="col-md-4 control-label" for="city_select"></label>
            <div class="col-md-5">
                <select id="city_select" class="form-control" multiple></select>
                <span class="btn btn-danger btn-xs hiden close_multiple" data-id="city_select_container">X</span>
            </div>
        </div>

        <!-- Відділення -->

        <div class="form-group">
            <label class="col-md-4 control-label" for="warehouse">
                Відділення <span class="text-danger">*</span>
            </label>
            <div class="col-md-5">
                <select <?= $warehouses['disabled'] === true ? 'disabled' : '' ?> id="warehouse" class="form-control">
                    <?php foreach ($warehouses['data'] as $warehouse) { ?>
                        <option <?= $warehouse['Ref'] == $order->warehouse ? 'selected' : '' ?>
                                value="<?= $warehouse['Ref'] ?>">
                            <?= $warehouse['Description'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="form-group none">
            <label class="col-md-4 control-label" for="warehouse_search"></label>
            <div class="col-md-5">
                <select id="warehouse_search" name="warehouse_search" class="form-control" multiple></select>
            </div>
        </div>

    <?php } else { ?>

        <div class="form-group">
            <label class="col-md-4 control-label" for="city">Місто <span class="text-danger">*</span></label>
            <div class="col-md-5">
                <input class="form-control" id="city" value="<?= $order->city ?>">
            </div>
        </div>


        <!-- Відділення -->

        <div class="form-group">
            <label class="col-md-4 control-label" for="warehouse">
                Відділення <span class="text-danger">*</span>
            </label>
            <div class="col-md-5">
                <input id="warehouse" class="form-control" value="<?= $order->warehouse ?>">
            </div>
        </div>

    <?php } ?>

    <!-- Адреса -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="warehouse">Адреса</label>
        <div class="col-md-5">
            <input id="address" class="form-control" value="<?= $order->address ?>">
        </div>
    </div>

    <!-- Button -->

    <div class="form-group">
        <div class="col-md-offset-4 col-md-5">
            <button class="btn btn-primary" id="update_address">Оновити дані</button>
        </div>
    </div>

</div>