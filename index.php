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
	echo "<div class='username_div'>ユーザ名".$_SESSION['username']."</div>";
	//ツイートと一覧表示
	function display(){
		$link = con();
		$sql = "SELECT * FROM tweet";
		if($result = $link->query($sql)){
			$deta = "";
			while ($row = $result->fetch_assoc()) {
				$tweettime = date("Y/m/d H:i",strtotime($row['tweettime']));
				$now_datetime = date("Y-m-d H-i");
				$test = ((strtotime($row['tweettime']) - strtotime($now_datetime));
				echo $test;
				//$tweettime = date("Y/m/d H:i",strtotime($row['tweettime']));
				$deta .= "<div class='datetime'>".$tweettime."</div>";
				$deta .= "<div class='usr_id_div'>".$row['usr_id']."</div>";
				$deta .= "<div class='content_div'>".$row['content']."</div>";
			}
			$result->close();
		}
		return $deta;
	}
	?>
	<div class="main">
		<?php echo display(); ?>
	</div>
</body>
</html>
