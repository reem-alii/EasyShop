<?php 
session_start();
if(isset($_SESSION['admin_id'])){
session_unset();
session_destroy();
header('Location: http://localhost/EasyShop/dashboard/views_html/login.php');
exit;
}else{
    header('Location: http://localhost/EasyShop/dashboard/views_html/login.php');
    exit;
}
