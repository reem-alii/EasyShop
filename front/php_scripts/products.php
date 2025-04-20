<?php
include_once($_SERVER['DOCUMENT_ROOT']."/front/php_scripts/init.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){
//   if(isset($_SESSION['user_id'])){
//     $user_id = $_POST['user_id'];
//     $product_id = $_POST['product_id'];
//     $product_price = $_POST['product_price'];
//     $status = addToCart($user_id, $product_id, $product_price);
//     if($status){
//         echo "<div class='alert alert-success text-center'>Product added to cart successfully</div>";
//     }else{
//         echo "<div class='alert alert-danger text-center'>Failed to add product to cart</div>";
//     }
//   }else{
    $product = $_POST['product_id']; 
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if(!in_array($product,$_SESSION['cart'],true)){
        $_SESSION['cart'][] = $product ;
    } 
    $_SESSION['success_cart'] = "<div class='alert alert-success text-center'>Product added to cart successfully</div>";
  //}

}
$cat_id = intval($_GET['catid']);
$cat = getCatById($cat_id);
$subcats = NULL;
if(!empty($cat)){
    $products = getProductsByCatId($cat_id) ;
    $subcats = getSubCats($cat_id);
}else{
    $products = getAllProducts() ;
}
//header("Location:http://localhost/EasyShop/front/views_html/products.php?catid=0");
//exit;
?>