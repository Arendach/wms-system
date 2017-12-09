<?php include parts('modal_head'); ?>

    <form>
        <div class="form-group">
            <label for="name">Імя</label>
            <input id="name" name="name" class="form-control field" value="<?= $coupon->name; ?>">
            <span class="help-block"></span>
        </div>
        <div class="form-group">
            <label for="description">Опис</label>
            <input id="description" name="description" class="form-control field" value="<?= $coupon->description; ?>">
            <span class="help-block"></span>
        </div>
        <div class="form-group">
            <label for="code">Код</label>
            <input id="code" name="code" class="form-control field" value="<?= $coupon->code; ?>">
            <span class="help-block"></span>
        </div>
        <?php
        $type = $coupon->type == 0 ? 'stationary' : 'cumulative';
        include t_file('coupon/forms/types/' . $type);
        ?>
        <input type="hidden" value="<?= $coupon->id; ?>" id="id">
        <input type="hidden" value="<?= $coupon->type; ?>" id="coupon_type">
        <div class="form-group">
            <button class="btn btn-primary" id="update" data-id="<?= $coupon->id; ?>">Оновити</button>
        </div>
    </form>

<?php include parts('modal_foot'); ?>