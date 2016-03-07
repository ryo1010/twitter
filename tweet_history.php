<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>ツイート削除履歴</title>
</head>
<body>
<?php
require_once("twitter_function.php");

login_check();

?>
<a href="/">もどる</a>
<div class="main">

<?php echo tweet_history(); ?>

</div>
</body>
</html>
