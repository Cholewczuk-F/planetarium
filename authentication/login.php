<?php
include_once('../config.php');
require(SITE_ROOT . 'db\db_connect.php');
include(SITE_ROOT . 'templates\header.php');

// When form submitted, check and create user session.
if (isset($_POST['login'])) {
    $login = stripslashes($_REQUEST['login']);    // removes backslashes
    $login = mysqli_real_escape_string($con, $login);

    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);

    // Check user is exist in the database
    $query    = "SELECT * FROM `users` WHERE user_login='$login'
                     AND user_hash='" . md5($password) . "'";
    $result = mysqli_query($con, $query) or die(mysqli_error());
    $rows = mysqli_num_rows($result);

    if ($rows == 1) {
        $entry = mysqli_fetch_array($result);
        $_SESSION['login'] = $login;
        $_SESSION['role_id'] = $entry['role_id'];
        // print_r($row);
        // console_log($row['role_id']);

        // Redirect to user dashboard page
        header('Location: ' . SITE_URL_ROOT . 'index.php');
    } else {
        echo "<div class='form'>
                  <h3>Niepoprawny login lub hasło.</h3><br/>
                  <p class='link'>Nacisnij tutaj aby się <a href='login.php'>zalogować</a> ponownie.</p>
                  </div>";
    }
} else {
?>
<form class="form" method="post" name="login">
    <h1 class="login-title">Zaloguj Się</h1>
    <input type="text" class="login-input" name="login" placeholder="Login" autofocus="true" />
    <input type="password" class="login-input" name="password" placeholder="Hasło" />
    <input type="submit" value="Zaloguj" name="submit" class="login-button" />
    <p class="link"><a href="register.php">Rejestracja</a></p>
</form>
<?php
}
?>
</body>

</html>