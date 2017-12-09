<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form class="form-horizontal">
        <h2 class="centered"><?= $title ?></h2>
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Назва</label>
            <div class="col-sm-10">
                <input name="name" type="text" class="form-control" id="inputName" placeholder="Назва">
            </div>
        </div>
        <div class="form-group">
            <label for="groupManufacturer" class="col-sm-2 control-label">Тип</label>
            <div class="col-sm-10">
                <select name="type" class="form-control">
                    <option value="const=0">const=0</option>
                    <option value="+/-">+/-</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSort" class="col-sm-2 control-label">Сортування</label>
            <div class="col-sm-10">
                <input name="sort" inputAddresstype="text" class="form-control" id="inputSort"
                       placeholder="Порядок Сортування">
            </div>
        </div>
        <div class="form-group">
            <label for="info" class="col-sm-2 control-label">Додаткова інформація</label>
            <div class="col-sm-10">
                <textarea name="info" class="summernote" id="info"></textarea>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 pull-right">
                <div class="pull-right">
                    <button id="insert" type="" class="btn btn-primary" data-dismiss="modal">Створити</button>
                    <button type="reset" class="btn btn-primary" data-dismiss="modal">Відмінити</button>
                </div>
            </div>
        </div>
    </form>
</div>
