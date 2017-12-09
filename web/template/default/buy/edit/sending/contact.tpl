<div class="row right">
    <div class="col-md-4">
        <h4><b>Контактна інформація</b></h4>
    </div>
</div>

<div class="type_block">

    <!-- Імя (ПІБ) -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="fio">Імя <span class="text-danger">*</span></label>
        <div class="col-md-5">
            <input id="fio" name="fio" placeholder="Якщо потрібно то ПІБ" class="form-control" required
                   value="<?= $order->fio ?>">
        </div>
    </div>

    <!-- Номер телефону -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="phone">Номер телефону <span class="text-danger">*</span></label>
        <div class="col-md-5">
            <input id="phone" name="phone" placeholder="0хх-ххх-хх-хх" class="form-control" required
                   value="<?= $order->phone ?>">
        </div>
    </div>

    <!-- E-mail -->

    <div class="form-group">
        <label class="col-md-4 control-label" for="email">E-mail</label>
        <div class="col-md-5">
            <input id="email" name="email" class="form-control" value="<?= $order->email ?>">
        </div>
    </div>

    <!-- Кнопка -->

    <div class="form-group">
        <div class="col-md-4"></div>
        <div class="col-md-5">
            <button class="btn btn-primary" id="update_contact">Оновити дані</button>
        </div>
    </div>

</div>
