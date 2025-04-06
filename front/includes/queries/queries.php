<?php
session_start();
function signUpQuery($first_name, $last_name, $email, $password){
    global $pdo ;
    $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password)
                           VALUES (:zfname, :zlname, :zemail, :zpass)");
    $stmt->execute(array(
            'zfname' => $first_name,
            'zlname' => $last_name,
            'zemail' => $email,
            'zpass'  => $password
    ));
    $success = 'You have been registered successfully ! You Can Login';
    return $success;
}
function loginQuery($email, $password){
    global $pdo ;
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :zemail AND password = :zpass LIMIT 1");
    $stmt->execute(array(
        'zemail' => $email,
        'zpass'  => $password
    ));
    $row = $stmt->fetch();
    if($row){
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_email'] = $row['email'];
        return true;
    }else{
        return false;
    }
}
function editProfileQuery($id, $fname, $lname, $phone, $address){
    global $pdo ;
    $stmt = $pdo->prepare("UPDATE users SET first_name = :zfname, last_name = :zlname, phone = :zphone, address = :zaddress 
                           WHERE id = $id");
    $stmt->execute(array(
        'zfname' => $fname,
        'zlname' => $lname,
        'zphone' => $phone,
        'zaddress' => $address
    ));
    return true;
}
function uploadImageQuery($id, $image_path){
    global $pdo ;
    $stmt = $pdo->prepare("UPDATE users SET image = ? WHERE id = $id");
    $stmt->execute(array($image_path));
    return true;
}
function updatePassword($id, $pass){
    global $pdo ;
    $password = sha1($pass);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = $id");
    $stmt->execute(array($password));
    return true;
}