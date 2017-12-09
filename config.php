<?php

/**
 * Connect to DataBase
 */
define('DB_DSN', 'mysql:host=localhost;dbname=engine;');
define('DB_USER', 'root');
define('DB_PASSWORD', '');

/**
 * Template constants
 */
define('TPLDIR', __DIR__ . '/web/template/default');
define('tpl', '/web/template/default');
define('SITEFOLDER', '');
define('FOLDER', '');
define('SITE', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
define('LOGS_FOLDER', __DIR__ . '/server/logs/');
define('TEMPLATE_FOLDER', '/web/template/default/');

/**
 * Other
 */
define('START_LIFE', '2017-09-01 19:00:00');
define('DEBUG', true);

\Kint_Renderer_Rich::$theme = 'solarized-dark.css';
