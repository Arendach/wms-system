<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form>
        <h2 class="centered"><?= $from == 'update' ? 'Редагування категорії' : 'Нова категорія' ?></h2>
        <?php if (isset($category['id']))
            echo '<input class="field" name="id" value="' . $category['id'] . '" type="hidden">'; ?>

        <div class="form-group">
            <label for="inputName">Назва</label>
            <input name="name" value="<?= isset($category['name']) ? $category['name'] : '' ?>"
                   class="form-control field" placeholder="Назва">
        </div>

        <div class="form-group">
            <label for="inputName">Сервісний код</label>
            <input name="service_code" value="<?= isset($category['service_code']) ? $category['service_code'] : '' ?>"
                   class="form-control field" >
        </div>

        <div class="form-group">
            <label for="parent">Категорія</label>
            <select id="parent" name="parent" class="form-control field">
                <?php if ($from == 'update') { ?>
                    <option class="none" value="<?= $category['parent']; ?>"><?= $category['parent_name']; ?></option>
                <?php } ?>
                <option value="0">Без категорії</option>
                <?= ($categories); ?>
            </select>
        </div>
        <div class="form-group">
            <label for="sort">Сортування</label>
            <input name="sort" value="<?= isset($category['sort']) ? $category['sort'] : '' ?>" type="text"
                   class="form-control field"
                   id="sort" placeholder="Порядок Сортування">
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 pull-right">
                <div class="pull-right">
                    <button class="send btn btn-primary"
                            id="<?= $from == 'update' ? 'update' : 'create'; ?>"><?= $from == 'update' ? 'Обновити' : 'Створити' ?></button>
                </div>
            </div>
        </div>
    </form>

</div>

