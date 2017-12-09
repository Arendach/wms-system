<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form class="form-horizontal">
        <h2 class="centered"><?= isset($title) ? $title : ''; ?></h2>
        <div class="form-group">
            <input value="<?= isset($id) ? $id : ''; ?>" name="id" type="hidden">
            <label for="inputName" class="col-sm-2 control-label">Назва</label>
            <div class="col-sm-10">
                <input value="<?= $manufacturer->name ?>" name="name" class="form-control" id="inputName"
                       placeholder="Назва">
            </div>
        </div>
        <div class="form-group">
            <label for="groupManufacturer" class="col-sm-2 control-label">Група виробників</label>
            <div class="col-sm-10">
                <select name="groupe" class="form-control" id="groupManufacturer">
                    <option value="0">Не вибрано</option>
                    <?php if (isset($groups)) {
                        foreach ($groups as $key => $item): ?>
                            <option <?= $item->id == $manufacturer->groupe ? 'selected' : '' ?>
                                    value="<?= $item->id ?>"><?= $item->name ?></option>
                        <?php endforeach;
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSort" class="col-sm-2 control-label">Сортування</label>
            <div class="col-sm-10">
                <input value="<?= $manufacturer->sort; ?>" name="sort" class="form-control" id="inputSort"
                       placeholder="Порядок сортування">
            </div>
        </div>
        <div class="form-group">
            <label for="inputAddress" class="col-sm-2 control-label">Адреса</label>
            <div class="col-sm-10">
                <input value="<?= $manufacturer->address ?>" name="address" class="form-control"
                       id="inputAddress" placeholder="Адреса">
            </div>
        </div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">Телефон</label>
            <div class="col-sm-10">
                <input value="<?= $manufacturer->phone; ?>" name="phone" class="form-control" id="phone"
                       placeholder="Телефон">
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Е-майл</label>
            <div class="col-sm-10">
                <input value="<?= $manufacturer->email; ?>" name="email" class="form-control" id="email"
                       placeholder="Е-майл">
            </div>
        </div>
        <div class="form-group">
            <label for="summernote" class="col-sm-2 control-label">Додаткова інформація</label>
            <div class="col-sm-10">
                <textarea name="info" class="summernote" id="summernote"><?= $manufacturer->info ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 pull-right">
                <div class="pull-right">
                    <button id="saveManufacturer" class="btn btn-primary">Обновити</button>
                </div>
            </div>
        </div>
    </form>

</div>
