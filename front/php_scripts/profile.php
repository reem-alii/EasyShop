<?php
include_once($_SERVER['DOCUMENT_ROOT']."/front/php_scripts/init.php");

if(isset($_SESSION['user_id'])){
  $email = $_SESSION['user_email'];
  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
  $stmt->execute(array($email));
  $user = $stmt->fetch();

  //orders
  $orders = getOrders($user['id']);
}else{
    header("Location:http://".$_SERVER ['HTTP_HOST']."/front/views_html/login_signup.php");
}

?>