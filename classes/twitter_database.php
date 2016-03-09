<?

class Database
{
    private static $db_con_info;

    public function setDb_con_info($db_con_info){
        self::$db_con_info = $db_con_info;
    }

    private function db_connect()
    {
        $link = new mysqli(
                self::$db_con_info['host'],
                self::$db_con_info['dbuser'],
                self::$db_con_info['password'],
                self::$db_con_info['dbname']
        );
        if ($link->connect_error) {
            echo $link->connect_error;
            exit();
        } else {
            $link->set_charset("utf8");
        }
        return $link;
    }

    public function login()
    {
        $link = $this->db_connect();
        $mail_address = $_POST['mail_address'];
        $password = $_POST['password'];
        if ($stmt = $link->prepare(
            "SELECT * FROM users
            WHERE usr_mail = ? AND usr_pw = ?"
        )) {
            $stmt->bind_param(
                "ss",
                $mail_address,$password
            );
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows == 1){
                $stmt->bind_result(
                    $id,
                    $usr_id,
                    $usr_pw,
                    $usr_mail
                );
                while ($stmt->fetch()) {
                    $_SESSION['username'] = $usr_id;
                }
            }
        }
        $stmt->close();
        header('Location: /');
        exit();
    }

    public function tweet_display()
    {
        $link = $this->db_connect();
        $INSERTED = 0;
        $EDIT = 2;
        if ($result = $link->query(
            "SELECT * FROM tweet WHERE status = $INSERTED OR
             status = $EDIT ORDER BY tweettime DESC"
        )) {
            $data = "";
            while ( $row = $result->fetch_array() ) {
                $row['tweettime']
                = $this->tweet_diff_check($row['tweettime']);
                $rows[] = $row;
            }
            $result->close();
            $link->close();
        }
        return $rows;
    }

    private function tweet_diff_check($tweettime)
    {
        $now_datetime = date("Y-m-d H:i");
        $tweettime_diff =
        (strtotime($now_datetime) - strtotime($tweettime));

        if ($tweettime_diff < 60) {
            $tweettime_diff = "今さっき";
        } elseif ($tweettime_diff < 3600) {
            $tweettime_diff
             = (floor($tweettime_diff / 60 )) . "分前";
        } elseif ($tweettime_diff < 86400) {
            $tweettime_diff
            = (floor($tweettime_diff / 3600 )) . "時間前";
        } elseif ($tweettime_diff > 86400) {
            $tweettime_diff
            = date("m月d日",strtotime($tweettime));
        }
        return $tweettime_diff;
    }
    public function tweet_edit($tweet_id,$username)
    {
        $data = "";
        $link = $this->db_connect();
        if ($stmt = $link->prepare(
            "SELECT * FROM tweet WHERE id = ? AND usr_id = ?"
        )) {
            $stmt->bind_param(
                'is',
                $tweet_id,
                $username
            );
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $stmt->bind_result(
                    $id,
                    $usr_id,
                    $tweettime,
                    $content,
                    $status
                );
                $stmt->fetch();
                $row['usr_id'] = $usr_id;
                $row['tweettime'] = $tweettime;
                $row['content'] = $content;
                $row['tweet_id'] = $tweet_id;
                $rows = $row;
            } else {
                echo "取得できませんでした。";
            }
        }
    $stmt->close();
    $link->close();
    return $rows;
    }

    public function tweet_history($username)
    {
    $link = $this->db_connect();
    $TWEET_HISTORY = 1;
    if ($stmt = $link->prepare(
        "SELECT * FROM tweet WHERE usr_id = ? AND
        status = $TWEET_HISTORY ORDER BY tweettime DESC"
    )) {
        $stmt->bind_param('i',$username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result(
            $id,
            $usr_id,
            $tweettime,
            $content,
            $status
        );
        while ($stmt->fetch() ) {
            $row['tweettime']
            = date("Y年m月d日 h時i分" ,strtotime($tweettime));
            $row['content'] = $content;
            $row['usr_id'] = $usr_id;
            $rows[] = $row;
        }
    }
    $stmt->close();
    $link->close();
    return $rows;
    }

    public function tweet_edit_submit($tweet_id,$tweet_content)
    {
        $link = $this->db_connect();
        $EDIT = 2;
        $now_date = date("Y-m-d H:i:s");
        if ( $stmt = $link->prepare(
            "UPDATE tweet SET content = ?, tweettime = ?, status = $EDIT
             WHERE id = ? AND usr_id = ?"
        )) {
        $stmt->bind_param(
            "ssis",
            $tweet_content,
            $now_date,
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

    public function tweet_submit($tweet_content,$username)
    {
        $link = $this->db_connect();
        $now_date = date("Y-m-d H:i:s");
        if ( $stmt = $link->prepare("
            INSERT INTO tweet VALUES(NULL,?,?,?,0)"
        )) {
            $stmt->bind_param(
                "sss",
                $username,
                $now_date,
                $tweet_content
            );
            $stmt->execute();
        }
        $stmt->close();
        $link->close();
        header("Location: /");
        exit();
    }

    public function tweet_delete($tweet_id,$username)
    {
        $link = $this->db_connect();
        $status = 1;
        if ( $stmt = $link->prepare(
            "UPDATE tweet SET status = ?
             WHERE id = ? AND usr_id = ?"
        )) {
            $stmt->bind_param(
                "iis",
                $status,
                $tweet_id,
                $username
            );
            $stmt->execute();
        }
        $stmt->close();
        $link->close();
        header("Location: /");
        exit();
    }
}