<!DOCTYPE html>
<html>
<head>
	<title>ツイート編集</title>
</head>
<body>
<form action="" method="POST">
	<?php
		require_once("twitter_function.php");
		login_check();
		//編集処理
		tweet_edit_submit();
		//削除処理
		tweet_delete();

		echo tweet_edit();
	?>
	<input type="submit" name="tweet_edit" value="編集">
	<input type="submit" name="tweet_delete" value="削除"></input>
</form>
</body>
</html>
