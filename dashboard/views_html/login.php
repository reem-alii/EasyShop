<?php include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/php_scripts/login.php"); ?>

<div class="container log">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center" style="margin:10px;">Admin Login</h1>
<div class="d-flex align-items-center justify-content-center">
 <form class="login" action="<?php echo $_SERVER['PHP_SELF']?>"  method="POST">
  <div class="form-group row">
    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-10">
      <input type="text" name="email" class="form-control" id="staticEmail" value="<?php if(isset($_POST['email'])) echo $_POST['email']?>">
        <div class="err" style="color:red;"><?php if(isset($emailerror)) echo $emailerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" name="password" class="form-control" id="inputPassword">
      <div class="err" style="color:red;"><?php if(isset($passerror)) echo $passerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <div class="col-sm-10">
     <button type="submit" class="btn btn-primary"> Submit</button>
     </div>
   </div>
 </form>
 </div>
</div>
</div>
</div>

<?php
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/includes/templates/footer.php");
