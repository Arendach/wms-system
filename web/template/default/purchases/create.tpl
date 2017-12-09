<?php include parts('head'); ?>

    <h2 class="sub-header">Закупки</h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('purchases'); ?>">Закупки</a></li>
        <li class="active"><span>Створення</span></li>
    </ol>

<?php if (get('manufacturer') != '' && get('manufacturer') != false) { ?>

    <script>
        manufacturer = '<?= get('manufacturer') ?>';
    </script>

    <?php include t_file('purchases/add_product') ?>

    <table class="table table-bordered">
        <thead>
        <th>Назва товару</th>
        <th>Кількість на складі</th>
        <th>Ціна</th>
        <th>Кількість</th>
        <th></th>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="form-group">
        <label for="sum">Сума</label>
        <input class="form-control" id="sum">
    </div>

    <div class="form-group">
        <label for="comment">Коментар</label>
        <textarea class="form-control" id="comment"></textarea>
    </div>

    <div class="form-group">
        <button class="btn btn-primary" id="create">Зберегти</button>
    </div>

<?php } else { ?>
    <div class="form-group"><label for="manufacturer">Виробник</label>
        <select id="manufacturer" class="form-control">
            <option value=""></option>
            <?php foreach ($manufacturers as $manufacturer) {
                if (!in_array($manufacturer->id, $opened)) { ?>
                    <option value="<?= $manufacturer->id ?>"><?= $manufacturer->name ?></option>
                <?php }
            } ?>
        </select>
    </div>
<?php } ?>

<?php include parts('footer'); ?>