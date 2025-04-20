<?php include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/admins.php");
?>
<div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <h1 class="text-center">Create Admin</h1>
<form action="http://localhost/dashboard/views_html/admins/create.php?action=insert" method="POST">
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">First Name</label>
    <div class="col-sm-8">
      <input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php if(isset($_POST['first_name'])) echo $_POST['first_name']?>">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Last Name</label>
    <div class="col-sm-8">
      <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php if(isset($_POST['last_name'])) echo $_POST['last_name']?>">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-8">
      <input type="email" name="email" class="form-control" placeholder="Email" value="<?php if(isset($_POST['email'])) echo $_POST['email']?>">
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
include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/includes/templates/footer.php");
if(isset($_SESSION['inputs'])) unset($_SESSION['inputs']);
?>