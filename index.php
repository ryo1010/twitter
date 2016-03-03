<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Twitterもどき</title>
</head>
<body>
	<h2>Tweet一覧</h2>
	<?php
	require_once("twitter_function.php");
	login_check();
	//ツイートと一覧表示
	function display(){
		$link = con();
		$sql = "SELECT * FROM tweet";
		if($result = $link->query($sql)){
			$deta = "";
			while ($row = $result->fetch_assoc()) {
				$tweettime = date("Y/m/d H:i",strtotime($row['tweettime']));
				$deta .= "<p>".$tweettime."</p>";
				$deta .= "<p>".$row['usr_id']."</p>";
				$deta .= "<p>".$row['content']."</p>";
			}
			$result->close();
		}
		return $deta;
	}

	echo display();
	?>
</body>
</html>
