<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Registration</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php
    require('../db/db_connect.php');

    // When form submitted, insert values into the database.
    if (isset($_REQUEST['user_login'])) {
        // removes backslashes
        $user_login = stripslashes($_REQUEST['user_login']);
        //escapes special characters in a string
        $user_login = mysqli_real_escape_string($con, $user_login);

        $role_id = 3; // default user role id
        $user_img = 1; // default avatar img id

        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);

        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);

        $create_date = date("Y-m-d H:i:s");

        $query    = "INSERT into `users` (user_login, email, role_id, user_img, user_hash, create_date)
                     VALUES ('$user_login', '$email', '$role_id', '$user_img', '" . md5($password) . "', '$create_date')";
        $result   = mysqli_query($con, $query);

        if ($result) {
            echo "<div class='form'>
                  <h3>Zarejestrowałeś się!</h3><br/>
                  <p class='link'>Nacisnij tutaj aby się <a href='login.php'>Zalogować</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Niepoprawnie wprowadzono dane.</h3><br/>
                  $query</br>
                  $result</br>
                  <p class='link'>Nacisnij tutaj aby się <a href='registration.php'>zarejestrować</a> ponownie.</p>
                  </div>";
        }
    } else {
    ?>
    <form class="form" action="" method="post">
        <h1 class="login-title">Rejestracja</h1>
        <input type="text" class="login-input" name="user_login" placeholder="Login" required />
        <input type="text" class="login-input" name="email" placeholder="Adres Email">
        <input type="password" class="login-input" name="password" placeholder="Hasło">
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link"><a href="login.php">Zaloguj Się</a></p>
    </form>
    <?php
    }
    ?>
</body>

</html>