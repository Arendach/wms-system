    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> <?php echo $title ?> </h4>
    </div>
    <div class="modal-body">

        <form class="form-horizontal" method="POST" action="<?php echo $action ?>">
            <input name="id" value="<?php echo $id ?>" type="hidden">
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Назва</label>
                <div class="col-sm-10">
                    <input name="cat_name" value="<?php echo $name ?>" type="text" class="form-control" id="inputName"
                           placeholder="Назва">
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Категорія</label>
                <div class="col-sm-10">
                    <select name="parent" class="form-control">
                        <?php if ($from == 'update'): ?>
                            <option value="<?php echo $parent ?>"><?php echo $name ?></option>
                        <?php else: ?>
                            <option value="0">Без категорії</option>
                        <?php endif ?>
                        <?php foreach ($category as $key => $item): ?>
                            <option value="<?php echo $item->id ?>"><?php echo $item->name ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputName" class="col-sm-2 control-label">Сортування</label>
                <div class="col-sm-10">
                    <input name="sort" value="<?php echo $sort ?>" type="text" class="form-control" id="inputName"
                           placeholder="Порядок сортування">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10 pull-right">
                    <div class="pull-right">
                        <button type="submit" class="btn btn-primary">Створити</button>
                        <button type="reset" class="btn btn-primary" data-dismiss="modal">Відмінити</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div> 
