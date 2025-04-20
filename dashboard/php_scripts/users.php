<?php
include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/init.php");
if(!isset($_SESSION['admin_id'])){
  header('Location: http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/login.php');
  exit;
}



// view index page
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $users = getAllRows('users');
}

//delete user
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'delete'){
    $id = isset($_GET['userid']) ? intval($_GET['userid']) : 0;
    $stmt = $pdo->prepare('DELETE FROM users WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/users/index.php');
    exit;
}

//approve user
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'approve'){
    $id = intval($_GET['userid']);
    $stmt = $pdo->prepare('UPDATE users SET reg_status = 1 WHERE id = ?');
    $stmt->execute(array($id));
    header('Location: http://'.$_SERVER ['HTTP_HOST'].'/dashboard/views_html/users/index.php');
    exit;
}

//insert user in database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'insert'){
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
          $_POST = [] ;
          unset($_SESSION['inputs']) ;
        }else{
            $_SESSION['errors'] = $errors_array;
            $_SESSION['inputs'] = array($first_name, $last_name, $email);
        }
}


// view edit user page
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'edit'){
    $id = $_GET['userid'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute(array($id));
    $user = $stmt->fetch();
}


//update user in database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'update'){
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
      }else{
          $_SESSION['errors'] = $errors_array;
      }
      $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
      $stmt->execute(array($id));
      $user = $stmt->fetch();
}


// show user page
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'show'){
    $id = intval($_GET['userid']);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    $stat = $row['reg_status'] ? '<span class="badge badge-pill badge-success">Approved</span>' : '<span class="badge badge-pill badge-warning">Not Approved </span>';
    $src = $row['image'] ? $row['image'] : "https://img.freepik.com/premium-vector/user-icons-includes-user-icons-people-icons-symbols-premiumquality-graphic-design-elements_981536-526.jpg?semt=ais_hybrid" ;
}


// display success and error messages
if(isset($_SESSION['success'])){ echo $_SESSION['success'] ; unset($_SESSION['success']);}
if (isset($_SESSION['errors'])){
    foreach($_SESSION['errors'] as $error){
        echo "<div class='alert alert-danger text-center'>".$error."</div>";
    }
    unset($_SESSION['errors']);
}
