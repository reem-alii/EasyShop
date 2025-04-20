<?php
include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/init.php");
if(!isset($_SESSION['admin_id'])){
  header('Location: http://localhost/EasyShop/dashboard/views_html/login.php');
  exit;
}



// view index page
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $admins = getAllRows('admins');
}

//delete admin
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'delete'){
    $id = isset($_GET['adminid']) ? intval($_GET['adminid']) : 0;
    $stmt = $pdo->prepare('DELETE FROM admins WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: http://localhost/EasyShop/dashboard/views_html/admins/index.php');
    exit;
}

//insert admin in database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'insert'){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
    
        //validation 
        $errors_array = validateUserOrAdmin($first_name, $last_name, $email, $password);
        if(empty($errors_array)){
          // Insert
          insertUserOrAdmin($first_name, $last_name, $email, sha1($password), 'admins');      
          $_SESSION['success'] = "<div class='alert alert-success text-center'>Admin added successfully</div>";
          $_POST = [] ;
          unset($_SESSION['inputs']);
        }else{
            $_SESSION['errors'] = $errors_array;
            $_SESSION['inputs'] = array($first_name, $last_name, $email);
        }
        //header("refresh:0");
}
// view edit admin page
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'edit'){
    $id = $_GET['adminid'];
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
    $stmt->execute(array($id));
    $admin = $stmt->fetch();
}
//update admin in database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'update'){
    $id = $_GET['adminid'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'] ? $_POST['password'] : NULL ;
    //validation
    $errors_array = validateUserOrAdmin($first_name, $last_name, $email, $password, $id);
    if(empty($errors_array)){
        // Update
         updateUserOrAdmin('admins',$id, $first_name, $last_name, $email, $password);
         $_SESSION['success'] = "<div class='alert alert-success text-center'>Admin updated successfully</div>";
      }else{
          $_SESSION['errors'] = $errors_array;
      }
      $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
      $stmt->execute(array($id));
      $admin = $stmt->fetch();
}
// show admin page
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'show'){
    $id = intval($_GET['adminid']);
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
}

// display success and error messages
if(isset($_SESSION['success'])){ echo $_SESSION['success'] ; unset($_SESSION['success']);}
if (isset($_SESSION['errors'])){
    foreach($_SESSION['errors'] as $error){
        echo "<div class='alert alert-danger text-center'>".$error."</div>";
    }
    unset($_SESSION['errors']);
}
