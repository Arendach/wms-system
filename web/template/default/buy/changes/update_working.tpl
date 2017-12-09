<?php $data = json_decode($item->data); ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
            <h4 class="panel-title">
                <?= $item->date ?> <a class="alert-link" href="#"><?= $item->login ?></a> Оновлено службову інформацію
            </h4>
        </div>
    </div>
    <div id="collapse<?= $i ?>" class="panel-collapse collapse">
        <div class="panel-body">

            <?php if (isset($data->courier)) { ?>
            Курєр: <span class="text-primary"><?= $data->courier ?></span><br>
            <?php }

            if (isset($data->hint)) { ?>
            Підказка: <span class="text-primary"><?= $data->hint ?></span><br>
            <?php }

            if (isset($data->delivery)) { ?>
            Транспортна компанія: <span class="text-primary"><?= $data->delivery ?></span><br>
            <?php }

            if (isset($data->date_delivery)) { ?>
            Дата доставки: <span class="text-primary"><?= $data->date_delivery ?></span><br>
            <?php }

            if (isset($data->coupon)) { ?>
            Купон: <span class="text-primary"><?= $data->coupon ?></span><br>
            <?php }

            if (isset($data->comment)) { ?>
            Коментар: <span class="text-primary"><?= $data->comment ?></span><br>
            <?php }

            if (isset($data->time_with)) { ?>
            Градація(від): <span class="text-primary"><?= $data->time_with ?></span><br>
            <?php }

            if (isset($data->time_to)) { ?>
                Градація(до): <span class="text-primary"><?= $data->time_to ?></span><br>
            <?php } ?>

        </div>
    </div>
</div>