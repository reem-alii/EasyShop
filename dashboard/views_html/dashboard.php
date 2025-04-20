<?php include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/php_scripts/dashboard.php"); ?>

<div class="dashboard">
        <img src="http://localhost/EasyShop/dashboard/layouts/images/01186-RG.jpg" style="width: 1480px; height: 400px;">
         <!-- Statistics -->
    <div class="container home-stats text-center">
        <h1> Statistics </h1>
      <div class="row">
        <div class="col-md-4">
        <div class="card">
           <i class="fa-solid fa-users"></i>
             <div class="info">
               Total Users
             </div>
               <br><span><a href="http://localhost/EasyShop/dashboard/views_html/users/index.php"><?php echo countRows('users') ?></a></span>
          </div>
        </div>
        <div class="col-md-4">
            <div class="card">
             <i class="fa-solid fa-tag"></i>
               <div class="info">
                 Total Products
                </div>
                 <br><span><a href="http://localhost/EasyShop/dashboard/views_html/products/index.php"><?php echo countRows('products') ?></a></span>
             </div>
          </div>
        <div class="col-md-4">
           <div class="card">
            <i class="fa-solid fa-bag-shopping"></i>
              <div class="info">
                Total Orders
              </div>
                <br><span><a href="http://localhost/EasyShop/dashboard/views_html/orders/index.php"><?php echo countRows('orders') ; ?></a></span>
          </div>
        </div>
      </div>
    </div>
    <!-- /statistics -->

    </div>
<?php include_once($_SERVER['DOCUMENT_ROOT']."/EasyShop/dashboard/includes/templates/footer.php");
