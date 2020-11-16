// This is a template file for local db setup.
// You should create one named 'db_connect.php', and filled appropriate username and password credentials.
// Additionally, 'db_connect.php' will be ignored by git.

<?php
$con = mysqli_connect("localhost", "<username>", "<password>", "planetarium");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}