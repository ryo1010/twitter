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

    include 'template/tweet_history_tmp.php';
?>
