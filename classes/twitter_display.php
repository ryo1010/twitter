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
                $rows[] = $row;
            }
            $result->close();
            $link->close();
        }
        return $rows;
    }
   // public function 
}