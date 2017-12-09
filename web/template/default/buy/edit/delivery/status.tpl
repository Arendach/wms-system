<div class="row right">
    <div class="col-md-4">
        <h4><b>Статус</b></h4>
    </div>
</div>


<div class="type_block">

    <!-- STATUS -->

    <div class="form-group">
        <label for="status" class="control-label col-md-4">Статус</label>
        <div class="col-md-5">
            <select name="status" id="status" class="form-control field">
                <?= get_order_statuses('delivery', $order->status); ?>
            </select>
        </div>
    </div>

    <!-- Кнопка -->

    <div class="form-group">
        <div class="col-md-4"></div>
        <div class="col-md-5">
            <button class="btn btn-primary" id="update_status">Оновити дані</button>
        </div>
    </div>

</div>