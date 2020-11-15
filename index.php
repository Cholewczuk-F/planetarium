<?php require "db/db_connect.php" ?>
<!DOCTYPE html>
<html>
<head>
    <title>Planetarium</title>
    <meta charset = "utf-8">
    <link rel = "stylesheet" href = "css/navbar_CSS.css">
    <link rel = "stylesheet" href = "css/index_page_CSS.css">
    
</head>
<body>
    <div class = "navbar_container">
        <div class = "navbar_btns">
            <a href = "user/login.php">Zaloguj</a>
            <a href = "user/register.php">Rejestracja</a>
            <a href = "index.php">Strona główna</a>
        </div>
        <div class = "navbar_logo">
            <img src = "img/logo.png">
        </div>
    </div>
    <div class = "main_page_container">
        <div class = "msg">Przejdź do:</div>
        <div class = "forum_page_container">
            <a href = "pages/forumIndex.php">Forum</a>
        </div>
        <div class = "bodies_page_container">
            <a href = "pages/bodiesIndex.php">Planetarium</a>
        </div>
    </div>
</body>


</html>