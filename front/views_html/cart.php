<?php include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/front/php_scripts/cart.php"); ?>
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
                      <?php 
                      if(!empty($carts)){
                      foreach($carts as $cart) { 
                     
                            $product = findProduct($cart);
                        
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
                              <form action="http://localhost/EasyShop/front/views_html/cart.php" method="POST" style="display:flex;">
                                <input type="hidden" name="action" value="remove"> 
                                     <input type="hidden" name="product" value="<?php echo $cart ?>">
                              <button type="submit" style="background: none; border: none; color: inherit; text-decoration: none; cursor: pointer; padding:2px 2px; margin-left: 40px;"><i class="fa-solid fa-trash confirm"></i></button>
                            </form>
                            </td>
                        </tr>
                      <?php }
                      }else{ ?>
                      <tr>
                        <td colspan="4">No items in cart</td>
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
                    <div class="h5 font-weight-bold px-md-2" style="color:red">$<?php echo $sum ? number_format($sum) : 0 ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php if(!empty($carts)){ ?>
<form action="http://localhost/EasyShop/front/views_html/cart.php" method="POST" style="display:flex; margin-left: 655px;">
 <input type="hidden" name="action" value="order">
 <h3 class="text-center"><button type="submit" class="btn btn-default" style="font-size: 15px;">Buy Now   <i class="fa-solid fa-bag-shopping" style="padding-left: 5px;"></i></button></h3>
</form>
<?php } include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/front/includes/templates/footer.php");