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
            <input id="city" value="Київ" required class="form-control field">
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
            <input id="street" class="form-control">
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
            <input id="address" class="form-control field">
        </div>
    </div>

    <!-- Коментар до адреси -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="comment_address">Коментар до адреси</label>
        <div class="col-md-5">
            <textarea class="form-control field" id="comment_address"></textarea>
        </div>
    </div>

</div>