<?php
include_once('../config.php');
include(SITE_ROOT . 'db/db_connect.php');
include(SITE_ROOT . 'templates/header.php');


$err = array('user_login' => '', 'email' => '', 'password' => '', 'add' => '');

// When form submitted, insert values into the database.
if (isset($_POST['submit'])) {

    // removes backslashes
    $user_login = stripslashes($_REQUEST['user_login']);
    //escapes special characters in a string
    $user_login = mysqli_real_escape_string($con, $user_login);

    $role_id = 3; // default user role id
    $user_img = 1; // default avatar img id

    $email = stripslashes($_REQUEST['email']);
    $email = mysqli_real_escape_string($con, $email);

    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con, $password);

    $create_date = date("Y-m-d H:i:s");

    $query = "SELECT COUNT(*) FROM users WHERE user_login='$user_login' OR email='$email'";
    $user_duplicates_n = mysqli_fetch_all(mysqli_query($con, $query));

    $data_good = true;
    if ($user_login == '') {
        $data_good = false;
        $err['user_login'] = '<p style="color:red;">Login nie może być pusty.</p>';
    }
    if ($password == '') {
        $data_good = false;
        $err['password'] = '<p style="color:red;">Hasło nie może być puste.</p>';
    }
    if ($email == '') {
        $data_good = false;
        $err['email'] = '<p style="color:red;">Email nie może być pusty.</p>';
    }
    if ($user_duplicates_n[0][0] != 0) {
        $data_good = false;
        $err['add'] = '<h3 style="color:red;">Login lub email zajęty.</h3><br/>';
    }


    if ($data_good == true) {
        $query = "INSERT into `users` (user_login, email, role_id, user_img, user_hash, create_date)
                     VALUES ('$user_login', '$email', '$role_id', '$user_img', '" . md5($password) . "', '$create_date')";
        $result = mysqli_query($con, $query);
        $err['add'] = '<h3>Zarejestrowałeś się!</h3><br/><p class="link">Nacisnij tutaj aby się <a href="' . SITE_URL_ROOT . 'authentication/login.php">Zalogować</a></p>';
    }
}
?>

<form class="form" action="" method="post">
    <h1 class="login-title">Rejestracja</h1>
    <input type="text" class="login-input" name="user_login" placeholder="Login" />
    <?php echo ($err['user_login']); ?>
    <input type="text" class="login-input" name="email" placeholder="Adres Email">
    <?php echo ($err['email']); ?>
    <input type="password" class="login-input" name="password" placeholder="Hasło">
    <?php echo ($err['password']); ?>
    <input type="submit" name="submit" value="Register" class="login-button">
    <p class="link"><a href="<?php echo SITE_URL_ROOT; ?>authentication/login.php">Zaloguj Się</a></p>
</form>
<?php echo ($err['add']); ?>
</body>

</html>