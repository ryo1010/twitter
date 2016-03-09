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
    if (isset($_POST['tweet_button'])) {
        $database->
        tweet_submit(
            $_POST['tweet_content'],
            $_SESSION['username']
        );
    }

    include 'template/tweet_tmp.php'
?>
