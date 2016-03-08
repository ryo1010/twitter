<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>ツイート削除履歴</title>
</head>
<body>
<?
    require_once("classes/twitter_login.php");
    require_once('classes/twitter_database.php');

    $login = new Login();
    $login->login_check();
    $database = new Database();
    $db_con_info = array(
        'host' => '192.168.56.123',
        'dbname' => 'twitter',
        'dbuser' => 'akahira',
        'password' => 'akahira',
    );
$database->setDb_con_info($db_con_info);
?>
<a href="/">もどる</a>

<div class="main">

    <? $tweet_history_rows = $database->tweet_history(); ?>
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
