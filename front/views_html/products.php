<?php include_once($_SERVER['DOCUMENT_ROOT']."/front/php_scripts/products.php");
if(isset($_SESSION['success_cart'])) { echo $_SESSION['success_cart'] ; unset($_SESSION['success_cart']); }
 if($subcats){?>
<!-- Second Navbar -->
<div class="header-dark prod">
            <nav class="navbar navbar-dark navbar-expand-md navigation-clean-search">
                    <div class="collapse navbar-collapse"
                        id="navcol-1">
                        <ul class="nav navbar-nav" style="margin-left: 500px;">
                          <h1 class="text-center navbar-brand"><?php echo $cat['name'] ?>:</h1>
                            <li class="nav-item" onclick="filterSelection('all')" role="presentation" style="margin: 5px;background-color: #4b4b4e;border-radius: 20px;"><a class="nav-link" >All</a></li>
                            <?php foreach($subcats as $sub) { 
                                     echo '<li class="nav-item" onclick="filterSelection(\''.$sub['name'].'\')" role="presentation" style="margin: 5px;background-color: #4b4b4e;border-radius: 20px;"><a class="nav-link">'.$sub['name'].'</a></li>';
                                   }
                             ?>
                        </ul>
                        <form class="form-inline mr-auto" target="_self">
                           <!-- <div class="form-group"><label for="search-field"><i class="fa fa-search"></i></label><input class="form-control search-field" type="search" name="search" id="search-field"></div>-->
                        </form>
                </div>
            </nav>
<!-- /second navbar -->
<?php } ?>
 <div class="products">
<div class="container products d-flex justify-content-center mt-50 mb-50">           
        <div class="row">
          <?php foreach($products as $product){
              $sub = getCatById(intval($product['subcat_id'])) ;
             ?>
            <div class="col-md-4 mt-2 filterDiv <?php echo $sub['name'] ?>">          
                <div class="card">
                    <div class="card-body" style="background-color: #807f84;">
                        <div class="card-img-actions">
                           <!--<img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" width="96" height="350" alt="">-->
                           <img src="<?php echo $product['Image']; ?>" class="card-img img-fluid" width="100%" alt="">               
                        </div>
                    </div>
                    <div class="card-body text-center" style=" background-color: #4b4b4e;">
                        <div class="mb-2">
                        <h6 class="font-weight-semibold mb-2">
                            <a href="#" class="text-default mb-2" data-abc="true"><?php echo $product['name'] ?> Toshiba Notebook</a>
                        </h6>
                            <a href="#" class="text-muted" style="color: #a7b3bd !important" data-abc="true"><?php echo $product['description'] ?></a>
                        </div>
                        <h3 class="mb-0 font-weight-semibold" style="color:white;">$<?php echo $product['price'] ?></h3>
                            <div class="text-muted mb-3" style="color: #a7b3bd !important">34 reviews</div>
                          
                            <form action="http://'.$_SERVER ['HTTP_HOST'].'/front/views_html/products.php?catid=<?php echo $cat_id ?>" method="POST" style="display:flex;"> 
                              <?php if(isset($_SESSION['user_id'])) { ?>
                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id'] ?>">
                              <?php } ?>
                                <input type="hidden" name="product_id" value="<?php echo $product['id'] ?>">
                                <input type="hidden" name="product_price" value="<?php echo $product['price'] ?>">
                              <button type="submit" class="btn bg-cart" style="margin-left: 65px;"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button> 
                            </form>
                    </div>
                </div>                        
            </div> 
            <?php } ?>
            <div class="col-md-4 mt-2">          
                <div class="card">
                    <div class="card-body" style="background-color: #807f84;">
                        <div class="card-img-actions">
                           <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" alt="">
                        </div>
                    </div>
                    <div class="card-body text-center" style=" background-color: #4b4b4e;">
                        <div class="mb-2">
                        <h6 class="font-weight-semibold mb-2">
                            <a href="#" class="text-default mb-2" data-abc="true">Toshiba Notebook with 500GB</a>
                        </h6>
                            <a href="#" class="text-muted" style="color: #a7b3bd !important" data-abc="true">Laptops & Notebooks</a>
                        </div>
                        <h3 class="mb-0 font-weight-semibold" style="color:white;">$250.99</h3>
                            <div class="text-muted mb-3" style="color: #a7b3bd !important">34 reviews</div>
                            <a href="#" class="btn bg-cart" ><i class="fa fa-cart-plus mr-2"></i> Add to cart</a>                
                    </div>
                </div>                        
            </div> 
            <div class="col-md-4 mt-2">          
                <div class="card">
                    <div class="card-body" style="background-color: #807f84;">
                        <div class="card-img-actions">
                           <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" alt="">
                        </div>
                    </div>
                    <div class="card-body text-center" style=" background-color: #4b4b4e;">
                        <div class="mb-2">
                        <h6 class="font-weight-semibold mb-2">
                            <a href="#" class="text-default mb-2" data-abc="true">Toshiba Notebook with 500GB</a>
                        </h6>
                            <a href="#" class="text-muted" style="color: #a7b3bd !important" data-abc="true">Laptops & Notebooks</a>
                        </div>
                        <h3 class="mb-0 font-weight-semibold" style="color:white;">$250.99</h3>
                            <div class="text-muted mb-3" style="color: #a7b3bd !important">34 reviews</div>
                            <a href="#" class="btn bg-cart" ><i class="fa fa-cart-plus mr-2"></i> Add to cart</a>                
                    </div>
                </div>                        
            </div> 
            <div class="col-md-4 mt-2">          
                <div class="card">
                    <div class="card-body" style="background-color: #807f84;">
                        <div class="card-img-actions">
                           <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" alt="">
                        </div>
                    </div>
                    <div class="card-body text-center" style=" background-color: #4b4b4e;">
                        <div class="mb-2">
                        <h6 class="font-weight-semibold mb-2">
                            <a href="#" class="text-default mb-2" data-abc="true">Toshiba Notebook with 500GB</a>
                        </h6>
                            <a href="#" class="text-muted" style="color: #a7b3bd !important" data-abc="true">Laptops & Notebooks</a>
                        </div>
                        <h3 class="mb-0 font-weight-semibold" style="color:white;">$250.99</h3>
                            <div class="text-muted mb-3" style="color: #a7b3bd !important">34 reviews</div>
                            <a href="#" class="btn bg-cart" ><i class="fa fa-cart-plus mr-2"></i> Add to cart</a>                
                    </div>
                </div>                        
            </div> 
        </div>
 </div>
</div>
            </div>
<?php
include_once($_SERVER['DOCUMENT_ROOT']."/front/includes/templates/footer.php");

