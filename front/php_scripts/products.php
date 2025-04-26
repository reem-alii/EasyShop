<?php
include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/front/php_scripts/init.php");

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $product = $_POST['product_id']; 
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if(!in_array($product,$_SESSION['cart'],true)){
        $_SESSION['cart'][] = $product ;
    } 
    $_SESSION['success_cart'] = "<div class='alert alert-success text-center'>Product added to cart successfully</div>";

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

?>