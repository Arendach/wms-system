<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form class="form-horizontal">
        <h2 class="centered"><?= $title ?></h2>
        <input value="<?= $storage->id ?>" name="id" type="hidden">
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Назва</label>
            <div class="col-sm-10">
                <input value="<?= $storage->name ?>" name="name" class="form-control" id="inputName"
                       placeholder="Назва">
            </div>
        </div>

        <div class="form-group">
            <label for="groupManufacturer" class="col-sm-2 control-label">Тип</label>
            <div class="col-sm-10">
                <select name="type" class="form-control">
                    <option <?= $storage->type == '+/-' ? 'selected' : ''; ?> value="+/-">+/-</option>
                    <option <?= $storage->type == 'const=0' ? 'selected' : ''; ?> value="const=0">const=0</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="inputSort" class="col-sm-2 control-label">Сортування</label>
            <div class="col-sm-10">
                <input value="<?= $storage->sort ?>" name="sort" class="form-control"
                       id="inputSort" placeholder="Порядок Сортування">
            </div>
        </div>

        <div class="form-group">
            <label for="info" class="col-sm-2 control-label"></label>
            <div class="col-sm-10">
                <textarea name="info" class="summernote" id="info"><?= $storage->info ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                    <button id="save" class="btn btn-primary">Обновити</button>
            </div>
        </div>
    </form>
</div>
