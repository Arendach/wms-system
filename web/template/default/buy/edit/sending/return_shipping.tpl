<?php
$card_class = $return_shipping->type == 'remittance' && $return_shipping->type_remittance == 'on_the_card' ? '' : ' none ';
$field_class = $return_shipping->type != 'none' ? '' : ' none ';
$remittance_class = $return_shipping->type == 'remittance' ? '' : ' none ';
$payer_class = $return_shipping->payer == 'none' ? 'none ' : '';
?>

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
            <select id="return_shipping_type" class="form-control">
                <option <?= $return_shipping->type == 'none' ? 'selected' : ''; ?> value="none">Немає</option>
                <option <?= $return_shipping->type == 'documents' ? 'selected' : ''; ?> value="documents">Документ
                </option>
                <option <?= $return_shipping->type == 'remittance' ? 'selected' : ''; ?> value="remittance">Грошовий
                    переказ
                </option>
                <option <?= $return_shipping->type == 'other' ? 'selected' : ''; ?> value="other">Інше</option>
            </select>
        </div>
    </div>

    <!-- Грошовий переказ -->

    <div class="form-group<?= $remittance_class; ?>" id="return_shipping_remittance_type_container">
        <label class="col-md-4 control-label" for="return_shipping_remittance_type">Грошовий переказ</label>
        <div class="col-md-5">
            <select class="form-control" id="return_shipping_type_remittance">
                <option value="imposed">У відділенні</option>
                <option disabled value="on_the_card">На картку</option>
            </select>
        </div>
    </div>

    <!-- Карточка -->

    <div class="form-group<?= $card_class; ?>" id="return_shipping_card_container">
        <label class="col-md-4 control-label" for="return_shipping_card">Карточка</label>
        <div class="col-md-5">
            <select disabled class="form-control" id="return_shipping_card">
                <?php foreach ($cards as $item) { ?>
                    <option <?= $return_shipping->card == $item['Ref'] ? 'selected' : '' ?> value="<?= $item['Ref'] ?>">
                        <?= $item['MaskedNumber'] ?>
                    </option>
                <?php } ?>
            </select>
        </div>
    </div>

    <!-- Поле для вводу -->

    <div class="form-group<?= $field_class; ?>" id="return_shipping_sum_container">
        <label class="col-md-4 control-label" for="return_shipping_sum">Дані/сума</label>
        <div class="col-md-5">
            <input class="form-control" id="return_shipping_sum" value="<?= $return_shipping->sum ?>">
        </div>
    </div>

    <!-- Поле для вводу -->

    <div class="form-group<?= $payer_class; ?><?= $field_class ?>" id="return_shipping_payer_container">
        <label class="col-md-4 control-label" for="return_shipping_payer">Платник зворотньої відправки</label>
        <div class="col-md-5">
            <select id="return_shipping_payer" class="form-control">
                <option <?= $return_shipping->payer == 'sender' ? 'selected' : '' ?> value="sender">Відправник</option>
                <option <?= $return_shipping->payer == 'receiver' ? 'selected' : '' ?> value="receiver">Отримувач
                </option>
            </select>
        </div>
    </div>

    <!-- Кнопка -->

    <div class="form-group">
        <div class="col-md-4"></div>
        <div class="col-md-5">
            <button class="btn btn-primary" id="update_return_shipping">Оновити дані</button>
        </div>
    </div>

</div>
