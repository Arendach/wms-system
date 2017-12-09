<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form>
        <h2 class="centered">Редагування даних</h2>
        <div class="form-group">
            <label for="name">Імя</label>
            <input type="text" name="name" id="name" value="<?= $client->name ?>" class="form-control">
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="email">Електронна пошта</label>
            <input type="text" name="email" id="email" value="<?= $client->email ?>" class="form-control">
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input type="text" name="phone" id="phone" value="<?= $client->phone ?>" class="form-control">
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="group">Група</label>
            <select id="group" name="group" class="form-control">
                <option value="<?= $client->group; ?>"
                        class="none"><?= $client->group != 0 ? $client->group_name : 'Без групи' ?></option>
                <option value="0">Без групи</option>
                <?php if (isset($groups) && count($groups) > 0) {
                    foreach ($groups as $group) {
                        echo '<option value="' . $group->id . '">' . $group->name . '</option>';
                    }
                } ?>
            </select>
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="sort">Сортування</label>
            <input type="text" name="sort" id="sort" value="<?= $client->sort ?>" class="form-control">
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="address">Адреса</label>
            <input type="text" name="address" id="address" value="<?= $client->address ?>" class="form-control">
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="summernote">Додаткова інформація</label>
            <textarea name="info" id="summernote" class="summernote"><?= $client->info ?></textarea>
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" id="edit_client">Зберегти</button>
        </div>

    </form>
</div>

<script>
    id = <?= $client->id; ?>;
</script>