<?php $data = json_decode($item->data); ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
            <h4 class="panel-title">
                <?= $item->date ?> <a class="alert-link" href="#"><?= $item->login ?></a> Оновлено дані про оплату
            </h4>
        </div>
    </div>

    <div id="collapse<?= $i ?>" class="panel-collapse collapse">
        <div class="panel-body">

            <?php if (isset($data->form_delivery)) { ?>
                Форма оплати: <span class="text-primary">
                    <?= $data->form_delivery == 'imposed' ? 'Наложений платіж' : 'Безготівкова' ?>
                </span><br><?php }

            if (isset($data->pay_method)) { ?>
                Спосіб оплати: <span class="text-primary"><?= $data->pay_method ?></span><br>
            <?php }

            if (isset($data->imposed)) { ?>
                Наложений платіж оплчує: <span class="text-primary">
                    <?= $data->imposed == 'sender' ? 'Відправник' : 'Отримувач' ?>
                </span><br>
            <?php }

            if (isset($data->pay_delivery)) { ?>
                Доставку оплачує: <span class="text-primary">
                    <?= $data->pay_delivery == 'sender' ? 'Відправник' : 'Отримувач' ?>
                </span><br>
            <?php }

            if (isset($data->payment_status)) { ?>
                Статус оплати: <span class="text-primary">
                    <?= $data->payment_status ? 'Оплачено' : 'Не оплачено' ?>
                </span><br>
            <?php }

            if (isset($data->prepayment)) { ?>
                Предоплачено: <span class="text-primary">
                    <?= $data->prepayment ?> грн
                </span><br>
            <?php } ?>

        </div>
    </div>

</div>