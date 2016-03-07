<!DOCTYPE html>
<html>
<head>
    <title>ログイン画面</title>
</head>
<body>
<?php
    require_once("twitter_function.php");

    session_start();
    if (isset($_SESSION['username'])) {
        header('Location: /');
        exit();

    } elseif (!empty($_POST['mail_address']) && !empty($_POST['password'])) {
        $link = db_connect('192.168.56.123','akahira','akahira','twitter');
        $mail_address = $_POST['mail_address'];
        $password = $_POST['password'];
        if ($stmt = $link->prepare(
            "SELECT * FROM users WHERE usr_mail = ? AND usr_pw = ?")
        ) {
            $stmt->bind_param("ss",$mail_address,$password);
            $stmt->execute();
            $stmt->store_result();
            if($stmt->num_rows == 1){
                $stmt->bind_result($id,$usr_id,$usr_pw,$usr_mail);
                while ($stmt->fetch()) {
                    $_SESSION['username'] = $usr_id;
                }
            }
        }
        $stmt->close();
        header('Location: /');
        exit();

    }
?>
<form action="" method="POST">
    <table>
        <tr>
            <td>mail address<input type="text" name="mail_address"></td>
        </tr>
        <tr>
            <td>password：<input type="password" name="password" ></td>
        </tr>
    </table>
<input type="submit" value="ログイン">
</body>
</html>
