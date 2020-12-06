<?php
include_once('../config.php');
require(SITE_ROOT . 'db\db_connect.php');
require(SITE_ROOT . 'authentication\auth_session.php');
include(SITE_ROOT . 'templates\header.php');
include(SITE_ROOT . 'utils.php');
?>

<?php
$query = "SELECT category_ID, name FROM categories";
$categories = mysqli_fetch_all(mysqli_query($con, $query));

$errs = array(
    'title' => '',
    'content' => '',
    'category' => '',
    'additional' => ''
);
$title = isset($_REQUEST['title']) ? $_REQUEST['title'] : '';
$content = isset($_REQUEST['content']) ? $_REQUEST['content'] : '';
$category_id = isset($_REQUEST['category']) ? $_REQUEST['category'] : '';

if (isset($_POST['submit'])) {
    if ($title != '' && $content != '' && $category_id != 'null') {
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

        $body_id = 1; // default for now

        // columns: post_ID(auto), title, content, user_id, category_id, body_id, created_at(auto)
        if ($con->query(
            "INSERT INTO posts VALUES (
                null, 
                '$title', 
                '$content', 
                '$user_id', 
                '$category_id', 
                '$body_id', 
                null)
            "
        )) {
            header('Location: ' . SITE_URL_ROOT . 'posts/post.php?id=' . $con->insert_id);
            exit();
        } else {
            $errs['additional'] = '<p style="color:red; font-size:12px;">Problem z dodaniem posta. Proszę spróbować ponownie później.</p>';
        }

        // $insert_id = $con->insert_id;
        // print_r("insert id:" . $insert_id);

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
    }
} else {
}
?>

<div id="page_content">
    <div id="content_heading">
        <h1>Dodaj nowy post</h1>
        <?php echo ($errs['additional']); ?>
    </div>

    <div id="content">
        <form method="POST" action="create.php" style="align: center;">
            <table>
                <th colspan="2">
                    Dodaj Post
                </th>
                <tr>
                    <td style="width: 10%;">
                        Tytuł:
                    </td>
                    <td>
                        <input type="TEXT" name="title" placeholder="Tytuł" style="width: 98%; height: 24px;"
                            value="<?php echo $title; ?>"></input>
                        <?php echo ($errs['title']); ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 10%;">
                        Opisz post:
                    </td>
                    <td>
                        <input type="TEXT" name="content" placeholder="Treść" style="width: 98%; height: 124px;"
                            value="<?php echo $content; ?>"></input>
                        <?php echo ($errs['content']); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p>Załącz Zdjęcia <small>(Lub umieść post meta bez): </small></p>
                        <br>
                        <!-- <input type="file" name="file">-->
                    </td>
                </tr>
                <tr>
                    <td COLSPAN="2">
                        Wybierz kategorię:
                        <select name="category" selected="<?php echo ($category_name); ?>">
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
                    <td colspan="2" style="height: 24px;">
                        <input type="SUBMIT" name="submit" value="Dodaj Post" style="width: 15%;">
                    </td>
                </tr>
            </table>
        </form>
    </div>
    </body>

    </html>