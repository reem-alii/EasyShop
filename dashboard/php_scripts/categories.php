<?php
include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/init.php");
if(!isset($_SESSION['admin_id'])){
  header('Location: http://localhost/EasyShop/dashboard/views_html/login.php');
  exit;
}



// view index page
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $cats = getAllRows('categories');
}

//delete category
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'delete'){
  $id = isset($_GET['catid']) ? intval($_GET['catid']) : 0;
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: http://localhost/EasyShop/dashboard/views_html/categories/index.php');
    exit;
}

//insert category in database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'insert'){
    $name = $_POST['name'];
    $parent_id = intval($_POST['parent_id']);

    //validation 
    $errors_array = [];
    if (strlen($name) < 3 || strlen($name) > 20){
      $errors_array [] = "name must be between 3 and 20 characters";
    }
    $name_unique = uniqueValue('categories','name', $name);
    if($name_unique > 0){
      $errors_array [] = "name must be unique";
    }
    if (empty($errors_array)) {
      $stmt = $pdo->prepare("INSERT INTO categories(name, parent_id) 
      VALUES(:zname, :zparent)");
      $stmt->execute(array(
        'zname' => $name,
        'zparent' => $parent_id
      ));
      $_POST = [];
      $_SESSION['success'] = "<div class='alert alert-success text-center'>Category added successfully</div>";
    }else{
            $_SESSION['errors'] = $errors_array;
    }  
}
// view edit category page
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'edit'){
  $id = $_GET['catid'];
  $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
  $stmt->execute(array($id));
  $row = $stmt->fetch();
}
//update category in database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'update'){
  $id = $_POST['id'];
  $name = $_POST['name'];
  $parent_id = $_POST['parent_id'];
   
  //validation 
  $errors_array = [];
  if (strlen($name) < 3 || strlen($name) > 20){
    $errors_array [] = "name must be between 3 and 20 characters";
    $nerror =  "name must be between 3 and 20 characters";
  }
  $name_unique = uniqueValue('categories', 'name', $name, $id);
  if($name_unique > 0){
    $errors_array [] = "name must be unique";
    $nerror =  "name must be unique";
  }
  if(empty($errors_array)) {
    $stmt = $pdo->prepare("UPDATE categories SET name = :zname, parent_id = :zparent
                           WHERE id = $id");
    $stmt->execute(array(
      'zname' => $name,
      'zparent' => $parent_id
    ));
    $_SESSION['success'] = "<div class='alert alert-success text-center'>Category updated successfully</div>";
  }else{
    $_SESSION['errors'] = $errors_array;
  }
  $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
  $stmt->execute(array($id));
  $row = $stmt->fetch();
}
// show category page
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'show'){
  $id = intval($_GET['catid']);
  $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
  $stmt->execute(array($id));
  $row = $stmt->fetch();
  if(!$row){
    $_SESSION['errors'] []= "Category not found";
    header('Location: http://localhost/EasyShop/dashboard/views_html/categories/index.php');
    exit;   
  }else{
    $cat = findCat($row['parent_id']) ;
    $parent = $cat ? $cat['name'] : "Main Category(no parent)";
    $subs = getSubCats($row['id']);
  }
}

// display success and error messages
if(isset($_SESSION['success'])){ echo $_SESSION['success'] ; unset($_SESSION['success']);}
if (isset($_SESSION['errors'])){
    foreach($_SESSION['errors'] as $error){
        echo "<div class='alert alert-danger text-center'>".$error."</div>";
    }
    unset($_SESSION['errors']);
}
