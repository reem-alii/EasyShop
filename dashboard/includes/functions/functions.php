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
    if(!move_uploaded_file($image["tmp_name"], $image_path)){
        $errors_array [] = "image failed to upload";
        $imgerror .= "image failed to upload/" . $image['error'];
    }
    if(empty($errors_array)){
        if(!move_uploaded_file($image["tmp_name"], $image_path)) {
            $errors_array [] = "image failed to upload";
            $imgerror .= "image failed to upload/" . $image['error'];
        }
    }
    
    return $image_path;
}
