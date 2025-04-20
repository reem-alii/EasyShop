<?php
include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/init.php");
if(!isset($_SESSION['admin_id'])){
  header('Location: http://localhost/EasyShop/dashboard/views_html/login.php');
  exit;
}

