<?php
$root = pathinfo($_SERVER['SCRIPT_FILENAME']);
define('PROJECT_NAME', 'planetarium');
define('BASE_FOLDER', basename($root['dirname'])); // planetarium/posts/ => 'posts'
define('SITE_ROOT',    realpath(dirname(__FILE__)) . '/'); // C:\xampp\htdocs\planetarium/
define('BASE_URL',    'http://' . $_SERVER['HTTP_HOST'] . '/' . PROJECT_NAME . '/' . BASE_FOLDER . '/'); // http://localhost/planetarium/posts/
define('SITE_URL_ROOT', 'http://' . $_SERVER['HTTP_HOST'] . '/' . PROJECT_NAME . '/'); // https://localhost/planetarium/posts/create.php