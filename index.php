<?php
// not required on frontpage

// require "db/db_connect.php";
// require "authentication/auth_session.php";

require "templates/header.php";
include 'utils/console_log.php';
?>

<div class="main_page_container">
    <div class="msg">Przejdź do:</div>
    <?php console_log("testing"); ?>
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