<div class="row right">
    <div class="col-md-4">
        <h4><b>Адреса</b></h4>
    </div>
</div>

<div class="type_block">

    <!-- Район міста -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="region">Район міста</label>
        <div class="col-md-5">
            <select id="region" name="region" class="form-control field">
                <?php if (isset($regions) && my_count($regions) > 0) {
                    foreach ($regions as $region) { ?>
                        <option value="<?= $region->id ?>"><?= $region->name ?></option>
                    <?php }
                } ?>
            </select>
        </div>
    </div>

    <!-- Адреса -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="address">Адреса</label>
        <div class="col-md-5">
            <input id="address"class="form-control field" value="<?= isset($address) ? $address : ''; ?>">
        </div>
    </div>

</div>