<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
ini_set('session.gc_maxlifetime', 2592000);
// each client should remember their session id for EXACTLY 1 hour
session_set_cookie_params(2592000);
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/configration/connect.php");
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/includes/templates/header.php");
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/includes/functions/functions.php");
if(isset($_SESSION['admin_id'])){
    include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/includes/templates/navbar.php");
}
