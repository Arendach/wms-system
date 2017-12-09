<?php include parts('modal_head'); ?>

    <div class="form-group">
        <label for="day">День</label>
        <input type="number" id="day" class="form-control">
    </div>
    <div class="form-group">
        <label for="name_operation">Імя операції</label>
        <input id="name_operation" class="form-control">
    </div>
    <div class="block" style="background-color: rgba(0,255,0,.3); padding: 10px; margin-bottom: 15px">
        <?php foreach (json_decode($profits) as $key => $value) { ?>
            <div class="form-group">
                <label for="<?= $key ?>"><?= $value ?></label>
                <input class="form-control" id="<?= $value ?>">
            </div>
        <?php } ?>
    </div>

    <div class="block" style="background-color: rgba(255,0,0,.3); padding: 10px;  margin-bottom: 15px">
        <?php foreach (json_decode($spending) as $key => $value) { ?>
            <div class="form-group">
                <label for="<?= $key ?>"><?= $value ?></label>
                <input class="form-control" id="<?= $value ?>" >
            </div>
        <?php } ?>
    </div>

    <div class="form-group">
        <button class="btn btn-primary">
            Зберегти зміни
        </button>
    </div>

<?php include parts('modal_foot'); ?>