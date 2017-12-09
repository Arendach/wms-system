<?php $data = json_decode($item->data); ?>

<div class="panel panel-success">

    <div class="panel-heading">
        <div data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
            <h4 class="panel-title">
                <?= $item->date ?> <a class="alert-link" href="#"><?= $item->login ?></a> Оригінал
            </h4>
        </div>
    </div>

    <div id="collapse<?= $i ?>" class="panel-collapse collapse">
        <div class="panel-body">

            <?php
                dd($data);
            foreach ($data as $k => $value) {
                if (is_file(t_file('buy/changes/original_components/' . $k . '.tpl'))) {
                    include t_file('buy/changes/original_components/' . $k . '.tpl');
                }
            }
            ?>

        </div>
    </div>

</div>