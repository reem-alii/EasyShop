<?php 
include "init.php";
include "../includes/templates/navbar.php";
if(isset($_SESSION['user_id'])){
$email = $_SESSION['user_email'];
error_reporting(E_ALL);
ini_set('display_errors',1);
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
?>
 <div class="container profile">
		<div class="main-body">
			<div class="row">
                <div class="col-lg-12">
                </div>
				<div class="col-lg-4">
					<div class="card">
						<div class="card-body">
							<div class="d-flex flex-column align-items-center text-center">
                            <img src="<?php echo $user['image'] ? $user['image'] : "https://bootdey.com/img/Content/avatar/avatar7.png" ; ?>" alt="Admin" class="rounded-circle" width="150" height="150">
                            <div class="mt-3">
									<p>Change Profile Picture</p>
                                    <form action ="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
									    <input type="hidden" name="type" value="pic">
                                        <input type="file" name="image" required>   
									    <button class="btn btn-primary" style="font-size: 25px;"><i class="fa-solid fa-camera"></i></button>
                                    </form>  
								</div>
							</div>
							<hr class="my-4">
							<ul class="list-group list-group-flush">
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="card">
					  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
						<div class="card-body">
							<input type="hidden" name="type" value="info">
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">First Name</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="first_name" class="form-control" value="<?php echo $user['first_name'] ?>">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Last Name</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="last_name" class="form-control" value="<?php echo $user['last_name'] ?>">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Email</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="email" class="form-control" value="<?php echo $user['email'] ?>" readonly>
								</div>
							</div>
                            <div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Phone</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="phone" class="form-control" value="<?php echo $user['phone'] ?>">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Address</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="address" class="form-control" value="<?php echo $user['address'] ?>">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3"></div>
								<div class="col-sm-9 text-secondary">
									<input type="submit" class="btn btn-primary px-4" value="Save Changes">
								</div>
							</div>
						</div>
					  </form>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4">
				</div>	
				<div class="col-md-8">
					<div class="card">
					<h5 class="card-title text-center" style="padding-top: 7px;">Change Password</h5>
					<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
						<div class="card-body">
						  <input type="hidden" name="type" value="pass">
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">New Passsword</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="password" name="password" class="form-control" placeholder="******">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Password Confirmation</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="password" name="password_confirmation" class="form-control" placeholder="******">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-3"></div>
								<div class="col-sm-9 text-secondary">
									<input type="submit" class="btn btn-primary px-4" value="Save Changes">
								</div>
							</div>
						</div>
					  </form>
					</div>
				</div>
			</div>
		</div>
     </div>
<?php
include "../includes/templates/footer.php";
}else{
	header("Location: login_signup.php");
}