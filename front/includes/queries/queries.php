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