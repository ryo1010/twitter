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