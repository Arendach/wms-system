<?php $this->inc('/parts/head'); ?>

<h2 class="sub-header">Купони</h2>

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li class="active"><span>Купони</span></li>
</ol>

<div class="right" style="margin-bottom: 10px">
    <button id="delete" class="btn btn-danger" title="Видалити вибрані купони">Видалити</button>
    <button class="btn btn-primary create" title="Створити новий купон">Створити</button>
</div>

<table class="table table-bordered">
    <tr>
        <td>#</td>
        <td>Код</td>
        <td>Імя</td>
        <td>Опис</td>
        <td>Тип</td>
        <td>Дії</td>
    </tr>
    <?php if (my_count($coupons) > 0):
        foreach ($coupons as $coupon): ?>
            <tr>
                <td style="width: 18px"><input class="select_coupons" type="checkbox" value="<?= $coupon->id ?>"></td>
                <td><?= $coupon->code; ?></td>
                <td><?= $coupon->name; ?></td>
                <td><?= $coupon->description; ?></td>
                <td><?= $coupon->type == 0 ? 'Стаціонарний' : 'Накопичувальний'; ?></td>
                <td class="action-2">
                    <button data-id="<?= $coupon->id; ?>" class="btn btn-primary btn-xs edit">
                        <span class="glyphicon glyphicon-pencil"></span>
                    </button>
                    <button data-id="<?= $coupon->id; ?>" class="btn btn-danger btn-xs delete">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                </td>
            </tr>
        <?php endforeach;
    else: ?>
        <tr>
            <td colspan="6">
                <h4 class="centered">Тут пусто :(</h4>
            </td>
        </tr>
    <?php endif; ?>
</table>

<?php if (isset($paginate)) { ?>
    <div class="centered"><?= $this->inc('/parts/paginate'); ?> </div> <?php } ?>

<?php $this->inc('/parts/footer'); ?>

