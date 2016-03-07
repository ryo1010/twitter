<?
class twitter
{
    private $usr_id;

    public function tweet_display()
    {
        $link = db_connect(
                '192.168.56.123',
                'akahira',
                'akahira',
                'twitter'
        );
        $INSERTED = 0;
        $EDIT = 2;
        if ($result = $link->query(
            "SELECT * FROM tweet WHERE status = $INSERTED OR status = $EDIT ORDER BY tweettime DESC"
        )){
            $data = "";
            while ( $row = $result->fetch_array() ) {
                $row['tweettime'] = $this->tweet_diff_check($row['tweettime']);
                $rows[] = $row;
            }
            $result->close();
            $link->close();
        }
        return $rows;
    }

    public function tweet_diff_check($tweettime)
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


}