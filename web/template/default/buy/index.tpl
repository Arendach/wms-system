<?php include parts('head'); ?>
    <h2 class="sub-header"><?= $section; ?></h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li class="active"><span>Замовлення</span></li>
    </ol>

    <div class="dropdown pull-right">
        <button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown">
            Додати замовлення <span class="caret"></span>
        </button>

        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
            <li role="presentation">
                <a role="menuitem" href="<?= route('add_order', ['type' => 'delivery']); ?>">Доставка</a>
            </li>
            <li role="presentation">
                <a role="menuitem" href="<?= route('add_order', ['type' => 'shop']); ?>">Магазин</a>
            </li>
            <li role="presentation">
                <a role="menuitem" href="<?= route('add_order', ['type' => 'sending']); ?>">Відправка</a>
            </li>
            <li role="presentation">
                <a role="menuitem" href="<?= route('add_order', ['type' => 'self']); ?>">Самовивіз</a>
            </li>
        </ul>

    </div>
    <div class="content-section">
        <div class="orders-filter-container">
            <form>
                <div class="form-group">
                    <label for="type">Тип:</label>
                    <select class="form-control" id="type">
                        <option value="delivery">Доставка</option>
                        <option value="shop">Магазин</option>
                        <option value="sending">Надсилання</option>
                        <option value="self">Самовивіз</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="items">Пунктів на сторінку:</label>
                    <input id="items" class="form-control" value="25">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" id="show_orders">Показати</button>
                </div>
            </form>
        </div>
        <?php // if (isset($content)) print($content); ?>
    </div>

<?php // if (isset($paginate)) $this->inc('/parts/paginate'); ?>

<?php include parts('footer'); ?>