<?php

ini_set("display_errors", 1);
error_reporting(E_ALL);
date_default_timezone_set('UTC');
session_start();
define('ROOT', __DIR__);

$user_info_init = [];

include_once './vendor/autoload.php';

$app = new \Web\App\Application();
$scanned_directory = array_diff(scandir(ROOT . '/routs'), ['..', '.']);
foreach ($scanned_directory as $rout)
    include_once ROOT . "/routs/" . $rout;
$app->run();
?>

