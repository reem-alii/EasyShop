<?php 
include "init.php" ;
if(!isset($_SESSION['user_id'])){
error_reporting(E_ALL);
ini_set('display_errors',1);
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
				if(isset($_SESSION['cart'])) {
					foreach($_SESSION['cart'] as $cart){
						$user_id =$_SESSION['user_id'];
						$product = findProduct($cart);
						$product_price = $product['price'];
						$status = addToCart($user_id, $cart, $product_price);
					}
				}
                header('Location: index.php');
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

?>
<div class="section">
		<div class="container loginsign">
			<div class="row full-height justify-content-center">
				<div class="col-12 text-center align-self-center py-5">
					<div class="section pb-5 pt-5 pt-sm-2 text-center">
						<h6 class="mb-0 pb-3"><span>Log In </span><span>Sign Up</span></h6>
			          	<input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
			          	<label for="reg-log"></label>
						<div class="card-3d-wrap mx-auto">
							<div class="card-3d-wrapper">
								<div class="card-front">
									<div class="center-wrap">
										<div class="section text-center">
										 <h4 class="mb-4 pb-3">Log In</h4>
                                           <form action="<?php echo $_SERVER['PHP_SELF'] ; ?>" method="POST">
											<div class="form-group">
												<input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" autocomplete="off">
												<i class="input-icon uil uil-at"></i>
											</div>	
											<div class="form-group mt-2">
												<input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" autocomplete="off">
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
                                            <button type="submit" class="btn mt-4">submit</button>
                                           </form>
											<!--<a href="#" class="btn mt-4">submit</a>
                            				<p class="mb-0 mt-4 text-center"><a href="#0" class="link">Forgot your password?</a></p>-->
				      					</div>
			      					</div>
			      				</div>
								<div class="card-back">
									<div class="center-wrap">
										<div class="section text-center">
										  <h4 class="mb-4 pb-3">Sign Up</h4>
                                           <form action="<?php echo $_SERVER['PHP_SELF'] ; ?>" method="POST">
											<div class="form-group">
												<input type="text" name="logname" class="form-style" placeholder="Your Full Name" id="logname" >
												<i class="input-icon uil uil-user"></i>
											</div>	
											<div class="form-group mt-2">
												<input type="email" name="logemail" class="form-style" placeholder="Your Email" id="logemail" >
												<i class="input-icon uil uil-at"></i>
											</div>	
											<div class="form-group mt-2">
												<input type="password" name="logpass" class="form-style" placeholder="Your Password" id="logpass" >
												<i class="input-icon uil uil-lock-alt"></i>
											</div>
                                            <button type="submit" class="btn mt-4">submit</button>
											<!--<a href="#" class="btn mt-4">submit</a>-->
                                           </form>
				      					</div>
			      					</div>
			      				</div>
			      			</div>
			      		</div>
			      	</div>
		      	</div>
	      	</div>
	    </div>
	</div>
<?php
include "../includes/templates/footer.php";
}else{
	header("location: index.php");
}