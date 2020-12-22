<?php
include_once('../config.php');
require(SITE_ROOT . 'db\db_connect.php');
require(SITE_ROOT . 'authentication\auth_session.php');
include(SITE_ROOT . 'templates\header.php');
include(SITE_ROOT . 'utils.php');
?>

<?php
function cancel_post($con, $post_id)
{
    $con->query("DELETE FROM posts WHERE post_ID LIKE $post_id");
    print_r("DELETE FROM posts WHERE post_ID LIKE $post_id");
}

function cancel_gallery($con, $gallery_id)
{
    $con->query("DELETE FROM galleries WHERE gallery_ID LIKE $gallery_id");
}

function cancel_photos($con, $photos)
{
    foreach ($photos as $photo) {
        if (file_exists($photo['path'])) {
            print_r("delete: " . $photo['path']);
            unlink($photo['path']);
        }
    }
}

$categories = mysqli_fetch_all(
    $con->query(
        "SELECT category_ID, name FROM categories"
    )
);
$bodies = mysqli_fetch_all(
    $con->query(
        "SELECT body_ID, name FROM celestialbodies"
    )
);

$errs = array(
    'title' => '',
    'content' => '',
    'category' => '',
    'files' => '',
    'additional' => ''
);

$title = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
$content = isset($_REQUEST['content']) ? $_REQUEST['content'] : '';
$category_id = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';
$body_id = isset($_REQUEST['body']) ? $_REQUEST['body'] : '';

// if new body => post body_id=null, redirect to new body with setting user_session 'new_body' as true, when completed update post
$new_body = '';
$isPostMeta = '';
if ($body_id == 'new') {
    $new_body = true;
} else if ($body_id == 'meta') {
    $isPostMeta = true;
}

if (isset($_POST['submit'])) {

    //check whether is there any file uploaded, and if any is from selected formats
    $uploadable_files = '';
    $formats = array("jpeg", "jpg", "png");
    if (is_uploaded_file($_FILES['files']['tmp_name']['0'])) {
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            $ext = pathinfo($_FILES["files"]["name"][$key], PATHINFO_EXTENSION);
            if (in_array($ext, $formats)) {
                $uploadable_files = true;
            }
        }
    }

    // rules: no new planet without images, no post without category, content or title
    if ($title != '' && $content != '' && $category_id != 'null' && (!$new_body || $new_body && $uploadable_files)) {
        $user_login = $_SESSION['login'];

        $query = "SELECT user_ID FROM users WHERE user_login='$user_login'";
        $user_id = $con->query($query)->fetch_object()->user_ID;

        // boo beware of XDSSS
        $title = stripslashes($title);
        $title = mysqli_real_escape_string($con, $title);
        $content = stripslashes($content);
        $content = mysqli_real_escape_string($con, $content);
        $category_id = stripslashes($category_id);
        $category_id = mysqli_real_escape_string($con, $category_id);
        $body_id = stripslashes($body_id);
        $body_id = mysqli_real_escape_string($con, $body_id);

        // queries differ in $body_id -> value or NULL (not passable in variable to mysqli)
        if ($new_body || $isPostMeta) {
            $sql_insert = "INSERT INTO posts VALUES (
                null,
                '$title',
                '$content',
                '$user_id',
                '$category_id',
                null,
                null )";
        } else {
            $sql_insert = "INSERT INTO posts VALUES (
                null,
                '$title',
                '$content',
                '$user_id',
                '$category_id',
                '$body_id',
                null )";
        }

        do {
            $post_id = $gallery_id = '';

            if ($con->query($sql_insert)) {
                $post_id = $con->insert_id;
            } else {
                $errs['additional'] = '<p style="color:red; font-size:12px;">Err 1: Problem z dodaniem posta. Proszę spróbować ponownie później.</p>';
                break;
            }

            if ($uploadable_files) {
                $photos = array();

                // CREATE GALLERY GROUP TO NEWLY INSERTED POST
                if ($con->query("INSERT INTO galleries VALUES(null, $post_id)")) {
                    $gallery_id = $con->insert_id;
                } else {
                    // delete post at this point
                    cancel_post($con, $post_id);

                    $errs['additional'] = '<p style="color:red; font-size:12px;">Err 2: Problem z dodaniem posta. Proszę spróbować ponownie później.</p>' . $post_id;
                    break;
                }

                // PROCESS PHOTO FILENAMES, PATHS DATA
                foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                    $file_name = $_FILES['files']['name'][$key];
                    $file_tmp = $_FILES['files']['tmp_name'][$key];
                    $ext = pathinfo($file_name, PATHINFO_EXTENSION);

                    if (in_array($ext, $formats)) {
                        if (!file_exists(SITE_ROOT . POSTS_IMAGES . $file_name)) {

                            array_push($photos, array(
                                'move_from' => $_FILES["files"]["tmp_name"][$key],
                                'name' => $file_name,
                                'move_to' => POSTS_IMAGES . $file_name
                            ));
                        } else {

                            $filename = basename($file_name, $ext);
                            $newFilename = $filename . time() . "." . $ext;

                            array_push($photos, array(
                                'move_from' => $_FILES["files"]["tmp_name"][$key],
                                'name' => $newFilename,
                                'move_to' => POSTS_IMAGES . $newFilename
                            ));
                        }
                    }
                }

                // CREATE PHOTOS ENTRIES FOR GALLERY
                print_r($photos);

                $photos_added = array();
                foreach ($photos as $photo) {

                    if ($con->query(
                        "INSERT INTO images VALUES(
                        null,
                        $gallery_id, "
                            . "'" . $photo['name'] . "',"
                            . "'" . POSTS_IMAGES . $photo['name'] . "')"
                    )) {
                        $errs['additional'] = '';

                        array_push($photos_added, array('id' => $con->insert_id, 'path' => SITE_ROOT . $photo['move_to']));
                        move_uploaded_file($photo['move_from'], SITE_ROOT . $photo['move_to']);
                    } else {
                        // cancel operation

                        // this order is dictated by foreign key restraints
                        cancel_photos($con, $photos_added);
                        cancel_gallery($con, $gallery_id);
                        cancel_post($con, $post_id);

                        $errs['additional'] = '<p style="color:red; font-size:12px;">Err 3: Problem z dodaniem posta. Proszę spróbować ponownie później.</p>';
                        break;
                    }
                }
                cancel_photos($con, $photos_added);
            }

            // // REDIRECT USER
            // if ($new_body) {
            //     header('Location: ' . SITE_URL_ROOT . 'planets/create.php?post_id=' . $post_id);
            //     exit();
            // } else {
            //     header('Location: ' . SITE_URL_ROOT . 'posts/post.php?id=' . $post_id);
            //     exit();
            // }
        } while (0);
    } else {

        // error setting
        if ($_REQUEST['title'] == '') {
            $errs['title'] = '<p style="color:red; font-size:12px;">Tytuł nie może być pusty.</p>';
        }
        if ($_REQUEST['content'] == '') {
            $errs['content'] = '<p style="color:red; font-size:12px;">Treść nie może być pusta.</p>';
        }
        if ($_REQUEST['category'] == 'null') {
            $errs['category'] = '<p style="color:red; font-size:12px;">Należy wybrać kategorię.</p>';
        }
        if ($new_body && !$uploadable_files) {
            $errs['files'] = '<p style="color:red; font-size:12px;">Należy załączyć zdjęcia.</p>';
        }

        // nowa planeta = bez zdj
    }
}
?>

