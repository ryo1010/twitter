<?php
//DB接続
function con(){
	$link = new mysqli('192.168.56.123','akahira','akahira','twitter');
	if ($link->connect_error){
		echo $link->connect_error;
		exit();
	} else {
		$link->set_charset("utf8");
	}
	return $link;
}

/*function display_usr_name(){
	$get_usr_name = new mysqli('192.168.56.123','akahira','akahira','twitter');
	if ($get_usr_name->connect_error){
		echo $get_usr_name->connect_error;
		exit();
	} else {
		$get_usr_name->set_charset("utf8");
	}
	$username = $_SESSION['username'];
}*/
//ログイン確認
function login_check(){
	session_start();
	if (!isset($_SESSION['username'])) {
		header("location:login.php");
		exit();
	}

}
?>