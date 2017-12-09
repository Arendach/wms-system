<?php include parts('head'); ?>

<h2 class="sub-header">Мій графік роботи</h2>

<ol class="breadcrumb breadcrumb-arrow">
    <li><a href="<?= route('index'); ?>"><i class="fa fa-dashboard"></i></a></li>
    <li><a href="#">Мій профіль</a></li>
    <li class="active"><span>Мій графік роботи</span></li>
</ol>

<ul>
    <?php
    $start_life = date_parse(START_LIFE);
    for ($i = $start_life['year']; $i < date('Y') + 1; $i++) { ?>
        <li>
            <?= $i ?>
            <ul>
                <?php
                if ($start_life['year'] == $i) {
                    $start_month = $start_life['month'];
                    if ($i == date("Y"))
                        $finish_month = date('m') + 1;
                    else
                        $finish_month = 13;
                } else if ($i == date('Y')) {
                    $start_month = 1;
                    $finish_month = date('m') + 1;
                } else {
                    $start_month = 1;
                    $finish_month = 13;
                }
                ?>
                <?php for ($i2 = $start_month; $i2 < $finish_month; $i2++) { ?>
                    <li>
                        <a href="<?= route('work_schedule') . parameters(['year' => $i, 'month' => $i2, 'user' => user()->id]) ?>">
                            <?= int_to_month($i2) ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
</ul>

<?php include parts('footer'); ?>
