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
	tweet_submit();
?>
<form action="" method="POST">
	<table>
	<tr>
		<td>
		     <textarea class="tweet" name="tweet_content" cols="40" rows="5"></textarea> 
		</td>
	</tr>
	<tr>
		<td> 
		     <input type="submit" name="tweet_button" value="ツイート"> 
		</td>
	</tr>
		
	</table>
	
	
</form>

</body>
</html>