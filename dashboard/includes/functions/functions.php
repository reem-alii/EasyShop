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

// if($_SERVER['REQUEST_METHOD'] == 'POST'){
//    function getSubCats($id){
//        global $pdo ;
//        $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = ?");
//        $stmt->execute(array($id));
//        //return $stmt->fetchAll();
//        //return response()->json($stmt->fetchAll());
//        return json_encode($stmt->fetchAll());
//    }
// }