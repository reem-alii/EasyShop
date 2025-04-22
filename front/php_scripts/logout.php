<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
if(isset($_SESSION['user_id'])){
  $_SESSION['user_id'] = NULL ;
  $_SESSION['user_email'] = NULL ;
  header("Location:http://".$_SERVER ['HTTP_HOST']."/front/views_html/index.php");
  exit;
}else{
    header("Location:http://".$_SERVER ['HTTP_HOST']."/front/views_html/login_signup.php");
    exit;
}