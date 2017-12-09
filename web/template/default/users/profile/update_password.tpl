<?php include parts('head'); ?>

    <h2 class="sub-header">Зміна паролю</h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('profile'); ?>">Мій профіль</a></li>
        <li class="active"><span>Зміна паролю</span></li>
    </ol>

    <!-- Новий пароль -->

    <div class="form-group">
        <label for="password">Новий пароль</label>
        <input id="password" class="form-control" type="password" minlength="6">
    </div>

    <!-- Підтвердження пароля -->

    <div class="form-group">
        <label for="password_confirmation">Підтвердіть пароль</label>
        <input id="password_confirmation" class="form-control" type="password" minlength="6">
    </div>

    <!-- Кнопка -->

    <div class="form-group">
        <button class="btn btn-primary" id="update_password">Оновити</button>
    </div>

<?php include parts('footer'); ?>