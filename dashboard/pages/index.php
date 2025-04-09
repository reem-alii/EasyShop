<?php 
include "init.php";
error_reporting(E_ALL);
ini_set('display_errors',1);
if(isset($_SESSION['admin_id'])){
  header('Location: dashboard.php');
  exit;
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    $email = $_POST['email'];
    $password = sha1($_POST['password']);

    //validation
    $errors_array = [];
    if(empty($email) || empty($password)) {
      $errors_array [] = "Please fill in all fields";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $errors_array [] = "Invalid email";
    }
    if(strlen($password) < 4){
      $errors_array [] = "Password must be at least 4 characters";
    }
    if(empty($errors_array)){

        $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = ? AND password = ? LIMIT 1');
        $stmt->execute(array($email, $password));
        $admin = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['first_name'];
            header('Location: dashboard.php');
            exit;
        }else{
            $error = 'Invalid email or password';
        }
    }else{
      foreach($errors_array as $error){
        echo "<div class='errors alert alert-danger'>".$error."</div>";
      }
    }
}63
?>
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
        <div class="err" style="color:red;"><?php if(isset($error)) echo $error ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-10">
      <input type="password" name="password" class="form-control" id="inputPassword">
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

<?php include "../includes/templates/footer.php"; ?>