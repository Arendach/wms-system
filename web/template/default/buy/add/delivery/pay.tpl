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
            <select id="pay_method" class="form-control field">
                <?php if(isset($pays)){
                    foreach ($pays as $pay) { ?>
                        <option value="<?= $pay->id ?>"><?= $pay->name ?></option>
                    <?php }
                } ?>
            </select>
        </div>
    </div>

    <!-- Предоплата -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="prepayment">Предоплата</label>
        <div class="col-md-5">
            <input id="prepayment" class="form-control field">
        </div>
    </div>

</div>