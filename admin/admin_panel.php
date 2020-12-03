<?php
include('../db/db_connect.php');
include('../config.php');
include('../templates/header.php');
require(SITE_ROOT . 'authentication/auth_session_admin.php'); // elevated authentication level require

if(isset($_REQUEST['edited_role_value'])) {
    $query = "UPDATE users SET role_id = ". $_REQUEST['edited_role_value']." WHERE user_login ='" . $_REQUEST['edited_role_username']."'";
    if($con->query($query) === FALSE) {
        echo "Something went wrong with: " . $con->error;
    }

} else if(isset($_REQUEST['deleted_username'])) {
    $query = "DELETE FROM users WHERE user_login='".$_REQUEST['deleted_username']."'";
    if($con->query($query) === FALSE) {
        echo "Something went wrong with: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin_panel_CSS.css">
</head>

<body>
    <div class = "main_page_container">
        <div class = "user_table_container">
            <div class = "user_table">
                <table>
                    <thead>
                        <tr>
                            <th>Nazwa użytkownika</th>
                            <th>Rola</th>
                            <th>Data stworzenia</th>
                            <th>Edycja roli</th>
                            <th>Usunięcie</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = 'SELECT U.user_login, R.user_role AS RoleName, U.create_date FROM users AS U LEFT JOIN roles AS R ON U.role_id = R.role_id';
                            foreach($con->query($sql) as $row) {
                                echo "<tr>";
                                    echo "<td>" . $row['user_login']."</td>";
                                    echo "<td>" . $row['RoleName']."</td>";
                                    echo "<td>" . $row['create_date']."</td>";
                                    echo "<td>";
                                    ?>
                                    <form action ="admin_panel.php" method = "post">
                                        <input type = "number" min = "1" max = "3" style = "width: 25px;" name = "edited_role_value">
                                        <input type = "hidden" value = <?php echo $row['user_login'] ?> name = "edited_role_username">
                                        <input type = "submit" value = "Edycja">
                                    </form>
                                    <?php
                                    echo "</td>";
                                    echo "<td>";
                                    ?>
                                    <form action ="admin_panel.php" method = "post">
                                    <input type = "hidden" value = <?php echo $row['user_login'] ?> name = "deleted_username">
                                        <input type = submit value = "Usuń">
                                    </form>
                                    <?php
                                    echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
