<?php
    require_once("classes/twitter_login.php");
    require_once('classes/twitter_database.php');
    $database = new Database();
    $db_con_info = array(
    'host' => '192.168.56.123',
    'dbname' => 'twitter',
    'dbuser' => 'akahira',
    'password' => 'akahira',
    );
    $database->setDb_con_info($db_con_info);
    session_start();
    if (isset($_SESSION['username'])) {
        header('Location: /');
        exit();
    } elseif (!empty($_POST['mail_address']) && !empty($_POST['password'])) {
        $database->login();
    }
    include 'template/login_tmp.php';
?>

