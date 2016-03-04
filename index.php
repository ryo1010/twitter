<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Twitterもどき</title>
</head>
<body>
	<h1 class="title">Tweet一覧</h1>
	<?php
	require_once("twitter_function.php");
	login_check();
	echo "<div class='username_div'>ユーザ名".$_SESSION['username']."</div>";
	//ツイートと一覧表示
	?>
	<a href="tweet.php">つぶやく</a>
	<div class="main">
		<?php echo display(); ?>
	</div>
</body>
</html>
