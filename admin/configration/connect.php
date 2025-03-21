<?php
 $dsn = 'mysql:host=localhost;dbname=easy_shop';
 $username = 'myuser';
 $password = 'reemaliiii';
 $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

 try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

?>