<?php
$imposed_class = $order->form_delivery == 'on_the_card' ? ' none' : '';
?>

<div class="row right">
    <div class="col-md-4">
        <h4><b>Оплата</b></h4>
    </div>
</div>

<div class="type_block">

    <!-- Форма оплати -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="form_delivery">Форма оплати</label>
        <div class="col-md-5">
            <select id="form_delivery" class="form-control">
                <option <?= $order->form_delivery == 'on_the_card' ? 'selected' : ''; ?> value="on_the_card">
                    Безготівкова
                </option>

                <option <?= $order->form_delivery == 'imposed' ? 'selected' : 'imposed'; ?> value="imposed">
                    Готівка
                </option>
            </select>
        </div>
    </div>

    <!-- Доставку оплачує -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="pay_delivery">Доставку оплачує</label>
        <div class="col-md-5">
            <select id="pay_delivery" class="form-control">
                <option <?= $order->pay_delivery == 'recipient' ? 'selected' : '' ?> value="recipient">Отримувач
                </option>
                <option <?= $order->pay_delivery == 'sender' ? 'selected' : '' ?> value="sender">Відправник</option>
            </select>
        </div>
    </div>

    <!-- Статус оплати -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="payment_status">Статус оплати</label>
        <div class="col-md-5">
            <select id="payment_status" class="form-control">
                <option <?= !$order->payment_status ? 'selected' : '' ?> value="0">Не оплачено</option>
                <option <?= $order->payment_status ? 'selected' : '' ?> value="1">Оплачено</option>
            </select>
        </div>
    </div>

    <!-- Предоплата -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="payment_status">Предоплата</label>
        <div class="col-md-5">
            <input id="prepayment" class="form-control" value="<?= $order->prepayment ?>">
        </div>
    </div>

    <!-- Кнопка -->

    <div class="form-group">
        <div class="col-md-4"></div>
        <div class="col-md-5">
            <button class="btn btn-primary" id="update_pay">Оновити дані</button>
        </div>
    </div>

</div>