<?php
include_once($_SERVER['DOCUMENT_ROOT']."/front/php_scripts/init.php");

    $carts = isset($_SESSION['cart']) ?  $_SESSION['cart'] : [];
    $sum = 0;
    foreach($carts as $cart){
        $product = findProduct($cart);
        $sum += $product['price'];
    }
    $count = count($carts);
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'remove'){
        $prod_id = $_POST['product'];
        $index = array_search($prod_id, $_SESSION['cart']);
        unset($_SESSION['cart'][$index]);
        header("Location:http://localhost/EasyShop/front/views_html/cart.php");
    }
//if(isset($_SESSION['user_id'])){
//   $id = $_SESSION['user_id'];
//   $carts = findCarts($id);
//   $sum = totalPriceCart($id);

//   $count = countCartItems($id);
//   if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'remove'){
//     $cart_id = $_POST['cart_id'];
//     removeFromCart($cart_id);
//     header("Refresh:0");
//   }
//}
  if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'order'){
    if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'] ;
    $email = $_SESSION['user_email'];
    $quantity = $count ;
    $total_cost = $sum ;
    $order_number = '#'. str_pad(random_int(1,9999),4,"0",STR_PAD_LEFT);
    $order_date = date('Y-m-d');
    $order = makeOrder($user_id, $email, $quantity, $total_cost, $order_number, $order_date);
    if($order['id']){
        foreach($carts as $cart){
            insertOrderItems($order['id'], $cart);
        }
        $_SESSION['order_id'] = $order['id'];
        unset($_SESSION['cart']);
        //emptyCart($id);
        header('Location:http://localhost/EasyShop/front/views_html/order_submit.php');
        exit;
    } 
    }else{
        header("Location:http://localhost/EasyShop/front/views_html/login_signup.php");
        exit;
    }
  }

// }else{
//     $carts = isset($_SESSION['cart']) ?  $_SESSION['cart'] : [];
//     $sum = 0;
//     foreach($carts as $cart){
//         $product = findProduct($cart);
//         $sum += $product['price'];
//     }
//     $count = count($carts);
//     if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'remove'){
//         $prod_id = $_POST['product'];
//         $index = array_search($prod_id, $_SESSION['cart']);
//         unset($_SESSION['cart'][$index]);
//         header("Refresh:0");
//     }

// }

?>