<ul class="nav nav-pills">
    <?php foreach ($links as $item): ?>
        <li class="<?php print($item['class']) ?>"><a href="<?php print($item['action']) ?>"><?php print($item['name']) ?></a></li>
    <?php endforeach ?>
</ul>