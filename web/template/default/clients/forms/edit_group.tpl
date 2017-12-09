<span id="modal_close">X</span>
<form>
    <h2 class="centered">Редагувати групу</h2>
    <div class="form-group ename">
        <label for="ename">Імя</label>
        <input type="text" id="ename" class="form-control" value="<?=$group->name;?>">
        <div class="help-block"></div>
    </div>

    <div class="form-group esort">
        <label for="esort">Сортування</label>
        <input type="text" id="esort" class="form-control" value="<?=$group->sort;?>">
        <div class="help-block"></div>
    </div>

    <div class="form-group">
        <button class="btn btn-primary" id="esubmit" data-toggle="<?=$group->id;?>">Зберегти</button>
    </div>
</form>