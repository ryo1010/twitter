<?
require_once('classes/twitter_login.php');
require_once('classes/twitter_database.php');
$login = new Login();
$database = new Database();
$login->login_check();
$db_con_info = array(
    'host' => '192.168.56.123',
    'dbname' => 'twitter',
    'dbuser' => 'akahira',
    'password' => 'akahira',
);
$database->setDb_con_info($db_con_info);
$database->tweet_submit();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>つぶやく</title>
</head>
<body>
<form action="" method="POST">
    <table>
    <tr>
        <td>
             <textarea class="tweet" name="tweet_content" cols="40" rows="5"></textarea>
        </td>
    </tr>
    <tr>
        <td>
             <input type="submit" name="tweet_button" value="ツイート">
        </td>
    </tr>
    </table>
</form>

</body>
</html>