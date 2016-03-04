<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>つぶやく</title>
</head>
<body>
<?php
	require_once("twitter_function.php");
	login_check();

	if (isset($_POST['tweet_button'])) {
		if (!empty($_POST['tweet_content'])) {
				$link = con();
				$now_date = date("Y-m-d H:i:s");
				if ( $stmt = $link->prepare("INSERT INTO tweet VALUES(NULL,?,?,?,0)")) {
					$stmt->bind_param("sss",$_SESSION['username'],$now_date,$_POST['tweet_content']);
					$stmt->execute();
				}
				$stmt->close();
				$link->close();
				header("Location: /");
				exit();
		}else{
			echo "<h3>値が取得できませんでした。</h3>";
		}
	}

?>
<form action="" method="POST">
	<textarea class="tweet" name="tweet_content" cols="40" rows="5"></textarea>
	<input type="submit" name="tweet_button" value="ツイート">
</form>

</body>
</html>