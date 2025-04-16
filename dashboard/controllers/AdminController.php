<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/pages/init.php");
//unset($_SESSION['row']);
// Insert Admin
if($_SERVER['REQUEST_METHOD']== 'POST' && isset($_GET['action']) && $_GET['action'] == 'add'){
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
    }else{
        $_SESSION['errors'] = $errors_array;
        $_SESSION['inputs'] = array($first_name, $last_name, $email);
    }
    header("Location:http://localhost/EasyShop/dashboard/pages/admins_create.php");
}
// Show Edit Admin Page
if(isset($_GET['action']) && $_GET['action'] == 'edit'){
    $id = $_GET['adminid'];
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $_SESSION['row'] = $row ;
    header("Location:http://localhost/EasyShop/dashboard/pages/admins_edit.php");
}
// Update Admin 
if($_SERVER['REQUEST_METHOD']== 'POST' && isset($_GET['action']) && $_GET['action'] == 'update'){
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
         header("Location:http://localhost/EasyShop/dashboard/pages/admins_index.php");
         exit;
      }else{
          $_SESSION['errors'] = $errors_array;
          header("Location:http://localhost/EasyShop/dashboard/controllers/AdminController.php?action=edit&adminid=".$id);
          exit;
      }
}
//delete admin
if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $id = isset($_GET['adminid']) ? intval($_GET['adminid']) : 0;
    $stmt = $pdo->prepare('DELETE FROM admins WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location:http://localhost/EasyShop/dashboard/pages/admins_index.php");
    exit;
}
// show admin 
if(isset($_GET['action']) && $_GET['action'] == 'show'){
    $id = intval($_GET['adminid']);
    $stmt = $pdo->prepare("SELECT * FROM admins WHERE id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $_SESSION['row'] = $row ;
    
    header("Location:http://localhost/EasyShop/dashboard/pages/admins_show.php");
    exit;

}
