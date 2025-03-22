<?php
session_start();
if(isset($_SESSION['admin_id'])){
  include "init.php";
   if($_SERVER['REQUEST_METHOD']== 'POST'){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //validation 
    $errors_array = [];
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
      $errors_array [] = "Please fill all fields";
    }
    if (strlen($first_name) < 3 || strlen($first_name) > 20){
      $errors_array [] = "First name must be between 3 and 20 characters";
      $ferror =  "First name must be between 3 and 20 characters";
    }
    if (strlen($last_name) < 3 || strlen($last_name) > 20 ){
      $errors_array [] = "Last name must be between 3 and 20 characters";
      $lerror =  "Last name must be between 3 and 20 characters";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errors_array [] = "Invalid email";
      $eerror =  "Invalid email";
    }
    $email_unique = uniqueValue('admins','email', $email);
    if($email_unique > 0){
      $errors_array [] = "Email must be unique";
      $eerror =  "Email must be unique";
    }
    if (strlen($password) < 6 || strlen($password) > 20) {
      $errors_array [] = "Password must be between 6 and 20 characters";
      $perror =  "Password must be between 6 and 20 characters";
    }
    if (empty($errors_array)) {
      $hashed_password = sha1($password);
      $stmt = $pdo->prepare("INSERT INTO admins(first_name, last_name, email, password) 
      VALUES(:zfirst, :zlast, :zemail, :zpass)");
      $stmt->execute(array(
        'zfirst' => $first_name,
        'zlast'  => $last_name,
        'zemail' => $email,
        'zpass'  => $hashed_password
      ));
      $_POST = [];
      echo "<div class='alert alert-success'>Admin added successfully</div>";
    }
   }

?>
<div class="container">
    <div class="row">
      <div class="col-md-1">
      </div>
      <div class="col-md-10">
      <h1 class="text-center">Create Admin</h1>
<form action=<?php echo $_SERVER['PHP_SELF']?> method="POST">
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">First Name</label>
    <div class="col-sm-8">
      <input type="text" name="first_name" class="form-control" id="inputEmail3" placeholder="First Name" value="<?php echo $_POST['first_name'] ? $_POST['first_name'] : "" ?>">
      <div class="err" style="color:red;"><?php echo $ferror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Last Name</label>
    <div class="col-sm-8">
      <input type="text" name="last_name" class="form-control" id="inputEmail3" placeholder="Last Name" value="<?php echo $_POST['last_name'] ? $_POST['last_name'] : "" ?>">
      <div class="err" style="color:red;"><?php echo $lerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
    <div class="col-sm-8">
      <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" value="<?php echo $_POST['email'] ? $_POST['email'] : "" ?>">
      <div class="err" style="color:red;"><?php echo $eerror ; ?></div>
    </div>
  </div>
  <div class="form-group row">
    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
    <div class="col-sm-8">
      <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
      <div class="err" style="color:red;"><?php echo $perror ; ?></div>
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
}else{
  header("Location: index.php");
}
?>