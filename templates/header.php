<!DOCTYPE html>
<html>

<head>
    <title>Planetarium</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="<?php echo SITE_URL_ROOT; ?>css/navbar_CSS.css">
    

</head>

<body>
    <div class="navbar_container">
        <div class="navbar_btns">
            <?php

            $btns_segment = '';
            session_start();
            if (!isset($_SESSION["login"])) {

                $btns_segment = '<a href="' . SITE_URL_ROOT . 'authentication/login.php">Zaloguj Się</a>'
                    . '<a href="' . SITE_URL_ROOT . 'authentication/register.php">Rejestracja</a>';
            } else {
                $btns_segment = '<a href = "' . SITE_URL_ROOT . 'authentication/logout.php">Wyloguj</a>';

                if ($_SESSION['role_id'] == 1) {
                    $btns_segment = $btns_segment . '<a href="' . SITE_URL_ROOT . 'admin/admin_panel.php">Panel Administratora</a>';
                }
            }
            echo $btns_segment;
            ?>



            <a href="<?php echo SITE_URL_ROOT; ?>index.php">Strona główna</a>
        </div>
        <div class="navbar_logo">
            <img src="<?php echo SITE_URL_ROOT; ?>img/logo.png">
        </div>
    </div>