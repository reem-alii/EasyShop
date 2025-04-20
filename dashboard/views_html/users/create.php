<?php include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/php_scripts/users.php"); ?>

<div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <h1 class="text-center">Create User</h1>
<form action="http://localhost/EasyShop/dashboard/views_html/users/create.php?action=insert" method="POST">
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">First Name</label>
    <div class="col-sm-8">
      <input type="text" name="first_name" class="form-control" id="inputEmail3" placeholder="First Name" value="<?php if(isset($_SESSION['inputs'])) echo $_SESSION['inputs'][0] ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Last Name</label>
    <div class="col-sm-8">
      <input type="text" name="last_name" class="form-control" id="inputEmail3" placeholder="Last Name" value="<?php if(isset($_SESSION['inputs']))  echo $_SESSION['inputs'][1] ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-8">
      <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" value="<?php if(isset($_SESSION['inputs']))  echo $_SESSION['inputs'][2] ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-8">
      <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
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
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/includes/templates/footer.php");