<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form class="form-horizontal">
        <h2 class="centered"><?= isset($title) ? $title : ''; ?></h2>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Назва <b class="text-danger">*</b></label>
            <div class="col-sm-10">
                <input name="name" class="form-control field" id="name">
            </div>
        </div>

        <div class="form-group">
            <label for="placeholder" class="col-sm-2 control-label">Значення <b class="text-danger">*</b></label>
            <div class="col-sm-10">
                <input name="placeholder" class="form-control field" id="placeholder">
            </div>
        </div>

        <div class="form-group">
            <label for="sort" class="col-sm-2 control-label">Сортування</label>
            <div class="col-sm-10">
                <input name="sort" class="form-control field" id="sort">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button id="save" class="btn btn-primary">Зберегти</button>
                <button type="reset" class="btn btn-primary">Відмінити</button>
            </div>
        </div>
    </form>
</div>