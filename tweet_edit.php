<!DOCTYPE html>
<html>
<head>
	<title>ツイート編集</title>
</head>
<body>
<form action="" method="POST">
	<?php
		require_once("twitter_function.php");
		function tweet_edit_submit(){
			if (!empty($_POST['tweet_edit'])) {
				if (!empty($_POST['tweet_content'])) {
					if (isset($_POST['tweet_id'])) {
						echo $tweet_id = $_POST['tweet_id'];
						echo "string";
					}
					
					$link = con();
					$now_date = date("Y-m-d H:i:s");
					//if ( $stmt = $link->prepare("UPDATE tweet SET content = ? tweettime = ? WHERE id = ?")) {
					//	$stmt->bind_param("ssi",$_GET['content'],$now_date,$);
				//		$stmt->execute();
				//	}
					$stmt->close();
					$link->close();
					header("Location: /");
					exit();
				}
			}
		}
		tweet_edit_submit();
		echo tweet_edit();
	?>
	<input type="submit" name="tweet_edit" value="編集">
</form>
</body>
</html>
