<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>ツイート編集</title>
</head>
<body>
<form action="" method="POST">
    <?
        require_once("classes/twitter_login.php");
        require_once('classes/twitter_database.php');
        $database = new Database();
        $login = new Login();
        $login->login_check();
        $db_con_info = array(
            'host' => '192.168.56.123',
            'dbname' => 'twitter',
            'dbuser' => 'akahira',
            'password' => 'akahira',
        );
        $database->setDb_con_info($db_con_info);
        if (isset($_POST['tweet_edit'])) {
            $database->tweet_edit_submit($_POST['tweet_id'],$_POST['tweet_content']);
        }

        $database->tweet_delete();
        $rows = $database->tweet_edit($_GET['tweet_id']);
    ?>
    <table border='0'>
    <tr>
        <td>
            ユーザー名：<?= $rows['usr_id']?>
        </td>
    </tr>
    <tr>
        <td>
        ツイート時間<?= $rows['tweettime']?>
        </td>
    </tr>
    <tr>
        <td>
        <TEXTAREA name="tweet_content" cols="40" rows="5"><?= $rows['content']?></TEXTAREA>
        </td>
    <tr>
        <td>
        <input type="hidden" name="tweet_id" values="<?= $rows['tweet_id']?>">
        </td>
    </tr>
    </table>
    <input type="submit" name="tweet_edit" value="編集">
    <input type="submit" name="tweet_delete" value="削除"></input>
</form>
</body>
</html>
