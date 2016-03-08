<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>ツイート編集</title>
</head>
<body>
<form action="" method="POST">
    <table border='0'>
    <tr>
        <td>
            ユーザー名：<?= $rows['usr_id']?>
        </td>
    </tr>
    <tr>
        <td>
        ツイート時間<?= $rows['tweettime']?>
        </td>
    </tr>
    <tr>
        <td>
        <TEXTAREA name="tweet_content" cols="40" rows="5"><?= $rows['content']?></TEXTAREA>
        </td>
    <tr>
        <td>
        <input type="hidden" name="tweet_id" values="<?= $rows['tweet_id']?>">
        </td>
    </tr>
    </table>
    <input type="submit" name="tweet_edit" value="編集">
    <input type="submit" name="tweet_delete" value="削除"></input>
</form>
</body>
</html>