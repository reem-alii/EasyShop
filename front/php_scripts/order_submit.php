<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/front/php_scripts/init.php");

if(isset($_SESSION['user_id'])){
$email = $_SESSION['user_email'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->execute(array($email));
$user = $stmt->fetch();

$order_id = $_SESSION['order_id'] ;
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? LIMIT 1");
$stmt->execute(array($order_id));
$order = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$full_name   = $_POST['full_name'];
	$phone   = $_POST['phone'];
	$address = $_POST['address'];

	$errors_array = array();
	$errors_array = orderValidation($full_name, $address, $phone, $errors_array);
	if(empty($errors_array)){
		$status = updateOrderQuery($order['id'], $full_name, $phone, $address);
		if($status){
			unset($_SESSION['order_id']);
			header("Location:http://".$_SERVER ['HTTP_HOST']."/front/views_html/profile.php");
			exit;
		}else{
			echo "<div class='alert alert-danger text-center'>Failed to make order</div>";
		}
	}else{
        $_SESSION['order_errors'] = [] ;
		foreach($errors_array as $err){
			$_SESSION['order_errors'] [] =  '<div class="alert alert-danger text-center">'.$err.'</div>';
		}
	}
}
}else{
    header("Location:http://".$_SERVER ['HTTP_HOST']."/front/views_html/login_signup.php");
}