<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/front/php_scripts/init.php");

if(isset($_SESSION['user_id'])){
$email = $_SESSION['user_email'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->execute(array($email));
$user = $stmt->fetch();

// Update information only
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['type'] == "info"){
	$fname   = $_POST['first_name'];
	$lname   = $_POST['last_name'];
	$phone   = $_POST['phone'];
	$address = $_POST['address'];

	$errors_array = array();
	$errors_array = profileValidation($fname, $lname, $phone, $address, $errors_array);
	if(empty($errors_array)){
		$status = editProfileQuery($user['id'], $fname, $lname, $phone, $address);
		if($status){
			echo "<div class='alert alert-success text-center'>Profile updated successfully, Reload to see Changes !</div>";
		}else{
			echo "<div class='alert alert-danger text-center'>Failed to update profile</div>";
		}
	}else{
		foreach($errors_array as $err){
			echo '<div class="alert alert-danger text-center">'.$err.'</div>';
		}
	}
}
// Update profile picture only
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['type'] == "pic"){
	$image = $_FILES['image'];
	$imgerrors = NULL;
	$image_path = validateImage($image, $imgerrors);
	if($imgerrors){
		echo '<div class="alert alert-danger text-center">'.$imgerrors.'</div>';
	}else{
		$status = uploadImageQuery($user['id'], $image_path);
		if($status){
			echo "<div class='alert alert-success text-center'>Profile picture updated successfully</div>";
			header("Rrefresh:0");
		}else{
			echo "<div class='alert alert-danger text-center'>Failed to update profile picture</div>";
		}
	}
}
// Update password only
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['type'] == "pass"){
	$pass = $_POST['password'];
	$repass = $_POST['password_confirmation'];
	$passerror = NULL ;
	$passerror = validatePassword($pass, $repass, $passerror);
	if(!$passerror){
		$status = updatePassword($user['id'], $pass);
		if($status){
			echo "<div class='alert alert-success text-center'>Password updated successfully</div>";
		}else{
			echo "<div class='alert alert-danger text-center'>Failed to update password</div>";
		}
	}else{
		echo '<div class="alert alert-danger text-center">'.$passerror.'</div>';
	}
}
}else{
    header("Location:http://".$_SERVER ['HTTP_HOST']."/EasyShop/front/views_html/login_signup.php");
}
?>