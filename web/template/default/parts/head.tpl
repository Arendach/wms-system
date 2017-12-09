<?php include parts('tools') ?>
<?php include parts('components') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? $title : '' ?></title>

    <?= style('custom'); ?>
    <?= style('dashboard'); ?>
    <?= style('menu'); ?>
    <?= $CSS_COMPONENTS; ?>

    <link rel="shortcut icon" href="<?= tpl('/favicon.ico'); ?>" type="image/x-icon">
    <link rel="icon" href="<?= tpl('/favicon.ico'); ?>" type="image/x-icon">

    <?php if (isset($link_css)) {
        foreach ($link_css as $link)
            echo '<link rel="stylesheet" href="' . tpl . '/css/' . $link . ' ">';
    } ?>


    <?php if (isset($css))
        foreach ($css as $item) echo $item; ?>

    <?php if (isset($route)) {
        echo script('/js/routs.js');
    } ?>

    <?= script('/js/jquery.js'); ?>
    <?= script('/js/components/jquery/cookie.js'); ?>
    <?= script('/js/URLs.js'); ?>

    <?php $this->inc("/js/main"); ?>

    <?= script('/js/common.js'); ?>
    <?= isset($script) ? '<script src="' . tpl . '/js/' . $script . '"></script>' : ''; ?>
    <?= $JS_COMPONENTS; ?>
    <?php if (isset($scripts)) {
        foreach ($scripts as $script)
            echo '<script src="' . tpl . '/js/' . $script . '"></script>';
    } ?>
    <?= isset($to_js) ? to_javascript($to_js) : '' ?>
    <?= isset($style) ? $style : '' ?>
</head>
<body>

<?php include parts('navbar') ?>
<?php include parts('leftbar') ?>
<div class="<?= template_class('content', 'content-mini') ?>" id="content">
