<?php if (isset($value->city)) { ?>
Місто: <span class="text-primary"><?= $value->city ?></span><br>
<?php } ?>

<?php if (isset($value->warehouse)) { ?>
Відділення: <span class="text-primary"><?= $value->warehouse ?></span><br>
<?php } ?>

<?php dd($data); ?>