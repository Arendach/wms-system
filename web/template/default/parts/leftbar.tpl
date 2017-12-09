<div class="<?= template_class('left_bar', 'mini-bar'); ?>" id="left_bar">
    <ul>
        <li title="Панель управліня">
            <a href="<?= route('index'); ?>">
                <i class="fa fa-dashboard"></i>
                <span>Панель управліня</span>
            </a>
        </li>
        <li title="Каталог" class="dropdown" rel="1">
            <a href="#">
                <i class="fa fa-book"></i><span>Каталог</span>
                <ul class="dropdown-1">
                    <li title="Категорії">
                        <a href="<?= route('category'); ?>">
                            <i class="fa fa-list"></i>
                            <span>Категорії</span>
                        </a>
                    </li>
                    <li title="Виробники">
                        <a href="<?= route('manufacture'); ?>">
                            <i class="fa fa-users"></i>
                            <span>Виробники</span>
                        </a>
                    </li>
                    <li title="Товари" class="dropdown" rel="3">
                        <a href="<?= route('products'); ?>">
                            <i class="fa fa-tags"></i><span>Товари</span>
                            <ul class="dropdown-3">
                                <li title="Ахів">
                                    <a href="<?= route('products_archive'); ?>">
                                        <i class="fa fa-archive"></i>
                                        <span>Архів</span>
                                    </a>
                                </li>
                            </ul>
                        </a>
                    </li>
                    <li title="Склади">
                        <a href="<?= route('storage'); ?>">
                            <i class="fa fa-bank"></i>
                            <span>Склади</span>
                        </a>
                    </li>
                </ul>
            </a>
        </li>
        <li title="Продажі" class="dropdown" rel="1">
            <a href="#">
                <i class="fa fa-shopping-basket"></i>
                <span>Продажі</span>
                <ul class="dropdown-1">

                    <li title="Закупки">
                        <a href="<?= route('purchases'); ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Закупки</span>
                        </a>
                    </li>

                    <li title="Замовлення" class="dropdown" rel="1">
                        <a href="<?= route('orders_all'); ?>">
                            <i class="fa fa-sitemap"></i>
                            <span>Замовлення</span>
                            <ul class="dropdown-8">
                                <li title="Доставка">
                                    <a href="<?= route('orders', ['type' => 'delivery']); ?>">
                                        <i class="fa fa-angle-right"></i>
                                        <span>Доставка</span>
                                    </a>
                                </li>
                                <li title="Магазин">
                                    <a href="<?= route('orders', ['type' => 'shop']); ?>">
                                        <i class="fa fa-angle-right"></i>
                                        <span>Магазин</span>
                                    </a>
                                </li>
                                <li title="Самовивіз">
                                    <a href="<?= route('orders', ['type' => 'self']); ?>">
                                        <i class="fa fa-angle-right"></i>
                                        <span>Самовивіз</span>
                                    </a>
                                </li>
                                <li title="Відправка">
                                    <a href="<?= route('orders', ['type' => 'sending']); ?>">
                                        <i class="fa fa-angle-right"></i>
                                        <span>Відправка</span>
                                    </a>
                                </li>
                            </ul>
                        </a>
                    </li>
                    <li title="Купони">
                        <a href="<?= route('coupons'); ?>">
                            <i class="fa fa-id-card-o"></i>
                            <span>Купони</span>
                        </a>
                    </li>
                    <li title="Постійні клієнти">
                        <a href="<?= route('clients'); ?>">
                            <i class="fa fa-user"></i>
                            <span>Постійні клієнти</span>
                        </a>
                    </li>
                    <li title="групи постійних клієнтів">
                        <a href="<?= route('client_group'); ?>">
                            <i class="fa fa-users"></i>
                            <span>Групи постійних клієнтів</span>
                        </a>
                    </li>
                </ul>
            </a>
        </li>
        <li title="Налаштування" class="dropdown" rel="5">
            <a href="<?= route('couriers'); ?>">
                <i class="fa fa-cogs"></i>
                <span>Налаштування</span>
                <ul class="dropdown-8">
                    <li title="Аттрибути">
                        <a href="<?= route('attributes'); ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Аттрибути</span>
                        </a>
                    </li>
                    <li title="Курєри">
                        <a href="<?= route('couriers') ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Курєри</span>
                        </a>
                    </li>
                    <li title="Доставка">
                        <a href="<?= route('logistics') ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Доставка</span>
                        </a>
                    </li>
                    <li title="Оплата">
                        <a href="<?= route('pays') ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Оплата</span>
                        </a>
                    </li>
                    <li title="Кольорові підказки">
                        <a href="<?= route('colors') ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Кольорові підказки</span>
                        </a>
                    </li>
                    <li title="Регіони">
                        <a href="<?= route('regions') ?>">
                            <i class="fa fa-angle-right"></i>
                            <span>Регіони</span>
                        </a>
                    </li>
                </ul>
            </a>
        </li>
        <?php if (can('managers')) { ?>
            <li title="Менеджери" class="dropdown" rel="1">
                <a href="#">
                    <i class="fa fa-book"></i><span>Менеджери</span>
                    <ul class="dropdown-1">
                        <?php if (can('managers_access')){ ?>
                        <li title="Групи доступу">
                            <a href="<?= route('access_groups'); ?>">
                                <i class="fa fa-list"></i>
                                <span>Групи доступу</span>
                            </a>
                        </li>
                        <?php } ?>
                        <li title="Список менеджерів">
                            <a href="<?= route('managers'); ?>">
                                <i class="fa fa-list"></i>
                                <span>Список менеджерів</span>
                            </a>
                        </li>
                        <li title="Звітність менеджерів">
                            <a href="<?= route('work_schedule'); ?>">
                                <i class="fa fa-list"></i>
                                <span>Звітність менеджерів</span>
                            </a>
                        </li>
                        <li title="Контроль витрат">
                            <a href="<?= route('control_money'); ?>">
                                <i class="fa fa-list"></i>
                                <span>Контроль витрат</span>
                            </a>
                        </li>
                    </ul>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
