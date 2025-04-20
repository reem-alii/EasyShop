<?php
session_start();
if(isset($_SESSION['user_id'])){
unset($_SESSION['user_id'] , $_SESSION['user_email']);
//session_destroy();
header("Location:http://'.$_SERVER ['HTTP_HOST'].'/front/views_html/index.php");
exit;
}else{
    header("Location:http://'.$_SERVER ['HTTP_HOST'].'/front/views_html/login_signup.php");
}