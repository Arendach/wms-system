<div class="row right">
    <div class="col-md-4">
        <h4><b>Адреса</b></h4>
    </div>
</div>

<div class="type_block">

    <div id="address_container">

        <div class="form-group">
            <label class="col-md-4 control-label" for="city_input">Місто <span class="text-danger">*</span></label>
            <div class="col-md-5">
                <div class="input-group">
                    <input class="form-control" placeholder="Введіть 3 символи" id="city_input">
                    <span class="input-group-addon pointer clear" data-id="city_input">X</span>
                </div>
            </div>
        </div>

        <input type="hidden" id="city" class="form-control field">

        <div class="form-group none" id="city_select_container">
            <label class="col-md-4 control-label" for="city_select"></label>
            <div class="col-md-5">
                <select id="city_select" class="form-control" multiple></select>
                <span class="btn btn-danger btn-xs hiden close_multiple" data-id="city_select_container">X</span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-md-4 control-label" for="warehouse">
                Відділення <span class="text-danger">*</span>
            </label>
            <div class="col-md-5">
                <select disabled id="warehouse" class="form-control field"></select>
            </div>
        </div>

        <div class="form-group none">
            <label class="col-md-4 control-label" for="warehouse_search"></label>
            <div class="col-md-5">
                <select id="warehouse_search" name="warehouse_search" class="form-control" multiple></select>
            </div>
        </div>

    </div>
    <!-- Адреса -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="warehouse">Адреса</label>
        <div class="col-md-5">
            <input id="address" class="form-control field">
        </div>
    </div>

</div>