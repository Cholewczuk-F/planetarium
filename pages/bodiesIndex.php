<?php
include('../db/db_connect.php');
include('../config.php');
include(SITE_ROOT . 'templates/header.php');
include(SITE_ROOT . 'templates/footer.html');


$bodiesArray = array();

$sql = "SELECT * FROM celestialbodies";
$res = $con->query($sql);

while(($row = $res->fetch_array(MYSQLI_ASSOC))) {
    $bodiesArray[$row['body_ID']] = $row['name'];
}
var_dump($bodiesArray);

?>

<html>
<head>
    <title>Galeria</title>
    <link rel="stylesheet" href="../css/bodies_gallery_index_CSS.css">

</head>
<body>
<div class = "main_container">
<div class = "main_gallery_container">
<?php
    $sql = "SELECT * FROM celestialbodies";
    foreach($con->query($sql) as $row) {
        if($row['isApproved'] == 1) {
            echo '<div class = "gallery_container">';
                echo '<div class = "gallery_thumbnail">';
                    if(file_exists("../img/thumbnail_".$bodiesArray[$row['body_ID']].".png")) {
                        echo '<img src = "../img/thumbnail_'.$bodiesArray[$row['body_ID']].'.png">';
                    } elseif(file_exists("../img/thumbnail_".$bodiesArray[$row['body_ID']].".jpg")) {
                        echo '<img src = "../img/thumbnail_'.$bodiesArray[$row['body_ID']].'.jpg">';
                    } else {
                        echo "chuj";
                    }
                echo '</div>';
                echo '<div class = "gallery_name">';
                    echo '<p class = "gallery_p">';
                        echo $row["name"];
                    echo '</p>';
                echo '</div>';
                echo '<div class = "gallery_submitButton">';
                    echo '<form action = "body_'.$row["body_ID"].'" method = "GET">';
                        echo '<input type = "submit" value = "Sprawdź">';
                    echo '</form>';
        }

    }
        
?>
</div>
</body>



</html>