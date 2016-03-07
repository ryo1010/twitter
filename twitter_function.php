<?php

function db_connect($address,$db_user_name,$db_pass,$db_name)
{
    $link = new mysqli(
            $address,
            $db_user_name,
            $db_pass,
            $db_name
            );
    if ($link->connect_error) {
        echo $link->connect_error;
        exit();
    } else {
        $link->set_charset("utf8");
    }
    return $link;
}

function login_check()
{
    session_start();
    if (!isset($_SESSION['username'])) {
        header("location:login.php");
        exit();
    } elseif (isset($_SESSION['username'])) {
        return true;
    }

}

function tweet_submit()
{
    if (isset($_POST['tweet_button']) && !empty($_POST['tweet_content'])) {
        $link = db_connect(
                '192.168.56.123',
                'akahira',
                'akahira',
                'twitter'
                );
        $now_date = date("Y-m-d H:i:s");
        if ( $stmt = $link->prepare("
                     INSERT INTO tweet VALUES(NULL,?,?,?,0)"
                     )) {
        $stmt->bind_param("sss",
        $_SESSION['username'],$now_date,$_POST['tweet_content']);
        $stmt->execute();
        }
        $stmt->close();
        $link->close();
        header("Location: /");
        exit();
    }
}

function tweet_diff_check($tweettime)
{
    $now_datetime = date("Y-m-d H:i");
    $tweettime_diff = (strtotime($now_datetime) - strtotime($tweettime));
    if ($tweettime_diff < 60) {
        $tweettime_diff = "今さっき";
    } elseif ($tweettime_diff < 3600) {
        $tweettime_diff = (floor($tweettime_diff / 60 )) . "分前";
    } elseif ($tweettime_diff < 86400) {
            $tweettime_diff = (floor($tweettime_diff / 3600 )) . "時間前";
    } elseif ($tweettime_diff > 86400) {
        $tweettime_diff = date("m月d日",strtotime($tweettime));
    }
    return $tweettime_diff;
}


function tweet_edit()
{
    $data = "";
    if (isset($_GET['tweet_id'])) {
        $tweet_id = $_GET['tweet_id'];
        $link = db_connect('192.168.56.123','akahira','akahira','twitter');
        if ($stmt = $link->prepare("SELECT * FROM tweet WHERE id = ? AND usr_id = ?")) {
            $stmt->bind_param('is',$tweet_id,$_SESSION['username']);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($id,$usr_id,$tweettime,$content,$status);
                $stmt->fetch();
                $data .= "<table border='0'>";
                $data .= "<tr><td>".$usr_id."</tr></td>";
                $data .= "<tr><td>".$tweettime."</tr></td>";
                $data .= "<tr><td><TEXTAREA name='tweet_content' cols='40' rows='5'>".$content."</TEXTAREA></tr></td>";
                $data .= "<tr><td><input type='hidden' name='tweet_id' values='".$tweet_id."'></tr></td>";
                $data .= "</table>";
            } else {
                $data = "取得できませんでした。";
            }
        }
    }
    $stmt->close();
    $link->close();
    return $data;
}

function tweet_edit_submit()
{
    if (isset($_POST['tweet_edit']) &&
        isset($_POST['tweet_content']) &&
        isset($_GET['tweet_id'])) {
        $tweet_id = $_GET['tweet_id'];
        $link = db_connect('192.168.56.123','akahira','akahira','twitter');
        $status = 2;
        $now_date = date("Y-m-d H:i:s");
        if ( $stmt = $link->prepare(
        	"UPDATE tweet SET content = ?, tweettime = ?, status = ?
        	 WHERE id = ? AND usr_id = ?")) {
        $stmt->bind_param(
            "ssiis",
            $_POST['tweet_content'],
            $now_date,
            $status,
            $tweet_id,
            $_SESSION['username']
        );
    $stmt->execute();
    }
    $stmt->close();
    $link->close();
    header("Location: /");
    exit();
   	}
}

function tweet_delete()
{
    if (isset($_POST['tweet_delete'])
    	&& isset($_GET['tweet_id'])) {

        $tweet_id = $_GET['tweet_id'];
        $link = db_connect(
            '192.168.56.123',
            'akahira',
            'akahira',
            'twitter'
        );
        $status = 1;
        if ( $stmt = $link->prepare(
        	"UPDATE tweet SET status = ? WHERE id = ? AND usr_id = ?"
        )) {
            $stmt->bind_param("iis",$status,$tweet_id,$_SESSION['username']);
            $stmt->execute();
        }
        $stmt->close();
        $link->close();
        header("Location: /");
        exit();
    }
}

function tweet_history()
{
    $link = db_connect(
        '192.168.56.123',
        'akahira',
        'akahira',
        'twitter'
    );
    $status = 1;
    if ($stmt = $link->prepare(
        "SELECT * FROM tweet WHERE usr_id = ? AND status = ? ORDER BY tweettime DESC"
    )) {
        $stmt->bind_param('ii',$_SESSION['username'],$status);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($id,$usr_id,$tweettime,$content,$status);
        while ($stmt->fetch() ) {
            $tweettime = date("Y年m月d日 h時i分" ,strtotime($tweettime));
            $data .= "<div class='tweet_div'>\n";
            $data .= "<div class='datetime_div'>".$tweettime."</div>\n";
            $data .= "<div class='usr_id_div'>".$usr_id."</div>\n";
            $data .= "<div class='content_div'>".$content."</div>\n";
            $data .= "</div>\n";
        }
    }
    $stmt->close();
    $link->close();
    return $data;
}

?>