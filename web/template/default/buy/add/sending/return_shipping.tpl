<?php $cards = []; ?>
<div class="row right">
    <div class="col-md-4">
        <h4><b>Зворотня доставка</b></h4>
    </div>
</div>

<div class="type_block">

    <!-- Тип зворотньої доставки -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="return_shipping_type">Тип</label>
        <div class="col-md-5">
            <select id="return_shipping_type" class="form-control field">
                <option value="none">Немає</option>
                <option value="documents">Документ</option>
                <option value="remittance">Грошовий переказ</option>
                <option value="other">Інше</option>
            </select>
        </div>
    </div>

    <!-- Грошовий переказ -->

    <div class="form-group none" id="return_shipping_remittance_type_container">
        <label class="col-md-4 control-label" for="return_shipping_remittance_type">Грошовий переказ</label>
        <div class="col-md-5">
            <select class="form-control field" id="return_shipping_type_remittance">
                <option value="imposed">У відділенні</option>
                <option disabled value="on_the_card">На картку</option>
            </select>
        </div>
    </div>

    <!-- Карточка -->

    <div class="form-group none" id="return_shipping_card_container">
        <label class="col-md-4 control-label" for="return_shipping_card">Карточка</label>
        <div class="col-md-5">
            <select disabled class="form-control field" id="return_shipping_card">
                <?php foreach ($cards as $item){ ?>
                <option  value="<?=$item['Ref']?>"><?=$item['MaskedNumber']?></option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Поле для вводу -->

    <div class="form-group none" id="return_shipping_sum_container">
        <label class="col-md-4 control-label" for="return_shipping_sum">Дані/сума</label>
        <div class="col-md-5">
            <input class="form-control field" id="return_shipping_sum">
        </div>
    </div>

    <!-- Платник зворотньої відправки -->

    <div class="form-group none" id="return_shipping_payer_container">
        <label class="col-md-4 control-label" for="return_shipping_payer">Платник зворотньої відправки</label>
        <div class="col-md-5">
            <select id="return_shipping_payer" class="form-control field">
                <option value="sender">Відправник</option>
                <option value="receiver">Отримувач</option>
            </select>
        </div>
    </div>

</div>
