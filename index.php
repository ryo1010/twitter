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

    $_SERVER['REQUEST_URI'];

    include 'template/index_tmp.php';
?>
