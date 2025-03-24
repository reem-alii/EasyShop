<?php
 $dsn = 'mysql:host=localhost;dbname=easy_shop';
 $username = 'myuser';
 $password = 'reemaliiii';
 $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

 try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $stmt = $pdo->prepare("INSERT INTO admins (first_name, last_name, email, password)
    //                         VALUES (:zfname, :zlname, :zemail, :zpass )");
    // $stmt->execute(array(
    //     ':zfname' => 'admin',
    //     ':zlname' => 'admin',
    //     ':zemail' => 'admin@shop.com',
    //     ':zpass'  => sha1(123456789)
    // ));                     

    //echo "Database seeded successfully!";

    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

?>