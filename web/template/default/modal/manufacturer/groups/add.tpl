<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form class="form-horizontal">
        <h2 class="centered"><?= isset($title) ? $title : ''; ?></h2>

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Назва</label>
            <div class="col-sm-10">
                <input name="name" class="form-control" id="name" placeholder="Назва">
            </div>
        </div>

        <div class="form-group">
            <label for="sort" class="col-sm-2 control-label">Сортування</label>
            <div class="col-sm-10">
                <input name="sort" class="form-control" id="sort" placeholder="Порядок Сортування">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 pull-right">
                <div class="pull-right">
                    <button id="insert" class="btn btn-primary">Створити</button>
                    <button type="reset" class="btn btn-primary">Відмінити</button>
                </div>
            </div>
        </div>
    </form>
</div>

