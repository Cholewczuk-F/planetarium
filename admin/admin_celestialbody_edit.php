<?php
include('../db/db_connect.php');
include('../config.php');
include('../templates/header.php');
require(SITE_ROOT . 'authentication/auth_session_admin.php'); // elevated authentication level require

$query = "SELECT * FROM celestialbodies WHERE body_ID ='".$_REQUEST['celestialBody_to_Edit']."'";

if(isset($_REQUEST['CB_name']) && isset($_REQUEST['CB_spectralType']) && isset($_REQUEST['CB_approxSize']) && isset($_REQUEST['CB_distance'])) {
    if(is_float($_REQUEST['CB_distance']) == FALSE) {
        $sql = "UPDATE celestialbodies SET name = '".$_REQUEST['CB_name']."', spectral_type = '".$_REQUEST['CB_spectralType']."', approx_size = ".$_REQUEST['CB_approxSize'].", distance = '".$_REQUEST['CB_distance']."' WHERE body_ID ='".$_REQUEST['celestialBody_to_Edit']."'"; 
        if($con->query($sql) === FALSE) {
            echo "Something went wrong while updating a celestial body: " . $con->error;
        }
    }
}
?>

<html>
<head>
</head>
<body>
    <div class = "edit_form_page-container">
        <div class = "edit_form">
            <form action = "admin_celestialbody_edit.php" method = "post">
                <?php
                if($res=$con->query($query)) {
                    while ($row = $res -> fetch_row()) {
                    ?>
                        <table>
                        <tr><td>Nazwa:</td>     <td><input type = "text" name = "CB_name" value = <?php echo $row[1]; ?> /></td></tr>
                        <tr><td>Typ widma:</td> <td><input type = "text" name = "CB_spectralType" value = <?php echo $row[2]; ?> maxlength = "1"/></td></tr>
                        <tr><td>Rozmiar:</td>   <td><input type = "text" name = "CB_approxSize" value = <?php echo $row[3]; ?> /> </td></tr>
                        <tr><td>Dystans:</td>   <td><input type = "number" name = "CB_distance" value = <?php echo $row[4]; ?> /> </td></tr>
                        </table>
                        <input type = "hidden" value = <?php echo $_REQUEST['celestialBody_to_Edit']; ?> name = "celestialBody_to_Edit" />
                        <input type = "submit" value = "Aktualizuj">
                    <?php }} ?>
            </form>
        </div>
    </div>
</body>
</html>