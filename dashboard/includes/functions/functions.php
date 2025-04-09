<?php
function uniqueValue($table, $colomn, $value, $id = 0){
    global $pdo ;
    if($id == 0){
       $stmt = $pdo->prepare("SELECT * FROM $table WHERE $colomn = ?");
    }else{
        $stmt = $pdo->prepare("SELECT * FROM $table WHERE $colomn = ? 
                               EXCEPT SELECT * FROM $table WHERE id = $id");
    }
    $stmt->execute(array($value));
    $stmt->fetch();
    $count = $stmt->rowCount();
    return $count ;
}

//get sub cats for certain category by id
function getSubCats($id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = ?");
    $stmt->execute(array($id));
    return $stmt->fetchAll();
}
// get category by id
function getCat($id){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute(array($id));
    return $stmt->fetch();
}
// get all main categories
function getCats(){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = 0");
    $stmt->execute();
    return $stmt->fetchAll();
}
// get total users 
function getTotalUsers(){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT COUNT(id) FROM users");
    $stmt->execute();
    return $stmt->fetchColumn();
}
// get total products
function getTotalProducts(){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT COUNT(id) FROM products");
    $stmt->execute();
    return $stmt->fetchColumn();
}
// get total orders 
function getTotalOrders(){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT COUNT(id) FROM orders");
    $stmt->execute();
    return $stmt->fetchColumn();
}
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
    $image_path = "../../public/images/" . $newname;
    return $image_path;
}
// image validation 
function validateImage($image, &$errors_array, &$imgerror){
    if ($image["size"] > 400000) {
        $errors_array [] = "image size must be less than 400 KB";
        $imgerror .= "image size is too large/";
    }
    $image_path = "../../public/images/" . basename($image["name"]);
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
// Order Validation for Status and Payment Status 
function statusValidation($status, $payment_status, &$errors_array){
    if($status == "" || $payment_status == ""){
        $errors_array[] = "Please fill in all fields";
    }
    if(!in_array($status, [ 'Processing', 'Pending', 'Delivered'])){
        $errors_array[] = "Invalid Status, Can only be: Processing, Pending, Canceled, Delivered, or Refunded";
    }
    if(!in_array($payment_status, ['Pending', 'Completed', 'Failed', 'Canceled'])){
        $errors_array[] = "Invalid Payment Status, Can only be: Pending, Completed, Failed, Canceled";
    }
    return $errors_array ;
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
function refundItem($order_id, $item_id, $price){
    global $pdo ;
    $stmt = $pdo->prepare("UPDATE order_items SET status = :zval 
                           WHERE product_id = :zprod AND order_id = :zord");
    $stmt->execute(array(
    'zval' => '-1',
    'zprod' => $item_id,
    'zord' => $order_id,
    ));
    updateTotalCost($order_id, $price);
    updateProductQuantity($item_id);
}
// update total cost after refund item
function updateTotalCost($order_id, $price){
    global $pdo ;
    $stmt = $pdo->prepare("UPDATE orders SET total_cost = total_cost - ? 
                           WHERE id = $order_id");
    $stmt->execute(array($price));

}
// update product quantity in database after refunding 
function updateProductQuantity($product_id){
    global $pdo ;
    $stmt = $pdo->prepare("UPDATE products SET stock = stock + 1 WHERE id = $product_id");
    $stmt->execute();
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