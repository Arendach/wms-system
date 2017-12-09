<?php $data = json_decode($item->data); ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
            <h4 class="panel-title">
                <?= $item->date ?> <a class="alert-link" href="#"><?= $item->login ?></a> Оновлено адресу
            </h4>
        </div>
    </div>
    <div id="collapse<?= $i ?>" class="panel-collapse collapse">
        <div class="panel-body">

            <?php if (isset($data->city)) { ?>
                Місто: <span class="text-primary"><?= $data->city ?></span><br>
            <?php } ?>

            <?php if (isset($data->warehouse)) { ?>
                Відділення: <span class="text-primary"><?= $data->warehouse ?></span><br>
            <?php } ?>

            <?php if (isset($data->address)) { ?>
                Адреса: <span class="text-primary"><?= $data->address ?></span><br>
            <?php } ?>

            <?php if (isset($data->region)) { ?>
                Регіон: <span class="text-primary"><?= $data->region ?></span><br>
            <?php } ?>


        </div>
    </div>
</div>