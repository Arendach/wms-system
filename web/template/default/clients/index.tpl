<?php include parts('head'); ?>

    <h2 class="sub-header">Постійні клієнти</h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li><a href="<?= route('client_group'); ?>">Групи клієнтів</a></li>
        <li class="active"><span>Постійні клієнти</span></li>
    </ol>

    <div class="right" style="margin-bottom: 10px">
        <button class="btn btn-primary btn-md" id="create_form">Створити</button>
    </div>
    <table class="table table-bordered">
        <div id="overlay"></div>
        <tr>
            <td>Імя</td>
            <td>E-Mail</td>
            <td>Телефон</td>
            <td>Адреса</td>
            <td>Інформація</td>
            <td>Група</td>
            <td style="width: 50px">Сортування</td>
            <td class="action-3">Дія</td>
        </tr>
        <?php if (isset($clients) && my_count($clients) > 0) {
            foreach ($clients as $client) { ?>
                <tr>
                    <td><?= $client['name'] ?></td>
                    <td><?= $client['email'] ?></td>
                    <td><?= $client['phone'] ?></td>
                    <td><?= $client['address'] ?></td>
                    <td><?= $client['info'] ?></td>
                    <td><?= $client['group'] != '0' ? $client['group_name'] : 'Без групи' ?></td>
                    <td style="width: 50px"><?= $client['sort'] ?></td>
                    <td class="action-3">
                        <a href="<?= route('client_orders', ['id' => $client['id']]); ?>" title="Замовлення клієнта" class="btn btn-success btn-xs">
                            <span class="glyphicon glyphicon-shopping-cart"></span>
                        </a>
                        <button title="Редагувати" class="btn btn-primary btn-xs edit" data-toggle="<?= $client['id'] ?>">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </button>
                        <button title="Видалити" class="btn btn-danger btn-xs delete" data-toggle="<?= $client['id'] ?>">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </td>
                </tr>
            <?php }
        } else { ?>
            <tr>
                <td class="centered" colspan="8">Тут пусто :(</td>
            </tr>
        <?php } ?>
    </table>
<?php include parts('footer'); ?>