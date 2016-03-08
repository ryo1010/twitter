<?php
class Login
{
    function login_check()
    {
        session_start();
        if (!isset($_SESSION['username'])) {
            include  'login.php';
            exit();
        } elseif (isset($_SESSION['username'])) {
            return true;
        }

    }
}
