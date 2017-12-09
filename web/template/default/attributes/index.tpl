<?php $this->inc('/parts/head'); ?>
    <h2 class="sub-header"><?= isset($section) ? $section : '' ?></h2>

    <ol class="breadcrumb breadcrumb-arrow">
        <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
        <li class="active"><span>Атрибути</span></li>
    </ol>

    <div class="right">
        <a href="#" id="addAttribute" class="btn btn-primary">Додати</a>
    </div>

    <div class="table-responsive" style="margin-top: 10px">
        <table class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead class="head-center">
            <tr>
                <th>Назва *</th>
                <th>Значення для наглядності *</th>
                <th class="action-2">Дії</th>
            </tr>
            </thead>
            <tbody id="attrTable">
            <?php $this->inc('/attributes/table') ?>
            </tbody>
        </table>
    </div>

<?php $this->inc('/parts/footer') ?>