<?php include parts('head'); ?>

    <h2 class="sub-header">Реєстрація</h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('managers'); ?>">Менеджери</a></li>
        <li class="active"><span>Реєстрація</span></li>
    </ol>

    <form>
        <!-- Логін -->

        <div class="form-group">
            <label for="login">Логін</label>
            <input id="login" class="form-control field">
        </div>

        <!-- Пароль -->

        <div class="form-group">
            <label for="password">Пароль</label>
            <input id="password" class="form-control field">
        </div>

        <!-- Електронна пошта -->

        <div class="form-group">
            <label for="email">Електронна пошта</label>
            <input id="email" type="email" class="form-control field">
        </div>

        <!-- Імя -->

        <div class="form-group">
            <label for="first_name">Імя</label>
            <input id="first_name" class="form-control field">
        </div>

        <!-- Прізвище -->

        <div class="form-group">
            <label for="last_name">Прізвище</label>
            <input id="last_name" class="form-control field">
        </div>

        <!-- Група доступу -->

        <div class="form-group">
            <label for="access">Група доступу</label>
            <select id="access" class="form-control field">
                <?php if (can())
                    echo '<option value="9999">ROOT</option>';

                foreach ($access_groups as $group)
                    echo '<option value="' . $group->id . '">' . $group->name . ' (' . $group->description . ')</option>'; ?>
            </select>
        </div>

        <!-- Кнопка -->

        <div class="form-group">
            <button class="btn btn-primary" id="register">Реєструвати</button>
        </div>
    </form>

<?php include parts('footer'); ?>