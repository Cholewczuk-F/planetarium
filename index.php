<?php
include_once('config.php');
include(SITE_ROOT . 'templates/header.php');
include(SITE_ROOT . 'templates/footer.html');

?>
<html>
<head>
<link rel="stylesheet" href="<?php echo SITE_URL_ROOT; ?>css/index_page_CSS.css">
</head>
<body>
<div class="main_page_container">
    <div class="msg">Przejdź do:</div>
    <div class="forum_page_container">
        <div class="forum_page">
            <a href="pages/forumIndex.php">Forum</a>
        </div>
        <div class="bodies_page_container">
            <a href="pages/bodiesIndex.php">Planetarium</a>
        </div>
    </div>
    </body>

    </html>