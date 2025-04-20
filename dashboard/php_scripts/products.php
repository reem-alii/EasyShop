<?php
include_once($_SERVER['DOCUMENT_ROOT']."/dashboard/php_scripts/init.php");
if(!isset($_SESSION['admin_id'])){
  header('Location: http://localhost/dashboard/views_html/login.php');
  exit;
}



// view index page
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $products = getAllRows('products');
}

//delete product
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'delete'){
    $id = isset($_GET['prodid']) ? intval($_GET['prodid']) : 0;
    $prod = $pdo->prepare("SELECT * FROM products WHERE id = $id");
    $prod->execute();
    $product = $prod->fetch();
    unlink($product['Image']);
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: http://localhost/dashboard/views_html/products/index.php');
    exit;
}

//approve product
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'approve'){
    $id = isset($_GET['prodid']) ? intval($_GET['prodid']) : 0;
    $stmt = $pdo->prepare('UPDATE products SET approve = 1 WHERE id = ?');
    $stmt->execute(array($id));
    header('Location: http://localhost/dashboard/views_html/products/index.php');
    exit;
}

//insert product in database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'insert'){
    $name = $_POST['name'];
    $des = $_POST['description'];
    $price = intval($_POST['price']);
    $image = $_FILES['image'];
    $cat = $_POST['cat_id'];
    $sub = $_POST['subcat_id'];
    $country = $_POST['country_made'];
    $quantity = $_POST['stock'];

    //validation 
    $errors_array = [];
    if (strlen($name) < 3 || strlen($name) > 20){
      $errors_array [] = "name must be between 3 and 20 characters";
      $nerror =  "name must be between 3 and 20 characters";
    }
    if (strlen($des) < 3 ){
        $errors_array [] = "description must be more than 3 characters";
        $derror =  "description must be more than 3 characters";
    }
    if ($price == 0 || empty($price)) {
      $errors_array [] = "Invalid, Price is required and must be numeric and not equal to 0";
      $perror = "Invalid, Price is required and must be numeric and not equal to 0";
    }
    if(empty($country)){
        $errors_array [] = "country is required";
        $cerror =  "country is required";
    }
    if (!is_numeric($quantity) || empty($quantity) || $quantity < 1) {
      $errors_array [] = "Invalid, Quantity is required and must be numeric and more than 1";
      $qerror = "Invalid, Quantity is required and must be numeric and more than 1";
    }
    //start image validation 
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
      $imgerror = "";
      $image_path = validateImage($image, $errors_array, $imgerror);
    }else{
      $errors_array [] = "image is required";
      $imgerror = "image is required";
    }
    if(empty($errors_array)) {
      $stmt = $pdo->prepare("INSERT INTO products(name, description, price, Image, country_made, stock, cat_id, subcat_id, created_at) 
      VALUES(:zname, :zdes, :zprice, :zimg, :zcountry, :zstock, :zcat, :zsub, :zcreated)");
      $stmt->execute(array(
        'zname'    => $name,
        'zdes'     => $des,
        'zprice'   => $price,
        'zimg'     => $image_path,
        'zcountry' => $country,
        'zstock'   => $quantity,
        'zcat'     => $cat,
        'zsub'     => $sub,
        'zcreated' => date("Y-m-d")
      ));
      $_POST = [] ;
      $_SESSION['success'] = "<div class='alert alert-success text-center'>Product added successfully</div>";
    }else{
        $_SESSION['errors'] = $errors_array;
    }
    
}


// view edit product page
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'edit'){
    $id = $_GET['prodid'];
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
    if(!$row){
        $_SESSION['errors'] []= "Invalid, Product not found";
        header('Location: http://localhost/dashboard/views_html/products/index.php');
        exit;
    }
}


//update product in database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'update'){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $des = $_POST['description'];
    $price = intval($_POST['price']);
    $image = $_FILES['image'];
    $cat = $_POST['cat_id'];
    $sub = $_POST['subcat_id'];
    $country = $_POST['country_made'];
    $stock = $_POST['stock'];

    //validation 
    $errors_array = [];
    if (strlen($name) < 3 || strlen($name) > 20){
      $errors_array [] = "name must be between 3 and 20 characters";
      $nerror =  "name must be between 3 and 20 characters";
    }
    if (strlen($des) < 3 ){
        $errors_array [] = "description must be more than 3 characters";
        $derror =  "description must be more than 3 characters";
    }
    if (!is_numeric($price) || empty($price)) {
      $errors_array [] = "Invalid, Price is required and must be numeric";
      $perror = "Invalid, Price is required and must be numeric";
    }
    if(empty($country)){
        $errors_array [] = "country is required";
        $cerror =  "country is required";
    }
    if (!is_numeric($stock) || is_null($stock)) {
      $errors_array [] = "Invalid, Stock is required and must be numeric";
      $serror = "Invalid, Stock is required and must be numeric";
    }
    //start image validation 
    $imgerror = "";
    if(is_uploaded_file($_FILES['image']['tmp_name'])){
      $image_path = validateImage($image, $errors_array, $imgerror);
    }
    if (empty($errors_array) && isset($image_path)) {
      $stmt = $pdo->prepare("UPDATE products SET name = :zname, description = :zdes, price = :zprice, Image = :zimg, country_made = :zcountry, stock = :zstock, cat_id = :zcat, subcat_id = :zsub 
                             WHERE id = $id");
      $stmt->execute(array(
        'zname'    => $name,
        'zdes'     => $des,
        'zprice'   => $price,
        'zimg'     => $image_path,
        'zcountry' => $country,
        'zstock'   => $stock,
        'zcat'     => $cat,
        'zsub'     => $sub
      ));
    }elseif(empty($errors_array)){
      $stmt = $pdo->prepare("UPDATE products SET name = :zname, description = :zdes, price = :zprice, country_made = :zcountry, stock = :zstock, cat_id = :zcat, subcat_id = :zsub 
                             WHERE id = $id");
      $stmt->execute(array(
        'zname'    => $name,
        'zdes'     => $des,
        'zprice'   => $price,
        'zcountry' => $country,
        'zstock'   => $stock,
        'zcat'     => $cat,
        'zsub'     => $sub
      ));
      
    }
    $_POST = [];
    $_SESSION['success'] = "<div class='alert alert-success text-center'>Product Updated successfully</div>";
    
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute(array($id));
    $row = $stmt->fetch();
}


// show product page
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'show'){
  $id = intval($_GET['prodid']);
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute(array($id));
  $row = $stmt->fetch();
  if(!$row){
    $_SESSION['errors'] [] = "Product not found";
    header('Location: http://localhost/dashboard/views_html/products/index.php');
    exit;
  }else{
    $cat = findCat($row['cat_id']);
    $sub = findCat($row['subcat_id']);
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
