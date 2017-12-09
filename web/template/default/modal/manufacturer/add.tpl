<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form class="form-horizontal">
        <h2 class="centered"><?= $title ?></h2>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Назва</label>
            <div class="col-sm-10">
                <input name="name" class="form-control" id="name" placeholder="Назва">
            </div>
        </div>
        <div class="form-group">
            <label for="groupManufacturer" class="col-sm-2 control-label">Група виробників</label>
            <div class="col-sm-10">
                <select name="groupe" class="form-control" id="groupManufacturer">
                    <?php if ($from == 'update'): ?>
                        <option value="<?php echo $parent ?>"><?php echo $name ?></option>
                    <?php else: ?>
                        <option value="0">Без групи виробників</option>
                    <?php endif ?>
                    <?php foreach ($groupes as $key => $item): ?>
                        <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSort" class="col-sm-2 control-label">Сортування</label>
            <div class="col-sm-10">
                <input name="sort" class="form-control" id="inputSort"
                       placeholder="Порядок сортування">
            </div>
        </div>
        <div class="form-group">
            <label for="inputAddress" class="col-sm-2 control-label">Адреса</label>
            <div class="col-sm-10">
                <input name="address" class="form-control" id="inputAddress" placeholder="Адреса">
            </div>
        </div>
        <div class="form-group">
            <label for="phone" class="col-sm-2 control-label">Телефон</label>
            <div class="col-sm-10">
                <input name="phone" class="form-control" id="phone" placeholder="Телефон">
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-sm-2 control-label">Е-майл</label>
            <div class="col-sm-10">
                <input name="email" class="form-control" id="email" placeholder="Е-майл">
            </div>
        </div>
        <div class="form-group">
            <label for="info" class="col-sm-2 control-label">Додаткова інформація</label>
            <div class="col-sm-10">
                <textarea class="summernote" name='info' id="info"></textarea>

            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 pull-right">
                <div class="pull-right">
                    <button id="save" class="btn btn-primary" data-dismiss="modal">Створити</button>
                    <button type="reset" class="btn btn-primary" data-dismiss="modal">Відмінити</button>
                </div>
            </div>
        </div>
    </form>
</div>

