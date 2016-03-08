<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>ツイート削除履歴</title>
</head>
<body>
<?
    require_once("classes/twitter_login.php");
    require_once('classes/twitter_display.php');

    $login = new login();
    $login->login_check();
?>
<a href="/">もどる</a>

<div class="main">

    <? $twitter = new twitter(); ?>
    <? $tweet_history_rows = $twitter->tweet_history(); ?>
        <? foreach ($tweet_history_rows as $row) { ?>
            <div class='datetime_div'>
                <?= $row['tweettime'] ?>
            </div>
            <div class='usr_id_div'>
                <?= $row['usr_id'] ?>
            </div>
            <div class='content_div'>
                <?= $row['content'] ?>
            </div>
        <? } ?>
</div>
</body>
</html>
