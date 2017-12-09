<?php $this->inc('/parts/head') ?>

    <h2 class="sub-header"><?php echo $section ?></h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('products'); ?>">Товари</a></li>
        <li class="active"><span>Категорії</span></li>
    </ol>

    <div class="right">
        <button data-form="create" type="button" class="btn btn-primary get_form">Додати
        </button>
        <button id="deleteSelected" type="button" class="btn btn-danger">Видалити</button>
    </div>

    <div class="table-responsive" style="margin-top: 10px">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>CH</th>
                <th>Назва Категорії</th>
                <th>Сервісний код</th>
                <th style="width: 69px">Дія</th>

            </tr>
            </thead>
            <tbody>
            <?php if (isset($categories) && $categories !== false)
                echo $categories;
            else
                echo '<tr><td colspan="3" class="centered">Тут пусто :(</td></tr>'; ?>
            </tbody>
        </table>
    </div>

<?php $this->inc('/parts/footer') ?>