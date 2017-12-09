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
            <select id="form_delivery" class="form-control field">
                <option value="on_the_card">Безготівкова</option>
                <option value="imposed">Наложений платіж</option>
            </select>
        </div>
    </div>

    <!-- Доставку оплачує -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="pay_delivery">Доставку оплачує</label>
        <div class="col-md-5">
            <select id="pay_delivery" class="form-control field">
                <option value="recipient">Отримувач</option>
                <option value="sender">Відправник</option>
            </select>
        </div>
    </div>

    <!-- Статус оплати -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="payment_status">Статус оплати</label>
        <div class="col-md-5">
            <select id="payment_status" class="form-control field">
                <option value="0">Не оплачено</option>
                <option value="1">Оплачено</option>
            </select>
        </div>
    </div>

    <!-- Предоплата -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="payment_status">Предоплата</label>
        <div class="col-md-5">
            <input id="prepayment" class="form-control field" value="0">
        </div>
    </div>

</div>