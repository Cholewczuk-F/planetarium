<?php
include_once('../config.php');

session_start();
if (!isset($_SESSION["login"])) {
    header('Location: ' . SITE_URL_ROOT . 'authentication\login.php');
    exit();
}