<?php
include('../utils.php');

session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit();
} else if ($_SESSION['role_id'] != 1) {
    header("Location: ../index.php");
    exit();
}