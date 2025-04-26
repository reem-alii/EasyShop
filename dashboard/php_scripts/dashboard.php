<?php
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/php_scripts/init.php");
if(!isset($_SESSION['admin_id'])){
  header('Location: http://'.$_SERVER ['HTTP_HOST'].'/EasyShop/dashboard/views_html/login.php');
  exit;
}

