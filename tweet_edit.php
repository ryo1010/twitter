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
    }    $database->tweet_delete();
    $rows = $database->tweet_edit($_GET['tweet_id']);

    include 'template/tweet_edit_tmp.php'
?>

