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
function checkUniqueValue($table, $column, $value){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM $table WHERE $column = ?");
    $stmt->execute($value);
    $count = $stmt->rowCount();

    return $count ;
}
// gel all categories
function getCats(){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM categories WHERE parent_id = 0");
    $stmt->execute();
    return $stmt->fetchAll();
}
// get all products
function getProducts(){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM products");
    $stmt->execute();
    return $stmt->fetchAll();
}