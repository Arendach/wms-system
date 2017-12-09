<?php $data = json_decode($item->data); ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
            <h4 class="panel-title">
                <?= $item->date ?> <a class="alert-link" href="#"><?= $item->login ?></a> Оновлено контактні дані
            </h4>
        </div>
    </div>
    <div id="collapse<?= $i ?>" class="panel-collapse collapse">
        <div class="panel-body">

            <?php if (isset($data->fio)) { ?>
            Імя: <span class="text-primary"><?= $data->fio ?></span><br>
            <?php }

            if (isset($data->phone)) { ?>
            Номер телефону: <span class="text-primary"><?= $data->phone ?></span><br>
            <?php }

            if (isset($data->phone2)) { ?>
            Додатковий номер телефону: <span class="text-primary"><?= $data->phone2 ?></span><br>
            <?php }

            if (isset($data->email)) { ?>
            Електронна пошта: <span class="text-primary"><?= $data->email ?></span><br>
            <?php } ?>

        </div>
    </div>
</div>