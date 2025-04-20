<?php 
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/php_scripts/init.php");
if(isset($_SESSION['admin_id'])){
    header('Location: http://localhost/EasyShop/dashboard/views_html/dashboard.php');
    exit;
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    $email    = $_POST['email'];
    $password = $_POST['password'];

    //validation
    $errors_array = [];
    if(empty($email)) {
      $errors_array [] = "Email is Required";
      $emailerror = "Email is Required";
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $errors_array [] = "Invalid email";
      $emailerror = "Enter Valid Email";
    }
    if(empty($password)){
      $errors_array [] = "Password is required";
      $passerror = "Password is required";
    }elseif(strlen($password) < 6){
      $errors_array [] = "Password must be at least 6 characters";
      $passerror = "Password must be at least 6 characters";
    }
    if(empty($errors_array)){
        $stmt = $pdo->prepare('SELECT * FROM admins WHERE email = :zemail AND password = :zpass LIMIT 1');
        $stmt->execute(array(
          ':zemail' => $email,
          ':zpass'  => sha1($password)
        ));
        $admin = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['first_name'];
            header('Location: http://localhost/EasyShop/dashboard/views_html/dashboard.php');
            exit;
        }else{
            $error = 'Invalid email or password';
        }
    }else{
      foreach($errors_array as $err){
        echo "<div class='errors alert alert-danger'>".$err."</div>";
      }
    }
}