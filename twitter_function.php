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
//ツイート表示
function display(){
		$link = con();
				//stutasが0のものを表示1は削除されたものとしています
		$sql = "SELECT * FROM tweet WHERE stutas = 0 ORDER BY tweettime DESC";
		if($result = $link->query($sql)){
			$data = "";
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

//ログイン確認
function login_check(){
	session_start();
	if (!isset($_SESSION['username'])) {
		header("location:login.php");
		exit();
	}

}
?>