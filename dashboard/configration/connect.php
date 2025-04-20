<?php
 $dsn = 'mysql:host=localhost;dbname=easy_shop_db';
 $username = 'easy_shop_user';
 $password = 'test@123';
 $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');

 try {
    $pdo = new PDO($dsn, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    /*$stmt = $pdo->prepare("CREATE TABLE users(
                                id int NOT NULL AUTO_INCREMENT,
                                first_name varchar(255) NOT NULL,
                                last_name varchar(255) NOT NULL,
                                email varchar(255) NOT NULL,
                                password varchar(255) NOT NULL,
                                image varchar(255),
                                phone varchar(255),
                                address varchar(255),
                                reg_status tinyint,
                                PRIMARY KEY (id));
                           CREATE TABLE admins(
                                id int NOT NULL AUTO_INCREMENT,
                                first_name varchar(255) NOT NULL,
                                last_name varchar(255) NOT NULL,
                                email varchar(255) NOT NULL,
                                password varchar(255) NOT NULL,
                                PRIMARY KEY (id));
                           CREATE TABLE categories(
                                id int NOT NULL AUTO_INCREMENT,
                                name varchar(255) NOT NULL,
                                parent_id int NOT NULL DEFAULT 0,
                                PRIMARY KEY (id));
                           CREATE TABLE products(
                                id int NOT NULL AUTO_INCREMENT,
                                name varchar(255) NOT NULL,
                                description varchar(255) NOT NULL,
                                price int NOT NULL,
                                Image varchar(255),
                                country_made varchar(255) NOT NULL,
                                stock int NOT NULL DEFAULT 100,
                                approve tinyint NOT NULL DEFAULT 0,
                                cat_id int NOT NULL,
                                subcat_id int NOT NULL DEFAULT 0,
                                created_at date NOT NULL,
                                PRIMARY KEY (id));
                            CREATE TABLE carts(
                                id int NOT NULL AUTO_INCREMENT,
                                user_id int NOT NULL,
                                product_id int NOT NULL,
                                product_price int NOT NULL,
                                PRIMARY KEY (id));
                            CREATE TABLE orders(
                                id int NOT NULL AUTO_INCREMENT,
                                user_id int NOT NULL,
                                full_name varchar(255),
                                phone varchar(255),
                                address varchar(255),
                                quantity int NOT NULL,
                                total_cost int NOT NULL,
                                order_number varchar(255) NOT NULL,
                                status enum('Processing','Pending','Canceled','Delivered','Refunded') NOT NULL DEFAULT 'Processing',
                                payment_status enum('Pending', 'Paid', 'Canceled', 'Refunded') NOT NULL DEFAULT 'Pending',
                                created_at date NOT NULL,
                                PRIMARY KEY (id)); 
                            CREATE TABLE order_items(
                                id int NOT NULL AUTO_INCREMENT,
                                order_id int NOT NULL,
                                product_id int NOT NULL,
                                status enum('1', '-1') NOT NULL DEFAULT 1,
                                PRIMARY KEY (id));
                        ");
    $stmt->execute();
    echo "Table created successfully"; */
    /*$stmt = $pdo->prepare("INSERT INTO admins (first_name, last_name, email, password)
                            VALUES (:zfname, :zlname, :zemail, :zpass )");
    $stmt->execute(array(
        ':zfname' => 'admin',
        ':zlname' => 'admin',
        ':zemail' => 'admin@shop.com',
        ':zpass'  => sha1(123456789)
    ));                     

    echo "Database seeded successfully!";
    */
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
    }

?>