<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" id="map-signs" href="#"><i class="fa fa-map-signs"></i></a>
            <a class="navbar-brand" href="#">Система управління WMS</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?= can() ? '<li><a href="#" id="clean">Очистити кеш</a></li>' : ''; ?>
                <?= can() ? '<li><a target="_blank" href="/explorer/index.php">Файловий менеджер</a></li>' : ''; ?>
                <?= can() ? '<li><a target="_blank" href="/phpmyadmin/index.php">phpmyadmin</a></li>' : ''; ?>
                <li><a href="#">Налаштування</a></li>
                <li><a href="#">Допомога</a></li>
                <li>
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown"><?= user()->login; ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="<?= route('work_schedule') . parameters(['show' => 'my']) ?>">
                                Мій графік роботи
                            </a>
                        </li>
                        <li>
                            <a href="<?= route('profile') ?>">
                                Профіль
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?= route('logout') ?>">
                                Вихід
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>