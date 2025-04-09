<?php
// Sign Up Validation
function signUpValidation($name, $email, $password){
    $errors_array = array();
    if(empty($name)) {
        $errors_array [] = 'first name is required';
    }
    if(empty($password) || strlen($password) < 6) {
        $errors_array [] = 'password is required and must be at least 6 characters';
    }
    if(empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors_array [] = 'email is required and must be valid';
    }
    if(checkUniqueValue('users', 'email', $email) > 0){
        $errors_array [] = 'email already exists';
    }
    return $errors_array;
}
// Login Validation
function loginValidation($email, $password){
    $errors_array = array();
    if(empty($email) || !filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors_array [] = 'email is required and must be valid';
    }
    if(empty($password)) {
        $errors_array [] = 'password is required';
    }
    return $errors_array;
}
// Check Unique Value
function checkUniqueValue($table, $column, $value = 0){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();

    return $count ;
}
// gel all categories
function getAllCats(){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = 0");
    $stmt->execute();
    return $stmt->fetchAll();
}
// get all products
function getAllProducts(){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM products");
    $stmt->execute();
    return $stmt->fetchAll();
}
// get cat by id
function getCatById($id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = $id");
    $stmt->execute();
    $cat = $stmt->fetch();
    return $cat;
}
// get products by cat id 
function getProductsByCatId($id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE cat_id = $id");
    $stmt->execute();
    return $stmt->fetchAll();
}
// get subCats by cat id
function getSubCats($id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = $id");
    $stmt->execute();
    return $stmt->fetchAll();
}
// profile Update Validation
function profileValidation($fname , $lname, $phone, $address, &$errors_array){
    if (empty($fname) || strlen($fname) < 3 || strlen($fname) > 20){
        $errors_array [] = "First Name is required and must be between 3 and 20 characters";
    }
    if (empty($lname) || strlen($lname) < 3 || strlen($lname) > 20){
        $errors_array [] = "Last Name is required and must be between 3 and 20 characters";
    }
    if(!filter_var(intval($phone),FILTER_VALIDATE_INT)){
        $errors_array [] = "Enter validate Phone number";
    }
    if (empty($phone) || strlen($phone) < 7 || strlen($phone) > 20){
        $errors_array [] = "Phone number is required and must be between 10 and 20 characters";
    }
    if (empty($address) || strlen($address) < 5){
        $errors_array [] = "Address is required and must be valid";
    }
    return $errors_array;
}
// Rename Duplicated Image
function renameDuplicate($imagePath){
    $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $imagename = pathinfo($imagePath, PATHINFO_FILENAME);
    $newname = $imagename . time() . '.' . $extension;
    $image_path = "../../public/images/" . $newname;
    return $image_path;
}
// Validate Profile Image
function validateImage($image, &$imgerrors){
    if ($image["size"] > 400000) {
        $imgerrors .= "image size is too large/";
    }
    $image_path = "../../public/images/" . basename($image["name"]);
    $imgtype =  strtolower(pathinfo($image_path,PATHINFO_EXTENSION));
    if (!in_array($imgtype, ['jpg', 'png', 'jpeg'])){
      $imgerrors .= "Invalid, only JPG, JPEG, PNG files are allowed/";
    }
    if (file_exists($image_path)) {
      $image_path = renameDuplicate($image_path);
    }
    if(!$imgerrors){
        if(!move_uploaded_file($image["tmp_name"], $image_path)) $imgerrors .= "image failed to upload/";
    }
    return $image_path;
}
// Validate Change Password 
function validatePassword($pass, $repass, &$passerror){
    if (empty($pass) || strlen($pass) < 6 || strlen($pass) > 20){
        $passerror .= "Password is required and must be between 6 and 20 characters/";
    }
    if (empty($repass) || $repass != $pass ){
        $passerror .= "Password and Confirm Password must match";
    }
    return $passerror;
}
// get carts
function findCarts($user_id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM carts WHERE user_id = $user_id");
    $stmt->execute();
    return $stmt->fetchAll();
}
// find product by id
function findProduct($id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = $id");
    $stmt->execute();
    return $stmt->fetch();
}
// Add to cart button 
function addToCart($user_id, $product_id, $product_price){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM carts WHERE product_id = ? ");
    $stmt->execute([$product_id]);
    if($stmt->rowCount() == 0 ){
       $stmt = $pdo->prepare("INSERT INTO carts (user_id, product_id, product_price)
                              VALUES (:user_id, :product_id, :product_price)");
       $stmt->execute(array(
            ':user_id' => $user_id,
            ':product_id' => $product_id,
            ':product_price' => $product_price
        ));
        return true ;                       
    }
    return true ;                       
}
//total price of cart 
function totalPriceCart($user_id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT SUM(product_price) FROM carts WHERE user_id = $user_id");
    $stmt->execute();
    return $stmt->fetchColumn();
}
// remove from cart
function removeFromCart($id){
    global $pdo ;
    $stmt = $pdo->prepare("DELETE FROM carts WHERE id = $id");
    $stmt->execute();
}
// number of cart items
function countCartItems($user_id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM carts WHERE user_id = $user_id");
    $stmt->execute();
    return $stmt->fetchColumn();
}
// Make order
function makeOrder($user_id, $email, $quantity, $total_cost, $order_number, $order_date){
    global $pdo ;
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, email, quantity, total_cost, order_number, created_at)
                            VALUES (:zid, :zemail, :zquantity, :zcost, :zorder_num, :zdate)");   
    $stmt->execute(array(
        ':zid' => $user_id,
        ':zemail' => $email,
        ':zquantity' => $quantity,
        ':zcost' => $total_cost,
        ':zorder_num' => $order_number,
        ':zdate' => $order_date
    ));
    // get order that has just created
    $stmt = $pdo->prepare("SELECT * FROM orders where user_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->execute(array($user_id));
    $order = $stmt->fetch();
    return $order ;
    //return $stmt->debugDumpParams(); --> log of statement
    //return $pdo->lastInsertId();
}
// Insert Order Items 
function insertOrderItems($order_id, $product_id){
    global $pdo ;
    $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id)
                            VALUES (:zord_id, :zprod_id)");
    $stmt->execute(array(
        ':zord_id'  => $order_id,
        ':zprod_id' => $product_id
    ));
    //update quantity in database
    updateProductQuantity($product_id);
}
// empty cart for this user
function emptyCart($user_id){
    global $pdo ;
    $stmt = $pdo->prepare("DELETE FROM carts WHERE user_id = $user_id");
    $stmt->execute();
}
// get orders of this user
function getOrders($user_id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = $user_id");
    $stmt->execute();
    return $stmt->fetchAll();
}
// Order Validation for Update Order 
function orderValidation($full_name, $address, $phone, &$errors_array){
    if(empty($full_name) || empty($address) || empty($phone)) {
        $errors_array[] = "Please fill in all fields";
    }
    if(strlen($full_name) < 3 || strlen($full_name) > 20){
        $errors_array[] = "Full name must be between 3 and 20 characters";
    }
    if(strlen($address) < 3 || strlen($address) > 50){
        $errors_array[] = "Address must be between 3 and 50 characters";
    }
    if(!filter_var(intval($phone),FILTER_VALIDATE_INT)){
        $errors_array[] = "Enter Valid Phone number";
    }
    return $errors_array ;
}
function updateProductQuantity($product_id){
    global $pdo ;
    $stmt = $pdo->prepare("UPDATE products SET stock = stock - 1 WHERE id = $product_id");
    $stmt->execute();
}
