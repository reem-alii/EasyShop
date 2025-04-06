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

// 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
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

?>
 <div class="container profile">
		<div class="main-body">
			<div class="row">
				<div class="col-lg-8">
					<div class="card">
					  <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
						<div class="card-body">
							<input type="hidden" name="type" value="info">
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Full Name</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="full_name" class="form-control" value="Enter Full name">
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
                            <div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Total Cost</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="total_cost" class="form-control" value="$" readonly>
								</div>
							</div>

							<div class="row">
								<div class="col-sm-3"></div>
								<div class="col-sm-9 text-secondary">
									<input type="submit" class="btn btn-primary px-4" value="Confirm Purchase">
								</div>
							</div>
						</div>
					  </form>
					</div>
				</div>
			</div>
		</div>
     </div>
<div class="container">
      <div class="row">
                <div class="col-md-12">
                </div>
            </div>
</div>
<?php
include "../includes/templates/footer.php";
}else{
	header("Location: login_signup.php");
}