<?php
// Validation of creating admin or user 
function validateUserOrAdmin($first_name, $last_name, $email, $password = NULL , $id = 0){
    $errors_array = [];
    if(strlen($first_name) < 3 || strlen($first_name) > 20 || empty($first_name)){
       $errors_array [] = "First name is required and must be between 3 and 20 characters";
    }
    if(strlen($last_name) < 3 || strlen($last_name) > 20 || empty($last_name)){
       $errors_array [] = "Last name is required and must be between 3 and 20 characters";
    }
    if(empty($email)){
        $errors_array [] = "Email is required";
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors_array [] = "Invalid email";
    }elseif(uniqueValue('admins','email', $email, $id) > 0){
        $errors_array [] = "Email must be unique";
    }
    if($password !== NULL){
        if(strlen($password) < 3 || strlen($password) > 20 || empty($password)){
            $errors_array [] = "Password is required and must be between 3 and 20 characters";
        }
    }   
    return $errors_array ;
}


function uniqueValue($table, $colomn, $value, $id = 0){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE $colomn = ? 
                            EXCEPT SELECT * FROM $table WHERE id = $id");
    $stmt->execute(array($value));
    $stmt->fetch();
    $count = $stmt->rowCount();
    return $count ;
}
// Insert into admins or users
function insertUserOrAdmin($first_name, $last_name, $email, $password, $table){
    global $pdo ;
    $stmt = $pdo->prepare("INSERT INTO $table(first_name, last_name, email, password) 
      VALUES(:zfirst, :zlast, :zemail, :zpass)");
      $stmt->execute(array(
        'zfirst' => $first_name,
        'zlast'  => $last_name,
        'zemail' => $email,
        'zpass'  => $password
      ));
}
// Update user or admin
function updateUserOrAdmin($table, $id, $first_name, $last_name, $email, $password = NULL){
    global $pdo ;
    if($password){
          $stmt = $pdo->prepare("UPDATE $table SET first_name = :zfirst, last_name = :zlast, email = :zemail , password = :zpass
                                  WHERE id = $id");  
          $stmt->execute(array(
            'zfirst' => $first_name,
            'zlast'  => $last_name,
            'zemail' => $email,
            'zpass'  => sha1($password)
          ));
    }else{
          $stmt = $pdo->prepare("UPDATE $table SET first_name = :zfirst, last_name = :zlast, email = :zemail
                                 WHERE id = $id");            
          $stmt->execute(array(
            'zfirst' => $first_name,
            'zlast'  => $last_name,
            'zemail' => $email
          ));
    }
}
//get sub cats for certain category by id
function getSubCats($id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = ?");
    $stmt->execute(array($id));
    return $stmt->fetchAll();
}

// get category by id
function findCat($id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute(array($id));
    return $stmt->fetch();
}
// get all main categories
function getMainCats(){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = 0");
    $stmt->execute();
    return $stmt->fetchAll();
}
// get total users 
function countRows($table){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT COUNT(id) FROM $table");
    $stmt->execute();
    return $stmt->fetchColumn();
}
// get total products
function allSubCats(){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id <> 0");
    $stmt->execute();
    return $stmt->fetchAll();     
}
function renameDuplicate($imagePath){
    $extension = pathinfo($imagePath, PATHINFO_EXTENSION);
    $imagename = pathinfo($imagePath, PATHINFO_FILENAME);
    $newname = $imagename . time() . '.' . $extension;
    $image_path = $_SERVER['DOCUMENT_ROOT']."/public/images/products/" . $newname;
    return $image_path;
}
// image validation 
function validateImage($image, &$errors_array, &$imgerror){
    if ($image["size"] > 400000) {
        $imgerror .= "image size is too large/";
        $errors_array [] = "image size must be less than 400 KB";
    }
    $image_path = $_SERVER['DOCUMENT_ROOT']."/public/images/products/" . basename($image["name"]);
    $imgtype =  strtolower(pathinfo($image_path,PATHINFO_EXTENSION));
    if (!in_array($imgtype, ['jpg', 'png', 'jpeg'])){
        $errors_array [] = "image must be in jpg, png or jpeg format";
        $imgerror .= "Invalid, only JPG, JPEG, PNG files are allowed/";
    }
    if (file_exists($image_path)) {
      $image_path = renameDuplicate($image_path);
    }
    if(empty($errors_array)){
        if(!move_uploaded_file($image["tmp_name"], $image_path)) {
            $errors_array [] = "image failed to upload";
            $imgerror .= "image failed to upload/" . $image['error'];
        }
        $image_path = "http://localhost/EasyShop/public/images/users/".basename($image["name"]);
    }

    return $image_path;    
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
// check refunded items 
function checkRefund($order_id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM order_items WHERE status = 1 AND order_id = $order_id");
    $stmt->execute();
    $stmt->fetch();
    return $stmt->rowCount();
}
// get order items of this order
function getOrderItems($order_id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT order_items.* , products.name , products.price FROM order_items 
    INNER JOIN products ON order_items.product_id = products.id WHERE order_items.order_id = $order_id");
    $stmt->execute();
    $items = $stmt->fetchAll();
    return $items;
}
// find product by id
function findProduct($id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = $id");
    $stmt->execute();
    return $stmt->fetch();
}
// refund item
function refundItem($order_id, $item_id){
    global $pdo ;
    $stmt = $pdo->prepare("UPDATE order_items SET status = :zval 
                           WHERE product_id = :zprod AND order_id = :zord");
    $stmt->execute(array(
    'zval' => '-1',
    'zprod' => $item_id,
    'zord' => $order_id,
    ));
    updateProductQuantity($item_id);
}
// update total cost after refund item
// function updateTotalCost($order_id, $price){
//     global $pdo ;
//     $stmt = $pdo->prepare("UPDATE orders SET total_cost = total_cost - ? 
//                            WHERE id = $order_id");
//     $stmt->execute(array($price));

// }
// update product quantity in database after refunding 
function updateProductQuantity($product_id){
    global $pdo ;
    $stmt = $pdo->prepare("UPDATE products SET stock = stock + 1 WHERE id = $product_id");
    $stmt->execute();
}
// cancel order 
function cancelOrder($order_id){
    global $pdo ;
    $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = $order_id");
    $stmt->execute(array('Canceled'));
    returnItemsToStock($order_id);
}
// refund order
function refundOrder($order_id){
    global $pdo ;
    $items = getOrderItems($order_id);
    foreach ($items as $item) {
        if($item['status'] == 1){
        refundItem($order_id, $item['product_id']);
        }
    }
}
// return items to stock after order Cancellation
function returnItemsToStock($order_id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT product_id FROM order_items WHERE order_id = $order_id");
    $stmt->execute();
    $items = $stmt->fetchAll();
    foreach ($items as $item) {
        updateProductQuantity($item['product_id']);
    }
}
// get user by id 
function findUser($id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = $id");
    $stmt->execute();
    return $stmt->fetch();
}
// get All rows
function getAllRows($table){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM $table");
    $stmt->execute();
    return $stmt->fetchAll();
}