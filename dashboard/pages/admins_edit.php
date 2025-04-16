<?php
session_start();
if(!isset($_SESSION['admin_id'])){
  header("Location: http://localhost/EasyShop/dashboard/pages/index.php");
}
include "init.php";
if(isset($_SESSION['success'])){ echo $_SESSION['success'] ; unset($_SESSION['success']);}
if(isset($_SESSION['errors'])){
  foreach($_SESSION['errors'] as $error){
    echo "<div class='alert alert-danger text-center'>".$error."</div>";
  }
  unset($_SESSION['errors']);
} 
?>
<div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <h1 class="text-center">Edit Admin</h1>
<form action="http://localhost/EasyShop/dashboard/controllers/AdminController.php?action=update&adminid=<?php echo $_SESSION['row']['id'] ;?>" method="POST">
  <div class="form-group row">
    <input type="hidden" name="id" value="<?php echo $_SESSION['row']['id'] ?>">
    <label for="inputEmail3" class="col-sm-2 col-form-label">First Name</label>
    <div class="col-sm-8">
      <input type="text" name="first_name" class="form-control" id="inputEmail3" placeholder="First Name" value="<?php echo $_SESSION['row']['first_name'] ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Last Name</label>
    <div class="col-sm-8">
      <input type="text" name="last_name" class="form-control" id="inputEmail3" placeholder="Last Name" value="<?php echo $_SESSION['row']['last_name'] ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-8">
      <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" value="<?php echo $_SESSION['row']['email'] ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-8">
      <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Leave it empty if you want to keep the old password">
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10 text-center">
      <button type="submit" class="btn btn-success">Submit</button>
    </div>
  </div>
</form>
</div>
</div>
</div>
<?php 
include "../includes/templates/footer.php"; 
//unset($_SESSION['row']);
