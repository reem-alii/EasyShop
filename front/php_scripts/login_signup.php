<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/front/php_scripts/init.php");

if(!isset($_SESSION['user_id'])){
if($_SERVER['REQUEST_METHOD'] == "POST"){
    // Sign Up
    if(isset($_POST['logname'])){
        $first_name = $_POST['logname'];
        $last_name = $_POST['logname'];
        $email = $_POST['logemail'];
        $password = sha1($_POST['logpass']);

        // Validation 
        $errors_array = signUpValidation($first_name, $email, $password);
        // Insering
        if(empty($errors_array)){
           $success = signUpQuery($first_name, $last_name, $email, $password);
        }
    }else{ // Login
        $email = $_POST['logemail'];
        $password = sha1($_POST['logpass']);

        // Validation
        $errors_array = loginValidation($email, $password);
        // Login
        if(empty($errors_array)){
            if(loginQuery($email, $password)){
				// Insert cart items into database 
				//if(isset($_SESSION['cart'])) {
					// foreach($_SESSION['cart'] as $cart){
					// 	$user_id =$_SESSION['user_id'];
					// 	$product = findProduct($cart);
					// 	$product_price = $product['price'];
					// 	$status = addToCart($user_id, $cart, $product_price);
					// }
				//}
                header("Location:http://localhost/EasyShop/front/views_html/index.php");
                exit();
            }else{
                $errors_array[] = "Invalid Email or Password";
            }
        }

    }

}
if(isset($success)){
   echo '<div class="alert alert-success text-center alert-reg">'.$success.'</div>' ;
}
if(!empty($errors_array)){
    foreach($errors_array as $error){
        echo '<div class="alert alert-danger text-center">'.$error.'</div>' ;
    }
}
}else{
    header("Location:http://localhost/EasyShop/front/views_html/index.php");
}

?>