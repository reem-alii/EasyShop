<?php include_once($_SERVER['DOCUMENT_ROOT']."/front/php_scripts/order_submit.php");
if(isset($_SESSION['order_errors'])){
    foreach($_SESSION['order_errors'] as $error){
        echo $error;
    }
    unset($_SESSION['order_errors']);
}
 ?>

<div class="container profile">
		<div class="main-body">
			<div class="row">
				<div class="col-lg-8">
					<div class="card">
					  <form action="http://localhost/front/views_html/order_submit.php" method="POST">
						<div class="card-body">
							<input type="hidden" name="type" value="info">
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Full Name</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="full_name" class="form-control" placeholder="Enter Full name">
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
									<h6 class="mb-0">Order num</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" class="form-control" value="<?php echo $order['order_number'] ?>" readonly>
								</div>
							</div>
                            <div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Total Cost</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input type="text" name="total_cost" class="form-control" value="$<?php echo $order['total_cost'] ?>" readonly>
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
include_once($_SERVER['DOCUMENT_ROOT']."/front/includes/templates/footer.php");
