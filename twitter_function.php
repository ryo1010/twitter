<?php
//DB接続
function con(){
	$link = new mysqli('192.168.56.123','akahira','akahira','twitter');
	if ($link->connect_error){
		echo $link->connect_error;	
		exit();
	} else {
		$link->set_charset("utf8");
	}
	return $link;
}
//ログイン確認
function login_check(){
	session_start();
	if (!isset($_SESSION['username'])) {
		header("location:login.php");
		exit();
	}elseif(isset($_SESSION['username'])){
		return true;
	}

}
//ツイート表示
function display(){
	$link = con();
			//stutasが0のものを表示1は削除されたものとしています
	if($result = $link->query("SELECT * FROM tweet WHERE stutas = 0 ORDER BY tweettime DESC")){
		//$data = "";
		while ($row = $result->fetch_assoc()) {
			$data .= "<div class='tweet_div'>\n";
			$data .= "<div class='datetime_div'>".tweet_diff_check($row['tweettime'])."</div>\n";
			$data .= "<div class='usr_id_div'>".$row['usr_id']."</div>\n";
			$data .= "<div class='content_div'>".$row['content']."</div>\n";
			$data .= "<div class='tweet_edit'><a href='tweet_edit.php?tweet_id=".$row['id']."'>編集</a></div>\n";
			$data .= "</div>\n";
		}
		$result->close();
	}
	return $data;
}
//ツイート投稿
function tweet_submit(){
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
}
//ツイート時間の計算
function tweet_diff_check($tweettime){
	//現在の時刻
	$now_datetime = date("Y-m-d H:i");
	//投稿時間と現在時間の差を計算
	$tweettime_diff = (strtotime($now_datetime) - strtotime($tweettime));
	
	//一分以内
	if ($tweettime_diff < 60) { 
		$tweettime_diff = "今さっき";
	
	//差が59分以内
	}elseif ($tweettime_diff < 3600) {
		$tweettime_diff = (floor($tweettime_diff / 60 )) . "分前";
	
	//差が23時間以内
	}elseif ($tweettime_diff < 86400) {
			$tweettime_diff = (floor($tweettime_diff / 3600 )) . "時間前";

	//差が23時間以上
	}elseif ($tweettime_diff > 86400) {
		$tweettime_diff = date("m月d日",strtotime($tweettime));
	}
	return $tweettime_diff;
}
//ツイート編集
function tweet_edit(){
	$data = "";
	if (isset($_GET['tweet_id'])) {
		$tweet_id = $_GET['tweet_id'];
		$link = con();
		if ($stmt = $link->prepare("SELECT * FROM tweet WHERE id = ? ")) {
			$stmt->bind_param("i",$tweet_id);
			$stmt->execute();
			$stmt->store_result();
			if($stmt->num_rows == 1){
				$stmt->bind_result($id,$usr_id,$tweettime,$content,$stutas);
				$stmt->fetch();
				$data .= "<div class='usr_id'>".$usr_id."</div>";
				$data .= "<div class='tweettime'>".$tweettime."</div>";
				$data .= "<div class='content'><TEXTAREA name='tweet_content' cols='40' rows='5'>".$content."</TEXTAREA></div>";
				$data .= "<input type='hidden' name='tweet_id' values='".$tweet_id."'>";
			}else{
				$data = "取得できませんでした。";
			}
		}
	}
	return $data;
}
?>