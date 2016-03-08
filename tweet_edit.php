<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>ツイート編集</title>
</head>
<body>
<form action="" method="POST">
    <?
        require_once("classes/twitter_function.php");
        require_once('classes/twitter_display.php');
        $twitter = new twitter();
        $login = new login();
        $login->login_check();

        $twitter->tweet_edit_submit($_POST['tweet_id'],$_POST['tweet_content']);
        $twitter->tweet_delete();

        $rows = $twitter->tweet_edit($_GET['tweet_id']);
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
