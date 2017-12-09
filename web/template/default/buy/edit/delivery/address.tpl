<div class="row right">
    <div class="col-md-4">
        <h4><b>Адреса</b></h4>
    </div>
</div>


<div class="type_block">

    <!-- Місто -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="city">Місто <span class="text-danger">*</span></label>
        <div class="col-md-5">
            <input id="city" required class="form-control"
                   value="<?= $order->city ?>">
        </div>
    </div>

    <!-- Місто -->

    <div class="form-group none" id="city_select_container">
        <label class="col-md-4 control-label" for="city_select"></label>
        <div class="col-md-5">
            <select id="city_select" class="form-control" multiple></select>
            <span class="btn btn-danger btn-xs hiden close_multiple" data-id="city_select_container">X</span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-md-4 control-label" for="street">Вулиця</label>
        <div class="col-md-5">
            <input id="street" class="form-control" value="<?= $order->street ?>">
        </div>
    </div>

    <div class="form-group none" id="street_select_container">
        <label class="col-md-4 control-label" for="street_select"></label>
        <div class="col-md-5">
            <select id="street_select" class="form-control" multiple></select>
            <span class="btn btn-danger btn-xs hiden close_multiple" data-id="street_select_container">X</span>
        </div>
    </div>

    <!-- Адреса -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="address">Адреса</label>
        <div class="col-md-5">
            <input id="address" name="address" class="form-control field" value="<?= $order->address; ?>">
        </div>
    </div>

    <!-- Коментар до адреси -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="comment_address">Коментар до адреси</label>
        <div class="col-md-5">
            <textarea class="form-control" id="comment_address"><?= $order->comment_address; ?></textarea>
        </div>
    </div>

    <!-- Button -->

    <div class="form-group">
        <div class="col-md-offset-4 col-md-5">
            <button class="btn btn-primary" id="update_address">Оновити дані</button>
        </div>
    </div>

</div>