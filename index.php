<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Twitterもどき</title>
</head>
<body>
    <?
        require_once('classes/twitter_login.php');
        require_once('classes/twitter_display.php');
        $login = new login();
        $login->login_check();
    ?>
    <h1 class="title">Tweet一覧</h1>
    <div class='username_div'>ユーザ名<?= $_SESSION['username'] ?></div>
    <a href="tweet.php">つぶやく</a>
    <a href="tweet_history.php">削除履歴</a>
    <div class="main">
        <? $database = new database() ?>
        <? $array_data = $database->tweet_display(); ?>
        <? foreach ($array_data as $data) { ?>
            <div class='datetime_div'>
                <?= $data['tweettime'] ?>
            </div>
            <div class='usr_id_div'>
                <?= $data['usr_id'] ?>
            </div>
            <div class='content_div'>
                <?= $data['content'] ?>
            </div>
            <div class='tweet_edit'>
                <a href='tweet_edit.php?tweet_id=<?= $data['id'] ?>'>編集</a>
            </div>
        <? } ?>
    </div>
</body>
</html>
