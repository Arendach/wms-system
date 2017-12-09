<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form>
        <h2 class="centered">Редагування шапки</h2>

        <?php if (can()) { ?>
            <div class="form-group">
                <label for="coefficient">Коефіціент</label>
                <input class="form-control field" id="coefficient" value="<?= $data->coefficient; ?>">
            </div>
        <?php } ?>

        <?php if (can()) { ?>
            <div class="form-group">
                <label for="price_month">Ставка за місяць</label>
                <input class="form-control field" id="price_month" value="<?= $data->price_month; ?>">
            </div>
        <?php } ?>

        <div class="form-group">
            <label for="for_car">За машину</label>
            <input class="form-control field" id="for_car" value="<?= $data->for_car; ?>">
        </div>

        <div class="form-group">
            <label for="bonuse">Бонус</label>
            <input class="form-control field" id="bonuse" value="<?= $data->bonuse; ?>">
        </div>

        <?php if (can()) { ?>
            <div class="form-group">
                <label for="fine">Штраф</label>
                <input class="form-control field" id="fine" value="<?= $data->fine; ?>">
            </div>
        <?php } ?>

        <div class="form-group">
            <button id="update"  data-id="<?= $data->id ?>" data-type="head" class="btn btn-primary">Зберегти</button>
        </div>


    </form>
</div>