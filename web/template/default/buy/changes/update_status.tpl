<div class="panel panel-primary">
    <div class="panel-heading">
        <div data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $i ?>">
            <h4 class="panel-title">
                <?= $item->date ?> <a class="alert-link" href="#"><?= $item->login ?></a> Оновлено статус
            </h4>
        </div>
    </div>
    <div id="collapse<?= $i ?>" class="panel-collapse collapse">
        <div class="panel-body">
            <?= $item->data ?>
        </div>
    </div>
</div>