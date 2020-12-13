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

}
if(isset($_REQUEST['deleted_username'])) {
    $query = "DELETE FROM users WHERE user_login='".$_REQUEST['deleted_username']."'";
    if($con->query($query) === FALSE) {
        echo "Something went wrong with: " . $con->error;
    }
}
if(isset($_REQUEST['celestialBodyID_to_Approve'])) {
    $adminID_query = "SELECT * FROM users WHERE user_login = '".$_SESSION['login']."'";
    foreach($con->query($adminID_query) as $row) {
        $update_query = "UPDATE celestialbodies SET isApproved = 1, reviewer = ".$row['user_ID']." WHERE body_ID = ".$_REQUEST['celestialBodyID_to_Approve'];
        var_dump($update_query);
        if($con->query($update_query) === FALSE) {
            echo $con->error;
        }
    }
}
if(isset($_REQUEST['celestialBodyID_to_Disapprove'])) {
    $query = "DELETE FROM celestialbodies WHERE body_ID = '".$_REQUEST['celestialBodyID_to_Disapprove']."'";
    if($con->query($query) === FALSE) {
        echo "Something went wrong with: " . $con->error;
    }
    
}
if(isset($_REQUEST['celestialBody_to_Delete'])) {
    $query = "DELETE FROM celestialbodies WHERE body_ID ='".$_REQUEST['celestialBody_to_Delete']."'";
    if($con->query($query) === FALSE) {
        echo "Something went wrong with deleting a celestial body: " . $con->error;
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
    <div class = "main_page-container">
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
        <div class = "celestialBodies_to_review_table_container">
            <div class = "celestialBodies_to_review_table">
                <table>
                    <thead>
                        <th>Nazwa obiektu</th>
                        <th>Użytkownik dodający</th>
                        <th>Data dodania</th>
                        <th>Zatwierdź</th>
                        <th>Odrzuć</th>
                    </thead>
                    <tbody>
                        <?php
                            $sql = 'SELECT * FROM celestialbodies WHERE isApproved="0"';
                            foreach($con->query($sql) as $row) {
                                    echo '<tr>';
                                        echo '<td>'.$row['name'].'</td>';
                                        echo '<td>'.$row['reviewer'].'</td>';
                                        echo '<td>'.$row['create_date'].'</td>';
                                        echo '<td>';
                                    ?>
                                    <form action ="admin_panel.php" method = "post">
                                        <input type = "hidden" value = <?php echo $row["body_ID"]; ?> name = "celestialBodyID_to_Approve">
                                        <input type = "submit" value = "Zatwierdź">
                                    </form>
                                    </td><td>
                                    <form action = "admin_panel.php" method = "post">
                                        <input type = "hidden" value = <?php echo $row["body_ID"]; ?> name = "celestialBodyID_to_Disapprove">
                                        <input type = "submit" value = "Odrzuć">
                                    </form>
                                    <?php
                                        echo '</td>';
                                    echo '</tr>';
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class = "approved_celestialBodies_container">
            <div class = "approved_celestialBodies_table">
                <table>
                    <thead>
                        <th>Nazwa obiektu</th>
                        <th>Typ widmowy</th>
                        <th>Data dodania</th>
                        <th>Edytuj</th>
                        <th>Usuń</th>
                    </thead>
                    <tbody>
                        <?php
                            $sql = 'SELECT * FROM celestialbodies WHERE isApproved="1"';
                            foreach($con->query($sql) as $row) {
                                echo '<tr>';
                                    echo '<td>'.$row['name'].'</td>';
                                    echo '<td>'.$row['spectral_type'].'</td>';
                                    echo '<td>'.$row['create_date'].'</td>';
                                    echo '<td>';
                                ?>
                                <form action = "admin_celestialbody_edit.php" method = "get">
                                    <input type = "hidden" value = <?php echo $row["body_ID"]; ?> name = "celestialBody_to_Edit">
                                    <input type = "submit" value = "Edytuj">
                                </form>
                                </td><td>
                                <form action = "admin_panel.php" method = "post">
                                    <input type = "hidden" value = <?php echo $row["body_ID"]; ?> name = "celestialBody_to_Delete">
                                    <input type = "submit" value = "Usuń">
                                </form>
                                </td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>