<div id="page_content">
    <div id="content_heading">
        <h1>Dodaj nowy post</h1>
        <?php echo ($errs['additional']); ?>
    </div>

    <div id="content">
        <form method="POST" action="create.php" style="align: center;" enctype="multipart/form-data">
            <table>
                <th colspan="2">
                    Dodaj Post
                </th>
                <tr>
                    <td style="width: 10%;">
                        Tytuł:
                    </td>
                    <td>
                        <input type="TEXT" name="title" placeholder="Tytuł" style="width: 98%; height: 24px;" value="<?php echo $title; ?>"></input>
                        <?php echo ($errs['title']); ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;">
                        Opisz post:
                    </td>
                    <td>
                        <input type="TEXT" name="content" placeholder="Treść" style="width: 98%; height: 124px;" value="<?php echo $content; ?>"></input>
                        <?php echo ($errs['content']); ?>
                    </td>
                </tr>
                <tr>
                    <td COLSPAN="2">
                        Wybierz kategorię:
                        <select name="category">
                            <option value="null">(wybierz)</option>
                            <?php
                            foreach ($categories as $cat_arr) {
                                echo ("<option value=\"" . $cat_arr[0] . "\"");
                                if ($cat_arr[0] == $category_id) {
                                    echo ("selected");
                                }
                                echo (">" . $cat_arr[1] . "</option>");
                            }
                            ?>
                        </select>
                        <?php echo ($errs['category']); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>Wybierz Ciało Niebieskie Której Post Dotyczy<br>
                        </p>
                        <br>
                        <select name="body">
                            <option value="meta">( meta )</option>
                            <option value="new" <?php if ($new_body == 1) {
                                                    echo ('selected');
                                                } ?>>( nowe ciało niebieskie )</option>
                            <?php
                            foreach ($bodies as $bod_arr) {
                                echo ("<option value=\"" . $bod_arr[0] . "\"");
                                if ($bod_arr[0] == $body_id) {
                                    echo ("selected");
                                }
                                echo (">" . $bod_arr[1] . "</option>");
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>Załącz Zdjęcia, lub napisz meta:</br>
                            <small>(Opcjonalne, wspierane: .jpeg .jpg .png)</small>
                        </p>
                        <br>
                        <input type="file" name="files[]" multiple />
                        <?php echo ($errs['files']); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="height: 24px;">
                        <input type="SUBMIT" name="submit" value="Dodaj Post">
                    </td>
                </tr>
            </table>
        </form></br></br></br>
    </div>
    </body>

    </html>