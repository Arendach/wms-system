<?php include parts('head'); ?>

    <h2 class="sub-header">Менеджери</h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('managers'); ?>">Менеджери</a></li>
        <li><a href="<?= route('manager', ['id' => $manager->id]); ?>"><?= $manager->login; ?></a></li>
        <li class="active"><span>Редагування даних</span></li>
    </ol>

    <form>

        <h4><b>Загальна інформація</b></h4>


        <div class="type_block">
            <!-- Електронна пошта -->

            <div class="form-group">
                <label for="email">Електронна пошта</label>
                <input id="email" type="email" class="form-control field" value="<?= $manager->email ?>">
            </div>

            <!-- Імя -->

            <div class="form-group">
                <label for="first_name">Імя</label>
                <input id="first_name" class="form-control field" value="<?= $manager->first_name ?>">
            </div>

            <!-- Прізвище -->

            <div class="form-group">
                <label for="last_name">Прізвище</label>
                <input id="last_name" class="form-control field" value="<?= $manager->last_name ?>">
            </div>

            <!-- Група доступу -->

            <div class="form-group">
                <label for="access">Група доступу</label>
                <select id="access" class="form-control field">
                    <?php if (can()) { ?>
                        <option <?= 9999 == $manager->access ? 'selected' : ''; ?> value="9999">ROOT</option>
                    <?php } ?>
                    <?php foreach ($access_groups as $group) { ?>
                        <option <?= $group->id == $manager->access ? 'selected' : ''; ?>
                                value="<?= $group->id; ?>"><?= $group->name; ?> (<?= $group->description; ?>)
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Кнопка -->

            <div class="form-group">
                <button class="btn btn-primary" id="update">Зберегти</button>
            </div>

        </div>

        <h4><b>Пароль</b></h4>

        <div class="type_block">

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
        </div>
    </form>

<?php include parts('footer'); ?>