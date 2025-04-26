<?php
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/php_scripts/init.php");
if(!isset($_SESSION['admin_id'])){
  header('Location: http://'.$_SERVER ['HTTP_HOST'].'/EasyShop/dashboard/views_html/login.php');
  exit;
}



// view index page
if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $orders = getAllRows('orders');
}

//delete order
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'delete'){
    $id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
    $stmt = $pdo->prepare('DELETE FROM orders WHERE id = :id');
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    header('Location: http://'.$_SERVER ['HTTP_HOST'].'/EasyShop/dashboard/views_html/orders/index.php');
    exit;
}

//cancel order
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'cancel'){
    $id = intval($_GET['order_id']) ;
    cancelOrder($id);
    header('Location: http://'.$_SERVER ['HTTP_HOST'].'/EasyShop/dashboard/views_html/orders/index.php');
    exit;
}

// view details page
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'details'){
    $order_id = intval($_GET['order_id']);
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
    $stmt->execute(array($order_id));
    $order = $stmt->fetch();
    $order_items = getOrderItems($order_id);
}

//update order in database
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['action']) && $_GET['action'] == 'update'){
    $id = intval($_GET['order_id']);
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $status = $_POST['status'] ? $_POST['status'] : NULL;
    $payment_status = $_POST['payment_status'] ? $_POST['payment_status'] : NULL;
    switch($status){
        case 'Delivered':
            $payment_status = 'Paid';
            break;
        case 'Canceled':
            $payment_status = 'Canceled';
            cancelOrder($id);
            break;
        case 'Refunded':
            $payment_status = 'Refunded';
            refundOrder($id);
    }
    $errors_array = [];
    $errors_array = orderValidation($full_name, $phone, $address, $errors_array);
    if(empty($errors_array)){
         if($status && $payment_status){
           $stmt = $pdo->prepare("UPDATE orders SET full_name = ?, phone = ?, address = ?, status = ?, payment_status = ?
                                WHERE id = $id");
           $stmt->execute(array($full_name, $phone, $address, $status, $payment_status));
         }else{
           $stmt = $pdo->prepare("UPDATE orders SET full_name = ?, phone = ?, address = ?
                                WHERE id = $id");
           $stmt->execute(array($full_name, $phone, $address));
         }
         $_SESSION['success'] = "<div class='alert alert-success text-center'>Order updated successfully</div>";
         header('Location: http://'.$_SERVER ['HTTP_HOST'].'/EasyShop/dashboard/views_html/orders/details.php?action=details&order_id='.$id);
         exit;
    }else{
        $_SESSION['errors'] = $errors_array;
    }
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE id = ?');
    $stmt->execute(array($id));
    $order = $stmt->fetch();
    $order_items = getOrderItems($id);
}


// refund item
if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']) && $_GET['action'] == 'refund'){
    $item_id = $_GET['itemid'];
    $order_id = $_GET['order_id'];
    refundItem($order_id, $item_id);
    $check = checkRefund($order_id);
    if($check < 1){
        $stmt = $pdo->prepare("UPDATE orders SET status = ? , payment_status = ? WHERE id = $order_id");
        $stmt->execute(array('Refunded', 'Refunded'));
    }else{
        $stmt = $pdo->prepare("UPDATE orders SET status = ? , payment_status = ? WHERE id = $order_id");
        $stmt->execute(array('Delivered', 'Paid'));
    }
    $_SESSION['success'] = "<div class='alert alert-success text-center'>Item refunded successfully</div>";
    header('Location: http://'.$_SERVER ['HTTP_HOST'].'/EasyShop/dashboard/views_html/orders/details.php?action=details&order_id='.$order_id);
    exit;
}


// display success and error messages
if(isset($_SESSION['success'])){ echo $_SESSION['success'] ; unset($_SESSION['success']);}
if (isset($_SESSION['errors'])){
    foreach($_SESSION['errors'] as $error){
        echo "<div class='alert alert-danger text-center'>".$error."</div>";
    }
    unset($_SESSION['errors']);
}
