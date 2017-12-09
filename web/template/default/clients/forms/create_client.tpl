<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form>
        <h2 class="centered">Новий клієнт</h2>
        <div class="form-group">
            <label for="name">Імя</label>
            <input name="name" id="name" class="form-control">
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="email">Електронна пошта</label>
            <input name="email" id="email" class="form-control">
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="phone">Телефон</label>
            <input name="phone" id="phone" class="form-control">
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="group">Група</label>
            <select id="group" name="group" class="form-control">
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
            <input name="sort" id="sort" class="form-control">
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="address">Адреса</label>
            <input name="address" id="address" class="form-control">
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <label for="summernote">Додаткова інформація</label>
            <textarea name="info" id="summernote" class="summernote"></textarea>
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" id="create_client">Зберегти</button>
        </div>
    </form>
</div>