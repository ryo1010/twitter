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

//ログイン確認
function login_check(){
	session_start();
	if (!isset($_SESSION['username'])) {
		header("location:login.php");
		exit();
	}

}
?>