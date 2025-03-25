<?php
include "init.php";
include "../includes/templates/navbar.php";
$products = getProducts() ;

?>
<div class="container products d-flex justify-content-center mt-50 mb-50">
            
        <div class="row">
            <?php foreach($products as $product){ ?>
           <div class="col-md-4 mt-2">          
                <div class="card">
                    <div class="card-body" style="background-color: #807f84;">
                        <div class="card-img-actions">
                           <!--<img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" width="96" height="350" alt="">-->
                           <img src="<?php echo $product['Image']; ?>" class="card-img img-fluid" width="96" height="350" alt="">               
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
                            <a href="#" class="btn bg-cart" style=" background-color:orange; color:#fff;"><i class="fa fa-cart-plus mr-2"></i> Add to cart</a>                
                    </div>
                </div>                        
            </div> 
            <?php } ?>


           <div class="col-md-4 mt-2">            
                
                <div class="card">
                                    <div class="card-body">
                                        <div class="card-img-actions">
                                            
                                                <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" width="96" height="350" alt="">
                                              
                                           
                                        </div>
                                    </div>

                                    <div class="card-body bg-light text-center">
                                        <div class="mb-2">
                                            <h6 class="font-weight-semibold mb-2">
                                                <a href="#" class="text-default mb-2" data-abc="true">Toshiba Notebook with 500GB HDD & 8GB RAM</a>
                                            </h6>

                                            <a href="#" class="text-muted" data-abc="true">Laptops & Notebooks</a>
                                        </div>

                                        <h3 class="mb-0 font-weight-semibold">$250.99</h3>

                                        <div>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                        </div>

                                        <div class="text-muted mb-3">34 reviews</div>

                                        <button type="button" class="btn bg-cart"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button>

                                        
                                    </div>
                                </div>


                            
                             
           </div> 

           <div class="col-md-4 mt-2">
            
                
                <div class="card">
                                    <div class="card-body">
                                        <div class="card-img-actions">
                                            
                                                <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" width="96" height="350" alt="">
                                              
                                           
                                        </div>
                                    </div>

                                    <div class="card-body bg-light text-center">
                                        <div class="mb-2">
                                            <h6 class="font-weight-semibold mb-2">
                                                <a href="#" class="text-default mb-2" data-abc="true">Toshiba Notebook with 500GB HDD & 8GB RAM</a>
                                            </h6>

                                            <a href="#" class="text-muted" data-abc="true">Laptops & Notebooks</a>
                                        </div>

                                        <h3 class="mb-0 font-weight-semibold">$250.99</h3>

                                        <div>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                        </div>

                                        <div class="text-muted mb-3">34 reviews</div>

                                        <button type="button" class="btn bg-cart"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button>

                                        
                                    </div>
                                </div>


                            
                             
           </div> 


           <div class="col-md-4 mt-2">
            
                
                <div class="card">
                                    <div class="card-body">
                                        <div class="card-img-actions">
                                            
                                                <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" width="96" height="350" alt="">
                                              
                                           
                                        </div>
                                    </div>

                                    <div class="card-body bg-light text-center">
                                        <div class="mb-2">
                                            <h6 class="font-weight-semibold mb-2">
                                                <a href="#" class="text-default mb-2" data-abc="true">Toshiba Notebook with 500GB HDD & 8GB RAM</a>
                                            </h6>

                                            <a href="#" class="text-muted" data-abc="true">Laptops & Notebooks</a>
                                        </div>

                                        <h3 class="mb-0 font-weight-semibold">$250.99</h3>

                                        <div>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                        </div>

                                        <div class="text-muted mb-3">34 reviews</div>

                                        <button type="button" class="btn bg-cart"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button>

                                        
                                    </div>
                                </div>


                            
                             
           </div> 


           <div class="col-md-4 mt-2">
            
                
                <div class="card">
                                    <div class="card-body">
                                        <div class="card-img-actions">
                                            
                                                <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" width="96" height="350" alt="">
                                              
                                           
                                        </div>
                                    </div>

                                    <div class="card-body bg-light text-center">
                                        <div class="mb-2">
                                            <h6 class="font-weight-semibold mb-2">
                                                <a href="#" class="text-default mb-2" data-abc="true">Toshiba Notebook with 500GB HDD & 8GB RAM</a>
                                            </h6>

                                            <a href="#" class="text-muted" data-abc="true">Laptops & Notebooks</a>
                                        </div>

                                        <h3 class="mb-0 font-weight-semibold">$250.99</h3>

                                        <div>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                        </div>

                                        <div class="text-muted mb-3">34 reviews</div>

                                        <button type="button" class="btn bg-cart"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button>

                                        
                                    </div>
                                </div>


                            
                             
           </div> 


           <div class="col-md-4 mt-2">
            
                
                <div class="card">
                                    <div class="card-body">
                                        <div class="card-img-actions">
                                            
                                                <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1562074043/234.png" class="card-img img-fluid" width="96" height="350" alt="">
                                              
                                           
                                        </div>
                                    </div>

                                    <div class="card-body bg-light text-center">
                                        <div class="mb-2">
                                            <h6 class="font-weight-semibold mb-2">
                                                <a href="#" class="text-default mb-2" data-abc="true">Toshiba Notebook with 500GB HDD & 8GB RAM</a>
                                            </h6>

                                            <a href="#" class="text-muted" data-abc="true">Laptops & Notebooks</a>
                                        </div>

                                        <h3 class="mb-0 font-weight-semibold">$250.99</h3>

                                        <div>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                           <i class="fa fa-star star"></i>
                                        </div>

                                        <div class="text-muted mb-3">34 reviews</div>

                                        <button type="button" class="btn bg-cart"><i class="fa fa-cart-plus mr-2"></i> Add to cart</button>

                                        
                                    </div>
                                </div>


                            
                             
           </div> 





        </div>
    </div>
<?php
include "../includes/templates/footer.php";
