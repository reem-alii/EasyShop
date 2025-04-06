<?php
include "init.php";
include "../includes/templates/navbar.php";
if(isset($_SESSION['user_id'])){
  $id = $_SESSION['user_id'];
  $carts = findCarts($id);
  $sum = totalPriceCart($id);
  $count = countCartItems($id);
  if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] = 'remove'){
    $cart_id = $_POST['cart_id'];
    removeFromCart($cart_id);
    header("Refresh:0");
  }
}else{
    $carts = isset($_SESSION['cart']) ?  $_SESSION['cart'] : [];
    $sum = 0;
    foreach($carts as $cart){
        $product = findProduct($cart);
        $sum += $product['price'];
    }
    $count = count($carts);
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] = 'remove'){
        $prod_id = $_POST['product'];
        $index = array_search($prod_id, $_SESSION['cart']);
        unset($_SESSION['cart'][$index]);
        header("Refresh:0");
    }

}
// if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] = 'remove'){
//   $cart_id = $_POST['cart_id'];
//   removeFromCart($cart_id);
//   header("Refresh:0");
// }
if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] = 'order'){
    
}

?>
       <h1 class="text-center">My Cart <i class="fa-solid fa-cart-shopping"></i></h1>
<div class="cart">
   <div class="wrapper">
        <div id="table" class="bg-white rounded">
        <h6 style="padding-top: 7px; padding-left: 15px;">Shopping Cart (<?php echo $count ?> item<small>(s)</small> in your cart) </h6>
            <div class="d-md-flex align-items-md-center px-3 pt-3">    
            <div class="table-responsive">
                <table class="table activitites">
                    <thead>
                        <tr>
                            <th scope="col" class="text-uppercase header">item</th>
                            <th scope="col" class="text-uppercase">Quantity</th>
                            <th scope="col" class="text-uppercase">price</th>
                            <th scope="col" class="text-uppercase">remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="item">
                                <div class="d-flex">
                                    <img src="https://images.unsplash.com/photo-1601479604588-68d9e6d386b5?ixid=MXwxMjA3fDB8MHxzZWFyY2h8MXx8Y2FuZGxlc3xlbnwwfHwwfA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
                                    <div class="pl-2">
                                        Suspended Heart Candles
                                        <div class="d-flex flex-column justify-content-center"><div class="text-muted">Blue</div></div>
                                    </div>
                            </td>
                            <td>1</td>
                            <td class="d-flex flex-column">
                                <span>$21.40</span>
                            </td>
                            <td>
                              <i class="fa-solid fa-trash" style="  margin-left: -10px;"></i>
                            </td>
                        </tr>
                      <?php foreach($carts as $cart) { 
                        if(isset($_SESSION['user_id'])){
                            $product = findProduct($cart['product_id']);
                        }else{
                            $product = findProduct($cart);
                        }
                      ?>
                        <tr>
                            <td class="item">
                                <div class="d-flex">
                                    <img src="<?php echo $product['Image'] ?>" alt="">
                                    <div class="pl-2">
                                        <?php echo $product['name'] ;?>
                                        <div class="d-flex flex-column justify-content-center"><div class="text-muted"><?php echo $product['description'] ;?></div></div>
                                    </div>
                            </td>
                            <td>1</td>
                            <td class="d-flex flex-column">
                                <span>$<?php echo $product['price'] ;?></span>
                            </td>
                            <td>
                              <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" style="display:flex;">
                                <input type="hidden" name="action" value="remove"> 
                                <?php if(isset($_SESSION['user_id'])){ ?>
                                <input type="hidden" name="cart_id" value="<?php echo $cart['product_id'] ?>">
                                <?php }else{ ?>
                                <input type="hidden" name="product" value="<?php echo $cart ?>">
                                <?php } ?>
                              <button type="submit" style="background: none; border: none; color: inherit; text-decoration: none; cursor: pointer; padding:2px 2px; margin-left: 40px;"><i class="fa-solid fa-trash confirm"></i></button>
                            </form>
                            </td>
                        </tr>
                      <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div class="d-flex flex-column justify-content-end align-items-end">
                <div class="d-flex px-3 pr-md-5 py-1 subtotal">
                    <div class="px-4">Total Price</div>
                    <div class="h5 font-weight-bold px-md-2" style="color:red">$<?php echo number_format($sum) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" style="display:flex; margin-left: 655px;">
 <input type="hidden" name="action" value="order">
 <h3 class="text-center"><button type="submit" class="btn btn-default" style="font-size: 15px;">Buy Now   <i class="fa-solid fa-bag-shopping" style="padding-left: 5px;"></i></button></h3>
</form>
<?php
include "../includes/templates/footer.php";
