<?php $data = json_decode($item->data); ?>

<div class="panel panel-primary">
    <div class="panel-heading">
        <div data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
            <h4 class="panel-title">
                <?= $item->date ?> <a class="alert-link" href="#"><?= $item->login ?></a> Оновлено дані зворотньої
                доставки
            </h4>
        </div>
    </div>
    <div id="collapse<?= $i ?>" class="panel-collapse collapse">
        <div class="panel-body">

            <?php if (isset($data->type)) { ?>
            Тип: <span class="text-primary">
                    <?php if ($data->type == 'documents'){ ?>
                Документи
                <?php } elseif ($data->type == 'remittance') { ?>
                Грошовий переказ
                <?php } elseif ($data->type == 'none') { ?>
                Немає
                <?php } else {  ?>
                Інше
                <?php } ?>
                </span><br>
            <?php }

            if (isset($data->type_remittance)) { ?>
            Грошовий переказ: <span class="text-primary">
                    <?= $data->type_remittance == 'imposed' ? 'У відділенні' : 'На карточку' ?>
                </span><br>
            <?php }

            if (isset($data->card)) { ?>
            Нова карточка: <span class="text-primary"><?= $data->card ?></span><br>
            <?php }

            if (isset($data->sum)) { ?>
            Сума/дані: <span class="text-primary"><?= $data->sum ?></span><br>
            <?php }

            if (isset($data->payer)) { ?>
            Платник: <span class="text-primary">
                    <?= $data->payer == 'sender' ? 'Відправник' : 'Отримувач' ?>
                </span><br>
            <?php } ?>

        </div>
    </div>
</div>