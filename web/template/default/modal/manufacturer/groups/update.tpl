<div class="modal_head"><span id="modal_close">X</span></div>
<div id="modal_body">
    <form class="form-horizontal">
        <h2 class="centered"><?= isset($title) ? $title : ''; ?></h2>
        <input value="<?= $group->id ?>" name="id" type="hidden">
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Назва</label>
            <div class="col-sm-10">
                <input value="<?= $group->name ?>" name="name" class="form-control" id="name"
                       placeholder="Назва">
            </div>
        </div>

        <div class="form-group">
            <label for="sort" class="col-sm-2 control-label">Сортування</label>
            <div class="col-sm-10">
                <input value="<?= $group->sort ?>" name="sort"  class="form-control"
                       id="sort" placeholder="Порядок сортування">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 pull-right">
                <button id="save" class="btn btn-primary">Обновити</button>
                <button type="reset" class="btn btn-primary">Відмінити</button>
            </div>
        </div>
    </form>
</div>

