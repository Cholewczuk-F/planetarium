<?php
include_once('config.php');
include(SITE_ROOT . 'templates/header.php');
include(SITE_ROOT . 'templates/footer.html');

?>
<html>
<head>
<link rel="stylesheet" href="css/index_page_CSS.css">
</head>
<body>
<div class="main_page_container">

    <div class="msg">Przejdź do:</div>

    <div class="forum_page_container">
        <div class="forum_page">
            <a href="pages/forumIndex.php">Forum</a>
        </div>
        <div class = "fresh_forum_post">
            <p>Najnowszy post: </p>
            <p>//user, data dodania, treść//</p>
        </div>
    </div>

    <div class="bodies_page_container">
        <div class="bodies_page">
            <a href="pages/bodiesIndex.php">Planetarium</a>
        </div>
        <div class = "fresh_celestialbody">
            <p>Ostatnio aktualizowany obiekt niebieski: </p>
            <p>//img, ilość zdjęć, data//</p>
        </div>
    </div>
</div>
</body>

    </html>