<!DOCTYPE html>
<html>
<head>
	<title>ログイン画面</title>
</head>
<body>
<?php
	require_once("twitter_function.php");
	$link = con();
	session_start();
	//ログイン済み処理
	if(isset($_SESSION['username'])){
		
		header('Location: /');
		exit();

	//入力されていたらユーザーがいるか確認	
	}elseif (!empty($_POST['mail_address']) && ($_POST['password'])) {
	
		$mail_address = $_POST['mail_address'];
		//暗号化させる？
		$password = $_POST['password'];
		if ($stmt = $link->prepare("SELECT * FROM users WHERE usr_mail = ? AND usr_pw = ?")) {
			$stmt->bind_param("ss",$mail_address,$password);
			$stmt->execute();
			$stmt->store_result();
			if($stmt->num_rows == 1){
				$stmt->bind_result($id,$usr_id,$usr_pw,$usr_mail);
				while ($stmt->fetch()) {
    				$_SESSION['username'] = $usr_id;
    			}
				
			}
		}
		$stmt->close();
		header('Location: /');
		exit();
	
	}else{
		
	}
?>
<form action="" method="POST">
	<table>
		<tr>
			<td>mail address<input type="text" name="mail_address"></td>
		</tr>
		<tr>
			<td>password：<input type="password" name="password" ></td>
		</tr>
	</table>
<input type="submit" value="ログイン">
</body>
</html>
