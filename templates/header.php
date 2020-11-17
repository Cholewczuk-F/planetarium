<!DOCTYPE html>
<html>

<head>
    <title>Planetarium</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/navbar_CSS.css">
    <link rel="stylesheet" href="css/index_page_CSS.css">

</head>

<body>
    <div class="navbar_container">
        <div class="navbar_btns">
            <?php
            // if (!empty($_COOKIE["CK_USER_LOGIN"])) {
            //     echo '<a href = "account.php">';
            //     echo $_COOKIE["CK_USER_LOGIN"];
            //     echo '</a>';
            // } else {
            //     echo '<a href = "authentication/login.php">';
            //     echo 'Zaloguj';
            //     echo '</a>';
            // }
            $btns_segment = '';

            session_start();
            if (!isset($_SESSION["login"])) {
                $btns_segment = '<a href = "authentication/login.php">Zaloguj Się</a>'
                    . '<a href="authentication/register.php">Rejestracja</a>';
            } else {
                $btns_segment = '<a href = "authentication/logout.php">Wyloguj</a>';
                if ($_SESSION['role_id'] == 1) {
                    $btns_segment = $btns_segment . '<a href="#">Panel Administratora</a>';
                }
            }
            echo $btns_segment;

            ?>



            <a href="index.php">Strona główna</a>
        </div>
        <div class="navbar_logo">
            <img src="img/logo.png">
        </div>
    </div>