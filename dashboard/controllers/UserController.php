<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/pages/init.php");
//unset($_SESSION['row']);
// Insert User
if($_SERVER['REQUEST_METHOD']== 'POST' && isset($_GET['action']) && $_GET['action'] == 'add'){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //validation 
    $errors_array = validateUserOrAdmin($first_name, $last_name, $email, $password);
    if(empty($errors_array)){
      // Insert
      insertUserOrAdmin($first_name, $last_name, $email, sha1($password), 'users');      
      $_SESSION['success'] = "<div class='alert alert-success text-center'>User added successfully</div>";
    }else{
        $_SESSION['errors'] = $errors_array;
        $_SESSION['inputs'] = array($first_name, $last_name, $email);
    }
    header("Location:http://localhost/EasyShop/dashboard/pages/users_create.php");
}
// Show Edit User Page
if(isset($_GET['action']) && $_GET['action'] == 'edit'){
    $id = $_GET['userid'];
    echo $id ;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $_SESSION['row'] = $row ;
    header("Location:http://localhost/EasyShop/dashboard/pages/users_edit.php");
    exit;
}
// Update User
if($_SERVER['REQUEST_METHOD']== 'POST' && isset($_GET['action']) && $_GET['action'] == 'update'){
    $id = $_GET['userid'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'] ? $_POST['password'] : NULL ;
    //validation
    $errors_array = validateUserOrAdmin($first_name, $last_name, $email, $password, $id);
    if(empty($errors_array)){
        // Update
         updateUserOrAdmin('users',$id, $first_name, $last_name, $email, $password);
         $_SESSION['success'] = "<div class='alert alert-success text-center'>User updated successfully</div>";
         header("Location:http://localhost/EasyShop/dashboard/pages/users_index.php");
         exit;
      }else{
          $_SESSION['errors'] = $errors_array;
          header("Location:http://localhost/EasyShop/dashboard/controllers/UserController.php?action=edit&userid=".$id);
          exit;
      }
}
//delete user
if(isset($_GET['action']) && $_GET['action'] == 'delete'){
    $id = isset($_GET['userid']) ? intval($_GET['userid']) : 0;
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header("Location:http://localhost/EasyShop/dashboard/pages/users_index.php");
    exit;
}
// show user
if(isset($_GET['action']) && $_GET['action'] == 'show'){
    $id = intval($_GET['userid']);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $_SESSION['row'] = $row ;
    
    header("Location:http://localhost/EasyShop/dashboard/pages/users_show.php");
    exit;
}
if(isset($_GET['action']) && $_GET['action'] == 'approve'){
    $id = intval($_GET['userid']);
    $stmt = $pdo->prepare('UPDATE users SET reg_status = 1 WHERE id = ?');
    $stmt->execute(array($id));
    header("Location:http://localhost/EasyShop/dashboard/pages/users_index.php");
    exit;
}

